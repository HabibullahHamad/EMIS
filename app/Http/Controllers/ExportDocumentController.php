<?php

namespace App\Http\Controllers;

use App\Models\ExportDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Morilog\Jalali\Jalalian;

class ExportDocumentController extends Controller
{
    public function index()
    {
        $documents = ExportDocument::latest()->paginate(10);

        return view('DocumentManagement.dindex', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doc_number' => 'required',
            'subject' => 'required',
            'receiver' => 'required',
            'doc_date' => 'required',
            'attachment' => 'nullable|file|max:2048',
        ]);

        $jalali = Jalalian::fromFormat('Y/m/d', $request->doc_date);
        $gregorian = $jalali->toCarbon();

        $filePath = null;

        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('exports', 'public');
        }

        $document = ExportDocument::create([
            'doc_number' => $request->doc_number,
            'subject' => $request->subject,
            'receiver' => $request->receiver,
            'doc_date' => $gregorian,
            'attachment' => $filePath,
        ]);

        // NEW: Audit log for create
        if (function_exists('audit_log')) {
            audit_log('created', $document, null, $document->toArray());
        }

        return back()->with('success', 'Document saved successfully');
    }

    public function show(ExportDocument $export_document)
    {
        // NEW: Audit log for view
        if (function_exists('audit_log')) {
            audit_log('viewed', $export_document, null, $export_document->toArray());
        }

        return view('export_documents.show', compact('export_document'));
    }

    public function destroy(ExportDocument $export_document)
    {
        $oldValues = $export_document->toArray();

        // NEW: Audit log before delete
        if (function_exists('audit_log')) {
            audit_log('deleted', $export_document, $oldValues, null);
        }

        if ($export_document->attachment && Storage::disk('public')->exists($export_document->attachment)) {
            Storage::disk('public')->delete($export_document->attachment);
        }

        $export_document->delete();

        return back()->with('success', 'Document deleted successfully');
    }
}