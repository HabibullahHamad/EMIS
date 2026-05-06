<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;





class DocumentController extends Controller
{
    // ================= INDEX + SEARCH =================
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
                $request->date_from,
                $request->date_to
            ]);
        }

        $documents = $query->latest()->paginate(6);

        return view('documents.index', compact('documents'));
    }

    // ================= CREATE =================
    public function create()
    {
        return view('documents.create');
    }

    // ================= STORE =================


  public function store(Request $request)
{
    $filePath = $request->file('file')->store('documents', 'public');

    $doc = Document::create([
        'document_number' => $this->generateDocumentNumber(),
        'title' => $request->title,
        'subject' => $request->subject,
        'organization' => $request->organization,
        'type' => $request->type,
        'status' => 'registered',
        'received_date' => $request->received_date ?? now(),
        'due_date' => $request->due_date,
        'created_by' => auth()->id(),
        'file_path' => $filePath,
        'priority' => $request->priority,
        'remarks' => $request->remarks,
    ]);

    // date
$received_date = null;
$due_date = null;

if ($request->received_date) {
    $received_date = Jalalian::fromFormat('Y/m/d', $request->received_date)
        ->toCarbon()
        ->format('Y-m-d');
}

if ($request->due_date) {
    $due_date = Jalalian::fromFormat('Y/m/d', $request->due_date)
        ->toCarbon()
        ->format('Y-m-d');
}

    // end

    DocumentHistory::create([
        'document_id' => $doc->id,
        'action' => 'registered',
        'from_user' => auth()->id(),
        'comments' => 'Document registered'
    ]);
    $received_date = null;
$due_date = null;

if ($request->received_date) {
    $received_date = Jalalian::fromFormat('Y/m/d', $request->received_date)
        ->toCarbon()
        ->format('Y-m-d');
}

if ($request->due_date) {
    $due_date = Jalalian::fromFormat('Y/m/d', $request->due_date)
        ->toCarbon()
        ->format('Y-m-d');
}

    return redirect()->route('documents.index')->with('success', 'Document created');
}

    // ================= SHOW =================
    public function show($id)
    {
       $document = Document::with([
    'histories.fromUser',
    'histories.toUser'
])->findOrFail($id);

        $users = User::all();

        return view('documents.show', compact('document', 'users'));
    }
    

    // ================= ASSIGN =================
    public function assign(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $doc = Document::findOrFail($id);

        $doc->update([
            'assigned_to' => $request->user_id,
            'status' => 'assigned',
        ]);

        DocumentHistory::create([
            'document_id' => $doc->id,
            'action' => 'assigned',
            'from_user' => auth()->id(),
            'to_user' => $request->user_id,
            'comments' => 'Assigned to user',
        ]);

        return back()->with('success', 'Document assigned successfully.');
    }

    // ================= RESPOND =================
    public function respond(Request $request, $id)
    {
        $request->validate([
            'response' => 'required|string',
        ]);

        $doc = Document::findOrFail($id);

        $doc->update([
            'status' => 'responded',
        ]);

        DocumentHistory::create([
            'document_id' => $doc->id,
            'action' => 'responded',
            'from_user' => auth()->id(),
            'comments' => $request->response,
        ]);

        return back()->with('success', 'Response added successfully.');
    }

    // ================= COMPLETE =================
    public function complete($id)
    {
        $doc = Document::findOrFail($id);

        $doc->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        DocumentHistory::create([
            'document_id' => $doc->id,
            'action' => 'completed',
            'from_user' => auth()->id(),
            'comments' => 'Document finalized',
        ]);

        return back()->with('success', 'Document completed.');
    }

    // ================= VIEW FILE =================
    public function view($id)
    {
        $doc = Document::findOrFail($id);

        if (!$doc->file_path || !Storage::disk('public')->exists($doc->file_path)) {
            abort(404, 'File not found');
        }

        return response()->file(storage_path('app/public/' . $doc->file_path));
    }

    // ================= DOCUMENT NUMBER =================
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

    // ================= EXPORT PDF =================

public function exportPdf($id)
{
    $document = Document::findOrFail($id);

    // 🔥 QR CODE (Endroid)
 

$summary = "Document No: {$document->document_number}\n"
          ."Title: {$document->title}\n"
          ."Status: {$document->status}\n"
          ."Date: {$document->created_at->format('Y-m-d')}\n"
          ."Verify: " . route('documents.show', $document->id);

$result = \Endroid\QrCode\Builder\Builder::create()
    ->writer(new \Endroid\QrCode\Writer\PngWriter())
    ->data($summary)
    ->size(160) // slightly bigger
    ->build();

$qr = base64_encode($result->getString());

    $qr = base64_encode($result->getString());

    // 🔥 PDF GENERATION
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('documents.pdf', compact('document', 'qr'))
        ->setPaper('A4', 'portrait');

    // 🔥 SAFE FILE NAME
    $safeNumber = str_replace(['/', '\\'], '-', $document->document_number);
    $fileName = 'Document_' . $safeNumber . '.pdf';

    return $pdf->stream($fileName);
}

public function exportPdfOld($id)
{
    $document = Document::findOrFail($id);

    // 🔥 3. Safe filename (IMPORTANT FIX included)
    $safeNumber = str_replace(['/', '\\'], '-', $document->document_number);
    $fileName = 'Document_' . $safeNumber . '.pdf';

    return $pdf->stream($fileName);
}
public function exportReport(Request $request)
{
    $query = Document::with([
        'creator',
        'assignedUser',
        'histories.fromUser',
        'histories.toUser'
    ]);

    // 🔍 Optional filters
    if ($request->filled('date_from') && $request->filled('date_to')) {
        $query->whereBetween('received_date', [
            $request->date_from,
            $request->date_to
        ]);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $documents = $query->latest()->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'documents.report',
        compact('documents')
    )->setPaper('A4', 'portrait');

    return $pdf->download('EMIS_Documents_Report.pdf');
}
public function edit($id)
{
    $document = Document::findOrFail($id);

    return view('documents.edit', compact('document'));
}

public function update(Request $request, $id)
{
    $doc = Document::findOrFail($id);

    // Handle file replacement
    if ($request->hasFile('file')) {

        // delete old file
        if ($doc->file_path && Storage::disk('public')->exists($doc->file_path)) {
            Storage::disk('public')->delete($doc->file_path);
        }

        $filePath = $request->file('file')->store('documents', 'public');
        $doc->file_path = $filePath;
    }

    // Update fields
    $doc->update([
        'title' => $request->title,
        'subject' => $request->subject,
        'organization' => $request->organization,
        'type' => $request->type,
        'received_date' => $request->received_date,
        'due_date' => $request->due_date,
        'priority' => $request->priority,
        'remarks' => $request->remarks,
    ]);

    // Log history
    DocumentHistory::create([
        'document_id' => $doc->id,
        'action' => 'updated',
        'from_user' => auth()->id(),
        'comments' => 'Document updated'
    ]);

    return redirect()->route('documents.show', $doc->id)
        ->with('success', 'Document updated successfully');
}
}