<?php

namespace App\Http\Controllers;

use App\Models\OutgoingDocument;
use App\Models\Notification;
use App\Models\User;
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
        $users = User::orderBy('name')->get();
        return view('CorrespondenceManagement.outbox.create', compact('users'));
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
            'assigned_to' => 'required|exists:users,id',
            'department'  => 'required',
            'description' => 'nullable',
            'attachment'  => 'nullable|file',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('documents', 'public');
        }

        $document = OutgoingDocument::create($data);

        if (function_exists('audit_log')) {
            audit_log('created', $document, null, $document->toArray());
        }

        if (function_exists('notify_user')) {
            notify_user(
                $data['assigned_to'],
                'New Outgoing Document',
                'A new outgoing document has been assigned to you.',
                'document',
                $data['priority'] ?? 'normal',
                $document
            );
        } else {
            Notification::create([
                'user_id' => $data['assigned_to'],
                'title' => 'New Outgoing Document',
                'message' => 'A new outgoing document has been assigned to you.',
                'type' => 'document',
                'priority' => $data['priority'] ?? 'normal',
                'related_type' => OutgoingDocument::class,
                'related_id' => $document->id,
            ]);
        }

        return redirect()
            ->route('CorrespondenceManagement.outbox.index')
            ->with('success', 'Outgoing document created successfully.');
    }

    public function show($id)
    {
        $document = OutgoingDocument::findOrFail($id);

        if (function_exists('audit_log')) {
            audit_log('viewed', $document, null, $document->toArray());
        }

        return view('CorrespondenceManagement.outbox.show', compact('document'));
    }

    public function edit($id)
    {
        $document = OutgoingDocument::findOrFail($id);
        $users = User::orderBy('name')->get();

        if (function_exists('audit_log')) {
            audit_log('edit_opened', $document, null, $document->toArray());
        }

        return view('CorrespondenceManagement.outbox.edit', compact('document', 'users'));
    }

    public function update(Request $request, $id)
    {
        $document = OutgoingDocument::findOrFail($id);
        $oldValues = $document->getOriginal();
        $oldAssignedTo = $document->assigned_to;

        $data = $request->validate([
            'doc_number'  => 'required',
            'subject'     => 'required',
            'sender'      => 'required',
            'receiver'    => 'required',
            'doc_date'    => 'required',
            'priority'    => 'required',
            'assigned_to' => 'required|exists:users,id',
            'department'  => 'required',
            'description' => 'nullable',
            'attachment'  => 'nullable|file',
        ]);

        if ($request->hasFile('attachment')) {
            if ($document->attachment && Storage::disk('public')->exists($document->attachment)) {
                Storage::disk('public')->delete($document->attachment);
            }

            $data['attachment'] = $request->file('attachment')->store('documents', 'public');
        }

        $document->update($data);

        if (function_exists('audit_log')) {
            audit_log('updated', $document, $oldValues, $document->getChanges());
        }

        if (function_exists('notify_user')) {
            notify_user(
                $data['assigned_to'],
                'Outgoing Document Updated',
                'An outgoing document assigned to you has been updated.',
                'document',
                $data['priority'] ?? 'normal',
                $document
            );

            if ($oldAssignedTo && $oldAssignedTo != $data['assigned_to']) {
                notify_user(
                    $oldAssignedTo,
                    'Outgoing Document Reassigned',
                    'An outgoing document was reassigned from you to another user.',
                    'document',
                    'normal',
                    $document
                );
            }
        }

        return redirect()
            ->route('CorrespondenceManagement.outbox.index')
            ->with('success', 'Outgoing document updated successfully.');
    }

    public function destroy($id)
    {
        $document = OutgoingDocument::findOrFail($id);
        $oldValues = $document->toArray();
        $assignedTo = $document->assigned_to;

        if (function_exists('audit_log')) {
            audit_log('deleted', $document, $oldValues, null);
        }

        if ($document->attachment && Storage::disk('public')->exists($document->attachment)) {
            Storage::disk('public')->delete($document->attachment);
        }

        $document->delete();

        if ($assignedTo && function_exists('notify_user')) {
            notify_user(
                $assignedTo,
                'Outgoing Document Deleted',
                'An outgoing document assigned to you has been deleted.',
                'document',
                'high'
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Outgoing document deleted successfully.');
    }
}