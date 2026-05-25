<?php

namespace App\Http\Controllers\CorrespondenceManagement;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class InboxController extends Controller
{
    public function index()
    {
        $inbox = Inbox::latest()->paginate(10);

        return view('CorrespondenceManagement.inbox.index', compact('inbox'));
    }

    public function create()
    {
        return view('CorrespondenceManagement.inbox.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'letter_no' => 'required|string|max:255|unique:inbox,letter_no',
            'order_number' => 'nullable|string|max:100',
            'subject' => 'required|string|max:255',
            'sender' => 'required|string|max:255',
            'receiver' => 'required|string|max:255',
            'received_date' => 'required|date',
            'summary' => 'nullable|string',
            'priority' => 'required|in:High,Medium,Low',
            'status' => 'nullable|in:Unread,Read,Assigned,Completed',
            'assigned_to' => 'nullable|string|max:255',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|max:20480',
        ]);

        $files = [];
        $names = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $files[] = $file->store('inbox', 'public');
                $names[] = $file->getClientOriginalName();
            }
        }
        
       $data['priority'] = $request->priority ?? 'Medium';
        $data['status'] = $data['status'] ?? 'Unread';
        $data['attachment'] = json_encode($files);
        $data['attachment_names'] = json_encode($names);
        $data['status'] = $data['status'] ?? 'Unread';

        
        $letter = Inbox::create($data);

        if (function_exists('audit_log')) {
            audit_log('created', $letter, null, $letter->toArray());
        }

        return redirect()->route('inbox.index')
            ->with('success', 'Incoming document created successfully.');
  
    }

    public function show($id)
    {
        $inbox = Inbox::findOrFail($id);

        return view('CorrespondenceManagement.inbox.show', compact('inbox'));
    }

    public function edit($id)
    {
        $letter = Inbox::findOrFail($id);

        return view('CorrespondenceManagement.inbox.edit', compact('letter'));
    }

    public function update(Request $request, $id)
    {
        $letter = Inbox::findOrFail($id);

        $data = $request->validate([
            'letter_no' => 'required|string|max:255|unique:inbox,letter_no,' . $id,
            'order_number' => 'nullable|string|max:100',
            'subject' => 'required|string|max:255',
            'sender' => 'required|string|max:255',
            'receiver' => 'required|string|max:255',
            'received_date' => 'required|date',
            'summary' => 'nullable|string',
            'priority' => 'required|in:High,Medium,Low',

            'status' => 'nullable|in:Unread,Read,Assigned,Completed',
            'assigned_to' => 'nullable|string|max:255',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|max:20480',
        ]);

        $oldValues = $letter->getOriginal();

        if ($request->hasFile('attachments')) {
            $oldFiles = json_decode($letter->attachment, true);

            if (!is_array($oldFiles)) {
                $oldFiles = $letter->attachment ? [$letter->attachment] : [];
            }

            foreach ($oldFiles as $oldFile) {
                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }
            }

            $files = [];
            $names = [];

            foreach ($request->file('attachments') as $file) {
                $files[] = $file->store('inbox', 'public');
                $names[] = $file->getClientOriginalName();
            }

            $data['attachment'] = json_encode($files);
            $data['attachment_names'] = json_encode($names);
        }

        $letter->update($data);

        if (function_exists('audit_log')) {
            audit_log('updated', $letter, $oldValues, $letter->getChanges());
        }

        return redirect()->route('inbox.index')
            ->with('success', 'Incoming document updated successfully.');
    }

    public function destroy($id)
    {
        $letter = Inbox::findOrFail($id);

        $oldValues = $letter->toArray();

        $files = json_decode($letter->attachment, true);

        if (!is_array($files)) {
            $files = $letter->attachment ? [$letter->attachment] : [];
        }

        foreach ($files as $file) {
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }

        if (function_exists('audit_log')) {
            audit_log('deleted', $letter, $oldValues, null);
        }

        $letter->delete();

        return redirect()->route('inbox.index')
            ->with('success', 'Incoming document deleted successfully.');
    }
    public function combinePdf($id)
    {
        $inbox = Inbox::findOrFail($id);

        $files = json_decode($inbox->attachment, true);

        if (!is_array($files)) {
            $files = $inbox->attachment ? [$inbox->attachment] : [];
        }

        $pdf = new Fpdi();

        foreach ($files as $file) {
            $path = storage_path('app/public/' . $file);

            if (!file_exists($path)) {
                continue;
            }

            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

            if ($ext === 'pdf') {
                $count = $pdf->setSourceFile($path);

                for ($i = 1; $i <= $count; $i++) {
                    $tpl = $pdf->importPage($i);
                    $size = $pdf->getTemplateSize($tpl);

                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($tpl);
                }
            }

            if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $pdf->AddPage();
                $pdf->Image($path, 10, 20, 180);
            }
        }

        return response($pdf->Output('S', 'inbox-combined.pdf'))
            ->header('Content-Type', 'application/pdf');
    }
}