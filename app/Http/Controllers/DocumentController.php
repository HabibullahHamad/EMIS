<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();

        // Search Filters
        if ($request->document_no) {
            $query->where('document_no', 'like', '%' . $request->document_no . '%');
        }

        if ($request->subject) {
            $query->where('subject', 'like', '%' . $request->subject . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Get Data
        $documents = $query->latest()->get(); // you can use paginate(10) if needed

        return view('documents.index', compact('documents'));
    }
}