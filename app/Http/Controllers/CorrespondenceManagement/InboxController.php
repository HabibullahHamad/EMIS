<?php

namespace App\Http\Controllers\CorrespondenceManagement;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class InboxController extends Controller
{
    public function __construct()
    {
        // Ensure the 'inbox' table exists so validation and queries do not fail
        if (!Schema::hasTable('inbox')) {
            Schema::create('inbox', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('letter_no')->unique();
                $table->string('subject', 255);
                $table->string('sender', 255);
                $table->date('received_date');
                $table->enum('priority', ['high', 'medium', 'low'])->nullable();
                // Match MySQL enum values: Unread, Read, Assigned, Completed
                $table->enum('status', ['Unread', 'Read', 'Assigned', 'Completed'])->nullable();
                $table->string('attachment')->nullable();
                $table->timestamps();
            });
        }
    }

    public function index()
    {
        $inbox = Inbox::orderBy('id', 'desc')->paginate(10);
        return view('CorrespondenceManagement.inbox.index', compact('inbox'));
    }

    public function create()
    {
        return view('CorrespondenceManagement.inbox.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'letter_no'      => 'required|unique:inbox,letter_no',
            'subject'        => 'required|string|max:255',
            'sender'         => 'required|string|max:255',
            'received_date'  => 'required|date',
            'priority'       => 'nullable|in:high,medium,low',
            // Updated status validation to match DB enum
            'status'         => 'nullable|in:Unread,Read,Assigned,Completed',
            'attachment'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only([
            'letter_no',
            'subject',
            'sender',
            'received_date',
            'priority',
            'status',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        
        Inbox::create($data);

        return redirect()->route('inbox.index')->with('success', 'Letter added to Inbox!');
    }

    public function show($id)
    {
        $letter = Inbox::findOrFail($id);
        return view('CorrespondenceManagement.inbox.show', compact('letter'));
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
            'letter_no'      => 'required|unique:inbox,letter_no,' . $id,
            'subject'        => 'required|string|max:255',
            'sender'         => 'required|string|max:255',
            'received_date'  => 'required|date',
            'priority'       => 'nullable|in:high,medium,low',
            // Updated status validation to match DB enum
            'status'         => 'nullable|in:Unread,Read,Assigned,Completed',
            'attachment'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only([
            'letter_no',
            'subject',
            'sender',
            'received_date',
            'priority',
            'status',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $letter->update($data);

        return redirect()->route('inbox.index')->with('success', 'Inbox updated!');
    }

    public function destroy($id)
    {
        $letter = Inbox::findOrFail($id);
        $letter->delete();

        return redirect()->route('inbox.index')->with('success', 'Inbox deleted!');
    }
}