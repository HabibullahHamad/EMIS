<?php
namespace App\Http\Controllers;

use App\Models\ExportDocument;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class ExportDocumentController extends Controller
{
    public function index()
    {
        $documents = Document::latest()->paginate(10);
        return view('export_documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doc_number' => 'required',
            'subject' => 'required',
            'receiver' => 'required',
            'doc_date' => 'required',
            'attachment' => 'nullable|file|max:2048'
        ]);

        $jalali = Jalalian::fromFormat('Y/m/d', $request->doc_date);
        $gregorian = $jalali->toCarbon();

        $filePath = null;
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('exports', 'public');
        }

        ExportDocument::create([
            'doc_number' => $request->doc_number,
            'subject' => $request->subject,
            'receiver' => $request->receiver,
            'doc_date' => $gregorian,
            'attachment' => $filePath,
        ]);

        return back()->with('success', 'Document saved successfully');
    }

    public function show(ExportDocument $export_document)
    {
        return view('export_documents.show', compact('export_document'));
    }
}