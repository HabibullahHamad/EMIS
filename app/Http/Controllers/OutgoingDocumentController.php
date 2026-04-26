<?php

namespace App\Http\Controllers;

use App\Models\OutgoingDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OutgoingDocumentController extends Controller
{
    public function index()
    {
        $documents = OutgoingDocument::latest()->paginate(15);

        return view('CorrespondenceManagement.outbox.index', compact('documents'));
    }

    public function create()
    {
        return view('CorrespondenceManagement.outbox.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'doc_number'  => 'required',
            'subject'     => 'required',
            'sender'      => 'required',
            'receiver'    => 'required',
            'doc_date'    => 'required',
            'priority'    => 'required',
            'assigned_to' => 'required',
            'department'  => 'required',
            'description' => 'nullable',
            'attachment'  => 'nullable|file',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('documents', 'public');
        }

        $document = OutgoingDocument::create($data);

        // NEW: Audit log for create
        if (function_exists('audit_log')) {
            audit_log('created', $document, null, $document->toArray());
        }

        return redirect()->route('CorrespondenceManagement.outbox.index');
    }

    public function show($id)
    {
        $document = OutgoingDocument::findOrFail($id);

        // NEW: Audit log for view/show
        if (function_exists('audit_log')) {
            audit_log('viewed', $document, null, $document->toArray());
        }

        return view('CorrespondenceManagement.outbox.show', compact('document'));
    }

    public function edit($id)
    {
        $document = OutgoingDocument::findOrFail($id);

        // NEW: Audit log for edit page open
        if (function_exists('audit_log')) {
            audit_log('edit_opened', $document, null, $document->toArray());
        }

        return view('CorrespondenceManagement.outbox.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        $document = OutgoingDocument::findOrFail($id);

        // NEW: keep old values before update
        $oldValues = $document->getOriginal();

        $data = $request->validate([
            'doc_number'  => 'required',
            'subject'     => 'required',
            'sender'      => 'required',
            'receiver'    => 'required',
            'doc_date'    => 'required',
            'priority'    => 'required',
            'assigned_to' => 'required',
            'department'  => 'required',
            'description' => 'nullable',
            'attachment'  => 'nullable|file',
        ]);

        if ($request->hasFile('attachment')) {
            // NEW: delete old attachment if exists
            if ($document->attachment && Storage::disk('public')->exists($document->attachment)) {
                Storage::disk('public')->delete($document->attachment);
            }

            $data['attachment'] = $request->file('attachment')->store('documents', 'public');
        }

        $document->update($data);

        // NEW: Audit log for update
        if (function_exists('audit_log')) {
            audit_log('updated', $document, $oldValues, $document->getChanges());
        }

        return redirect()->route('CorrespondenceManagement.outbox.index');
    }

    public function destroy($id)
    {
        $document = OutgoingDocument::findOrFail($id);

        // NEW: keep old values before delete
        $oldValues = $document->toArray();

        // NEW: Audit log before delete
        if (function_exists('audit_log')) {
            audit_log('deleted', $document, $oldValues, null);
        }

        // NEW: delete attachment file if exists
        if ($document->attachment && Storage::disk('public')->exists($document->attachment)) {
            Storage::disk('public')->delete($document->attachment);
        }

        $document->delete();

        return redirect()->back();
    }
}