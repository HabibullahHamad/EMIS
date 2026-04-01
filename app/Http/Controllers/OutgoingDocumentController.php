<?php
namespace App\Http\Controllers;

use App\Models\OutgoingDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class OutgoingDocumentController extends Controller
{

public function index()
{

$documents = OutgoingDocument::latest()->paginate(15);

return view('CorrespondenceManagement.outbox.index',compact('documents'));

}


public function create()
{
return view('CorrespondenceManagement.outbox.create');
}

public function store(Request $request)
{
$data = $request->validate([
'doc_number'=>'required',
'subject'=>'required',
'sender'=>'required',
'receiver'=>'required',
'doc_date'=>'required',
'priority'=>'required',
'assigned_to'=>'required',
'department'=>'required',
'description'=>'nullable',
'attachment'=>'nullable|file',

]);
 if ($request->hasFile('attachments')) {
    $data['attachments'] = $request->file('attachments')->store('documents', 'public');
        }


OutgoingDocument::create($data);
return redirect()->route('CorrespondenceManagement.outbox.index');
}
public function show($id)
{

$document = OutgoingDocument::findOrFail($id);
return view('CorrespondenceManagement.outbox.show',compact('document'));
}

public function edit($id)
{
$document = OutgoingDocument::findOrFail($id);
return view('CorrespondenceManagement.outbox.edit',compact('document'));
}
public function update(Request $request,$id)
{
$document = OutgoingDocument::findOrFail($id);

$document->update($request->all());

return redirect()->route('CorrespondenceManagement.outbox.index');

}
public function destroy($id)
{
OutgoingDocument::destroy($id);

return redirect()->back();
}
}