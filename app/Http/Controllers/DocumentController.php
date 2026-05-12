<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();

        if ($request->filled('number')) {
            $query->where('document_number', 'like', "%{$request->number}%");
        }

        if ($request->filled('title')) {
            $query->where('title', 'like', "%{$request->title}%");
        }

        if ($request->filled('type')) {
            $query->where('type', 'like', "%{$request->type}%");
        }

        if ($request->filled('organization')) {
            $query->where('organization', 'like', "%{$request->organization}%");
        }

        if ($request->filled('subject')) {
            $query->where('subject', 'like', "%{$request->subject}%");
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('received_date', [
                $this->convertShamsiToGregorian($request->date_from),
                $this->convertShamsiToGregorian($request->date_to),
            ]);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'subject'       => 'nullable|string',
            'organization'  => 'nullable|string|max:255',
            'type'          => 'nullable|string|max:100',
            'received_date' => 'nullable|string',
            'due_date'      => 'nullable|string',
            'priority'      => 'nullable|string|max:50',
            'remarks'       => 'nullable|string',
            'file'          => 'nullable|file|max:10240',
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
        }

        $document = Document::create([
            'document_number' => $this->generateDocumentNumber(),
            'title'           => $data['title'],
            'subject'         => $data['subject'] ?? null,
            'organization'    => $data['organization'] ?? null,
            'type'            => $data['type'] ?? null,
            'status'          => 'registered',
            'received_date'   => $this->convertShamsiToGregorian($request->received_date) ?? now()->format('Y-m-d'),
            'due_date'        => $this->convertShamsiToGregorian($request->due_date),
            'created_by'      => auth()->id(),
            'file_path'       => $filePath,
            'priority'        => $data['priority'] ?? null,
            'remarks'         => $data['remarks'] ?? null,
        ]);

        DocumentHistory::create([
            'document_id' => $document->id,
            'action'      => 'registered',
            'from_user'   => auth()->id(),
            'comments'    => 'Document registered',
        ]);

        if (function_exists('audit_log')) {
            audit_log('created', $document, null, $document->toArray());
        }

        return redirect()
            ->route('documents.index')
            ->with('success', 'Document created successfully.');
    }

    public function show($id)
    {
        $document = Document::with([
            'histories.fromUser',
            'histories.toUser',
        ])->findOrFail($id);

        $users = User::orderBy('name')->get();

        return view('documents.show', compact('document', 'users'));
    }

    public function edit($id)
    {
        $document = Document::findOrFail($id);

        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $oldValues = $document->getOriginal();

        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'subject'       => 'nullable|string',
            'organization'  => 'nullable|string|max:255',
            'type'          => 'nullable|string|max:100',
            'received_date' => 'nullable|string',
            'due_date'      => 'nullable|string',
            'priority'      => 'nullable|string|max:50',
            'remarks'       => 'nullable|string',
            'file'          => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('file')) {
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $document->file_path = $request->file('file')->store('documents', 'public');
        }

        $document->update([
            'title'         => $data['title'],
            'subject'       => $data['subject'] ?? null,
            'organization'  => $data['organization'] ?? null,
            'type'          => $data['type'] ?? null,
            'received_date' => $this->convertShamsiToGregorian($request->received_date),
            'due_date'      => $this->convertShamsiToGregorian($request->due_date),
            'priority'      => $data['priority'] ?? null,
            'remarks'       => $data['remarks'] ?? null,
            'file_path'     => $document->file_path,
        ]);

        DocumentHistory::create([
            'document_id' => $document->id,
            'action'      => 'updated',
            'from_user'   => auth()->id(),
            'comments'    => 'Document updated',
        ]);

        if (function_exists('audit_log')) {
            audit_log('updated', $document, $oldValues, $document->getChanges());
        }

        return redirect()
            ->route('documents.show', $document->id)
            ->with('success', 'Document updated successfully.');
    }

    public function assign(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $document = Document::findOrFail($id);

        $oldValues = $document->getOriginal();

        $document->update([
            'assigned_to' => $request->user_id,
            'status'      => 'assigned',
        ]);

        DocumentHistory::create([
            'document_id' => $document->id,
            'action'      => 'assigned',
            'from_user'   => auth()->id(),
            'to_user'     => $request->user_id,
            'comments'    => 'Assigned to user',
        ]);

        if (function_exists('audit_log')) {
            audit_log('assigned', $document, $oldValues, $document->getChanges());
        }

        return back()->with('success', 'Document assigned successfully.');
    }

    public function respond(Request $request, $id)
    {
        $request->validate([
            'response' => 'required|string',
        ]);

        $document = Document::findOrFail($id);

        $oldValues = $document->getOriginal();

        $document->update([
            'status' => 'responded',
        ]);

        DocumentHistory::create([
            'document_id' => $document->id,
            'action'      => 'responded',
            'from_user'   => auth()->id(),
            'comments'    => $request->response,
        ]);

        if (function_exists('audit_log')) {
            audit_log('responded', $document, $oldValues, $document->getChanges());
        }

        return back()->with('success', 'Response added successfully.');
    }

    public function complete($id)
    {
        $document = Document::findOrFail($id);

        $oldValues = $document->getOriginal();

        $document->update([
            'status'       => 'completed',
            'completed_at' => now(),
        ]);

        DocumentHistory::create([
            'document_id' => $document->id,
            'action'      => 'completed',
            'from_user'   => auth()->id(),
            'comments'    => 'Document finalized',
        ]);

        if (function_exists('audit_log')) {
            audit_log('completed', $document, $oldValues, $document->getChanges());
        }

        return back()->with('success', 'Document completed.');
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        $oldValues = $document->toArray();

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        if (function_exists('audit_log')) {
            audit_log('deleted', $document, $oldValues, null);
        }

        $document->delete();

        return redirect()
            ->route('documents.index')
            ->with('success', 'Document deleted successfully.');
    }

    public function view($id)
    {
        $document = Document::findOrFail($id);

        if (!$document->file_path || !Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found');
        }

        return response()->file(storage_path('app/public/' . $document->file_path));
    }

    public function exportPdf($id)
    {
        $document = Document::findOrFail($id);

        $summary = "Document No: {$document->document_number}\n"
            . "Title: {$document->title}\n"
            . "Status: {$document->status}\n"
            . "Date: {$document->created_at->format('Y-m-d')}\n"
            . "Verify: " . route('documents.show', $document->id);

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($summary)
            ->size(160)
            ->build();

        $qr = base64_encode($result->getString());

        $html = view('documents.pdf', compact('document', 'qr'))->render();

        $mpdf = $this->makeMpdf('A4');

        $mpdf->WriteHTML($html);

        $safeNumber = str_replace(['/', '\\'], '-', $document->document_number);

        return response($mpdf->Output("Document_{$safeNumber}.pdf", 'S'))
            ->header('Content-Type', 'application/pdf');
    }

    public function exportReport(Request $request)
    {
        $query = Document::with([
            'creator',
            'assignedUser',
            'histories.fromUser',
            'histories.toUser',
        ]);

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('received_date', [
                $this->convertShamsiToGregorian($request->date_from),
                $this->convertShamsiToGregorian($request->date_to),
            ]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $documents = $query->latest()->get();

        $html = view('documents.report', compact('documents'))->render();

        $mpdf = $this->makeMpdf('A4-L');

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('EMIS_Documents_Report.pdf', 'S'))
            ->header('Content-Type', 'application/pdf');
    }

    private function generateDocumentNumber()
    {
        $year = date('Y');

        $last = Document::whereYear('created_at', $year)
            ->orderByDesc('id')
            ->first();

        $number = $last
            ? ((int) substr($last->document_number, -4)) + 1
            : 1;

        return "EMIS/{$year}/" . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    private function convertShamsiToGregorian($date)
    {
        if (!$date) {
            return null;
        }

        try {
            if (function_exists('fa_to_en')) {
                $date = fa_to_en($date);
            }

            $date = str_replace('-', '/', $date);

            if (preg_match('/^1[34][0-9]{2}\/[0-9]{1,2}\/[0-9]{1,2}$/', $date)) {
                return Jalalian::fromFormat('Y/m/d', $date)
                    ->toCarbon()
                    ->format('Y-m-d');
            }

            return Carbon::parse($date)->format('Y-m-d');

        } catch (\Exception $e) {
            return null;
        }
    }

    private function makeMpdf($format = 'A4')
    {
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => $format,

            'fontDir' => array_merge($fontDirs, [
                public_path('fonts'),
            ]),

            'fontdata' => $fontData + [
                'notonaskh' => [
                    'R' => 'NotoNaskhArabic-Regular.ttf',
                    'B' => 'NotoNaskhArabic-Bold.ttf',
                ],
                'notosansarabic' => [


                
                    'R' => 'NotoSansArabic-Regular.ttf',
                ],
            ],

            'default_font' => 'notonaskh',

            'autoScriptToLang' => true,
            'autoLangToFont' => true,

            'margin_top' => 12,
            'margin_bottom' => 12,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);

        $mpdf->SetDirectionality('rtl');

        return $mpdf;
    }
}