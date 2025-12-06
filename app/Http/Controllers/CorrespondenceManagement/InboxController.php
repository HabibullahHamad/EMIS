<?php

namespace App\Http\Controllers\CorrespondenceManagement;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use Illuminate\Http\Request;

class InboxController extends Controller
{
   
public function index()
{
    $inbox = Inbox::orderBy('id', 'desc')->get();

    return view('CorrespondenceManagement.inbox.index', compact('inbox'));
}

    public function create()
    {
        return view('CorrespondenceManagement.inbox.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'letter_no'      => 'required|unique:inbox',
            'subject'        => 'required',
            'sender'         => 'required',
            'received_date'  => 'required|date',
        ]);

        Inbox::create($request->all());

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
        $letter->update($request->all());

        return redirect()->route('inbox.index')->with('success', 'Inbox updated!');
    }

    public function destroy($id)
    {
        Inbox::findOrFail($id)->delete();
        return redirect()->route('inbox.index')->with('success', 'Inbox deleted!');
    }
}
