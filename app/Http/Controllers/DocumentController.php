<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
public function coming()
{
    $documents = \App\Models\Document::latest()->get();

    return view('CorrespondenceManagement.inbox.coming', [
        'documents' => $documents
    ]);
}
}