<?php
// app/Http/Controllers/CorrespondenceManagement/DocumentController.php
namespace App\Http\Controllers\CorrespondenceManagement;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('assignedUser')->latest()->paginate(10);
        return view('CorrespondenceManagement.documents.index', compact('documents'));
    }

    public function create()
    {
        $users = User::all();
        return view('CorrespondenceManagement.documents.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_no' => 'required|unique:documents',
            'subject' => 'required',
            'sender' => 'required',
            'receiver' => 'required',
            'type' => 'required'
        ]);

        Document::create($request->all());
        return redirect()->route('documents.index')->with('success', 'Document added');
    }

    public function show(Document $document)
    {
        return view('CorrespondenceManagement.documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $users = User::all();
        return view('CorrespondenceManagement.documents.edit', compact('document', 'users'));
    }

    public function update(Request $request, Document $document)
    {
        $document->update($request->all());
        return redirect()->route('documents.index')->with('success', 'Updated');
    }

    public function archive(Document $document)
    {
        $document->update(['status' => 'Archived']);
        return back();
    }
}
