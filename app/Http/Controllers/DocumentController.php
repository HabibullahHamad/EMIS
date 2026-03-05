<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{

    // LIST PAGE
    public function index()
    {
       $documents = Document::latest()->paginate(10);
        return view('documents.index', compact('documents'));



    

 
    }

    // STORE DATA
    public function store(Request $request)
    {
        $data = $request->validate([
            'doc_number'=>'required',
            'doc_date'=>'required',
            'receiver'=>'required',
            'subject'=>'required',
            'description'=>'nullable',
            'attachment'=>'nullable|file'
        ]);

        if($request->hasFile('attachment')){
            $data['attachment'] = $request->file('attachment')->store('documents');
        }

        Document::create($data);

        return redirect()->back()->with('success','Document saved');
    }

    // SHOW DETAILS
    public function show($id)
    {
        $document = Document::findOrFail($id);
        return view('documents.show', compact('document'));
    }

    // UPDATE
    public function update(Request $request,$id)
    {
        $document = Document::findOrFail($id);

        $document->update($request->all());

        return redirect()->route('documents.index');
    }

    // DELETE
    public function destroy($id)
    {
        Document::destroy($id);

        return redirect()->back();
    }

}