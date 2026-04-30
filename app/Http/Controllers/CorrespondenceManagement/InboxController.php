<?php

namespace App\Http\Controllers\CorrespondenceManagement;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Storage;

class InboxController extends Controller
{
    public function __construct()
    {
        if (!Schema::hasTable('inbox')) {
            Schema::create('inbox', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('letter_no')->unique();
                $table->string('subject', 255);
                $table->string('sender', 255);
                $table->string('receiver', 255);
                $table->date('received_date');
                $table->string('summary');
                $table->enum('priority', ['H', 'M', 'L'])->nullable();
                $table->enum('status', ['Unread', 'Read', 'Assigned', 'Completed'])->nullable();
                $table->string('attachment')->nullable();
                $table->timestamps();
            });
        }
    }

    public function index()
    {
        $inbox = Inbox::latest()->paginate(14);

        return view('CorrespondenceManagement.inbox.index', compact('inbox'));
    }

    public function form()
    {
        return view('CorrespondenceManagement.inbox.form');
    }

    public function create()
    {
        return view('CorrespondenceManagement.inbox.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'letter_no' => 'required|string|max:255|unique:inbox,letter_no',
            'subject' => 'required|string|max:255',
            'sender' => 'required|string|max:255',
            'receiver' => 'required|string|max:255',
            'received_date' => 'required|date',
            'summary' => 'required|string',
            'priority' => 'nullable|in:H,M,L',
            'status' => 'nullable|in:Unread,Read,Assigned,Completed',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'letter_no',
            'subject',
            'sender',
            'receiver',
            'received_date',
            'summary',
            'priority',
            'status',
        ]);

        $data['status'] = $data['status'] ?? 'Unread';

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $letter = Inbox::create($data);

        if (function_exists('audit_log')) {
            audit_log('created', $letter, null, $letter->toArray());
        }

        // ✅ NOTIFICATION: safe user_id, never null
        if (function_exists('notify_user')) {
            notify_user(
                auth()->id(),
                'New Incoming Document',
                'A new incoming document has been registered in the inbox.',
                'document',
                'high',
                $letter
            );
        } else {
            Notification::create([
                'user_id' => auth()->id(),
                'title' => 'New Incoming Document',
                'message' => 'A new incoming document has been registered in the inbox.',
                'type' => 'document',
                'priority' => 'high',
                'related_type' => Inbox::class,
                'related_id' => $letter->id,
            ]);
        }

        return redirect()
            ->route('inbox.index')
            ->with('success', 'لیګ په بریالیتوب سره خوندي شو!');
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

        $request->validate([
            'letter_no' => 'required|string|max:255|unique:inbox,letter_no,' . $id,
            'subject' => 'required|string|max:255',
            'sender' => 'required|string|max:255',
            'receiver' => 'required|string|max:255',
            'received_date' => 'required|date',
            'summary' => 'nullable|string',
            'priority' => 'nullable|in:H,M,L',
            'status' => 'nullable|in:Unread,Read,Assigned,Completed',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $oldValues = $letter->getOriginal();

        $data = $request->only([
            'letter_no',
            'subject',
            'sender',
            'receiver',
            'received_date',
            'summary',
            'priority',
            'status',
        ]);

        if ($request->hasFile('attachment')) {
            if (!empty($letter->attachment)) {
                Storage::disk('public')->delete($letter->attachment);
            }

            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $letter->update($data);

        if (function_exists('audit_log')) {
            audit_log('updated', $letter, $oldValues, $letter->getChanges());
        }

        // ✅ NOTIFICATION: document updated
        if (function_exists('notify_user')) {
            notify_user(
                auth()->id(),
                'Incoming Document Updated',
                'An incoming document has been updated.',
                'document',
                'normal',
                $letter
            );
        } else {
            Notification::create([
                'user_id' => auth()->id(),
                'title' => 'Incoming Document Updated',
                'message' => 'An incoming document has been updated.',
                'type' => 'document',
                'priority' => 'normal',
                'related_type' => Inbox::class,
                'related_id' => $letter->id,
            ]);
        }

        return redirect()
            ->route('inbox.index')
            ->with('success', 'Inbox updated!');
    }

    public function destroy($id)
    {
        $letter = Inbox::findOrFail($id);

        $oldValues = $letter->toArray();

        if (function_exists('audit_log')) {
            audit_log('deleted', $letter, $oldValues, null);
        }

        if (!empty($letter->attachment)) {
            Storage::disk('public')->delete($letter->attachment);
        }

        $letter->delete();

        // ✅ NOTIFICATION: document deleted
        if (function_exists('notify_user')) {
            notify_user(
                auth()->id(),
                'Incoming Document Deleted',
                'An incoming document has been deleted.',
                'document',
                'high'
            );
        } else {
            Notification::create([
                'user_id' => auth()->id(),
                'title' => 'Incoming Document Deleted',
                'message' => 'An incoming document has been deleted.',
                'type' => 'document',
                'priority' => 'high',
            ]);
        }

        return redirect()
            ->route('inbox.index')
            ->with('success', 'one Record is deleted!');
    }

    public function main()
    {
        $letter = Inbox::latest()->get();

        return view('CorrespondenceManagement.inbox', compact('letter'));
    }
}