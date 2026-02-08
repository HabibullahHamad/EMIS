<?php

namespace App\Http\Controllers;
use App\Models\Outgoing;
use Illuminate\Http\Request;   
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
class OutgoingController extends Controller
{
    public function __construct()
    {
        // Ensure the 'outgoing' table exists so validation and queries do not fail
        if (!Schema::hasTable('outgoing')) {
            Schema::create('outgoing', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('letter_no')->unique();
                $table->string('subject', 255);
                $table->string('recipient', 255);
                $table->date('sent_date');
                $table->enum('priority', ['high', 'medium', 'low'])->nullable();
                // Match MySQL enum values: Draft, Sent, Delivered, Archived
                $table->enum('status', ['Draft', 'Sent', 'Delivered', 'Archived'])->nullable();
                $table->string('attachment')->nullable();
                $table->timestamps();
            });
        }
    }
    public function index()
    {
        $outgoing = Outgoing::orderBy('id', 'desc')->paginate(11);
        return view('CorrespondenceManagement.outgoing.index', compact('outgoing'));
    }
    public function create()
    {
        return view('CorrespondenceManagement.outgoing.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'letter_no'      => 'required|unique:outgoing,letter_no',
            'subject'        => 'required|string|max:255',
            'recipient'      => 'required|string|max:255',
            'sent_date'      => 'required|date',
            'priority'       => 'nullable|in:high,medium,low',
            // Updated status validation to match DB enum
            'status'         => 'nullable|in:Draft,Sent,Delivered,Archived',
            'attachment'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only([
            'letter_no',
            'subject',
            'recipient',
            'sent_date',
            'priority',
            'status',
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('attachments/outgoing'), $filename);
            $data['attachment'] = 'attachments/outgoing/' . $filename;
        }

        Outgoing::create($data);

        return redirect()->route('outgoing.index')->with('success', 'Outgoing letter created successfully.');
    }   

    public function show($id)
    {
        $outgoing = Outgoing::findOrFail($id);
        return view('CorrespondenceManagement.outgoing.show', compact('outgoing'));
    }
}