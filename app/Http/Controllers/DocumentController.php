<?php

namespace App\Http\Controllers;

use App\Models\Document;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    // INDEX + SEARCH
    public function index(Request $request)
    {
        $query = Document::query();

        if($request->document_no){
            $query->where('document_no','like','%'.$request->document_no.'%');
        }

        if($request->subject){
            $query->where('subject','like','%'.$request->subject.'%');
        }

        if($request->status){
            $query->where('status',$request->status);
        }

        if($request->type){
            $query->where('type',$request->type);
        }

        $documents = $query->latest()->paginate(10);

        return view('documents.index',compact('documents'));
    }

    

    // CREATE PAGE
    public function create()
    {
        return view('documents.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'document_no' => 'required',
            'subject' => 'required',
        ]);

        Document::create($request->all());

        return redirect()->route('documents.index')
            ->with('success','ریکارډ ثبت شو');
    }

    // SHOW
    public function show(Document $document)
    {
        return view('documents.show',compact('document'));
    }

    // EDIT
    public function edit(Document $document)
    {
        return view('documents.edit',compact('document'));
    }

    // UPDATE
    public function update(Request $request, Document $document)
    {
        $document->update($request->all());

        return redirect()->route('documents.index')
            ->with('success','ریکارډ اپډیټ شو');
    }

    // DELETE
    public function destroy(Document $document)
    {
        $document->delete();

        return back()->with('success','ریکارډ حذف شو');
    }
}