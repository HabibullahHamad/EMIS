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
                $table->string('receiver', 255);
                $table->date('received_date');
                $table->string('summary');
                $table->enum('priority', ['H', 'M', 'L'])->nullable();
                // Match MySQL enum values: Unread, Read, Assigned, Completed
                $table->enum('status', ['Unread', 'Read', 'Assigned', 'Completed'])->nullable();
                $table->string('attachment')->nullable();
                $table->timestamps();
            });
        }
    }

    public function index()
    {
        $inbox = Inbox::orderBy('id', 'desc')->paginate(14);
        return view('CorrespondenceManagement.inbox.index', compact('inbox'));
    }
// for create 
    public function create()
    {
        return view('CorrespondenceManagement.inbox.create');
    }

// store
    public function store(Request $request)
    {

      $request->validate([
    'letter_no' => 'required',
    'subject' => 'required',
    'sender' => 'required',
    'receiver' => 'required',
    'received_date' => 'required',
    'summary' => 'required',
  
    'attachment' => 'nullable|file|max:2048'
]);

        $data = $request->only([
            'letter_no',
            'subject',
            'sender',
            'receiver',
            'received_date',
            'summary',
            'attachment',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        
        Inbox::create($data);

        return redirect()->route('inbox.index')->with('success', 'لیګ په بریالیتوب سره خوندي شو!');
    }

// show
public function show($id)
{
    $inbox = Inbox::findOrFail($id);

    return view('CorrespondenceManagement.inbox.show', compact('inbox'));
}
  
// edit function 

    public function edit($id)
    {
        $letter = Inbox::findOrFail($id);
        return view('CorrespondenceManagement.inbox.edit', compact('letter'));
    }


    // update function 
    public function update(Request $request, $id)
    {
        $letter = Inbox::findOrFail($id);

        $request->validate([
            'letter_no'      => 'required|unique:inbox,letter_no,' . $id,
            'subject'        => 'required|string|max:255',
            'sender'         => 'required|string|max:255',
            'receiver'       => 'required|string|max:255',
            'received_date'  => 'required|date',
           
            // Updated status validation to match DB enum
            
            'attachment'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only([
            'letter_no',
            'subject',
            'sender',
            'receiver',
            'received_date',
          
             'attachment',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $letter->update($data);

        return redirect()->route('inbox.index')->with('success', 'Inbox updated!');
    }

// destroy function 

    public function destroy($id)
    {
        $letter = Inbox::findOrFail($id);
        $letter->delete();

        return redirect()->route('inbox.index')->with('success', 'one Record is deleted!');
    }


    
    public function main()
{
      $letter = Inbox::latest()->get(); // ✅ REQUIRED

    return view('CorrespondenceManagement.main', compact('inbox'));
}
}



// new controller 
