<?php

namespace App\Http\Controllers;

use App\Models\OutgoingDocument;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
  use setasign\Fpdi\Fpdi;

class OutgoingDocumentController extends Controller
{
    public function index()
    {
        $documents = OutgoingDocument::latest()->paginate(15);
        return view('CorrespondenceManagement.outbox.index', compact('documents'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('CorrespondenceManagement.outbox.create', compact('users'));
    }

public function store(Request $request)
{
$data = $request->validate([
    'doc_number'  => 'required',
    'subject'     => 'required',
    'sender'      => 'required',
    'receiver'    => 'required',
    'doc_date'    => 'required',
    'priority'    => 'nullable',
    'assigned_to' => 'required',
    'department'  => 'required',
    'description' => 'nullable',

    'attachments'   => 'nullable|array',
    'attachments.*' => 'nullable|file|max:20480',
]);

$files=[];

$names=[];

if(

$request->hasFile(

'attachments'

)

){

foreach(

$request->file(

'attachments'

)

as $file

){

$files[]=
$file->store(
'outbox',
'public'
);

$names[]=
$file->getClientOriginalName();

}

}

$data['attachment']=
json_encode($files);

$data['attachment_names']=
json_encode($names);

OutgoingDocument::create($data);

return redirect()

->route(
'outbox.index'
)

->with(
'success',
'Created'
);

}
    public function show($id)
    {
        $document = OutgoingDocument::findOrFail($id);

        if (function_exists('audit_log')) {
            audit_log('viewed', $document, null, $document->toArray());
        }

        return view('CorrespondenceManagement.outbox.show', compact('document'));
    }

    public function edit($id)
    {
        $document = OutgoingDocument::findOrFail($id);
        $users = User::orderBy('name')->get();

        if (function_exists('audit_log')) {
            audit_log('edit_opened', $document, null, $document->toArray());
        }

        return view('CorrespondenceManagement.outbox.edit', compact('document', 'users'));
    }

    public function update(Request $request, $id)
    {
        $document = OutgoingDocument::findOrFail($id);
        $oldValues = $document->getOriginal();
        $oldAssignedTo = $document->assigned_to;

        $data = $request->validate([
            'doc_number'  => 'required',
            'subject'     => 'required',
            'sender'      => 'required',
            'receiver'    => 'required',
            'doc_date'    => 'required',
            'priority'    => 'required',
            'assigned_to' => 'required|exists:users,id',
            'department'  => 'required',
            'description' => 'nullable',
            'attachment'  => 'nullable|file',
        ]);

        if ($request->hasFile('attachment')) {
            if ($document->attachment && Storage::disk('public')->exists($document->attachment)) {
                Storage::disk('public')->delete($document->attachment);
            }

            $data['attachment'] = $request->file('attachment')->store('documents', 'public');
        }

        $document->update($data);

        if (function_exists('audit_log')) {
            audit_log('updated', $document, $oldValues, $document->getChanges());
        }

        if (function_exists('notify_user')) {
            notify_user(
                $data['assigned_to'],
                'Outgoing Document Updated',
                'An outgoing document assigned to you has been updated.',
                'document',
                $data['priority'] ?? 'normal',
                $document
            );

            if ($oldAssignedTo && $oldAssignedTo != $data['assigned_to']) {
                notify_user(
                    $oldAssignedTo,
                    'Outgoing Document Reassigned',
                    'An outgoing document was reassigned from you to another user.',
                    'document',
                    'normal',
                    $document
                );
            }
        }

        return redirect()
            ->route('CorrespondenceManagement.outbox.index')
            ->with('success', 'Outgoing document updated successfully.');
    }

    public function destroy($id)
    {
        $document = OutgoingDocument::findOrFail($id);
        $oldValues = $document->toArray();
        $assignedTo = $document->assigned_to;

        if (function_exists('audit_log')) {
            audit_log('deleted', $document, $oldValues, null);
        }

        if ($document->attachment && Storage::disk('public')->exists($document->attachment)) {
            Storage::disk('public')->delete($document->attachment);
        }

        $document->delete();

        if ($assignedTo && function_exists('notify_user')) {
            notify_user(
                $assignedTo,
                'Outgoing Document Deleted',
                'An outgoing document assigned to you has been deleted.',
                'document',
                'high'
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Outgoing document deleted successfully.');
    }
  

public function combinePdf($id)
{
    $document = OutgoingDocument::findOrFail($id);

    $files = json_decode($document->attachment, true);

    if (!is_array($files)) {
        $files = $document->attachment
            ? [$document->attachment]
            : [];
    }

    $pdf = new Fpdi();

    foreach ($files as $file) {

        $path = storage_path(
            'app/public/' . $file
        );

        if (!file_exists($path)) {
            continue;
        }

        $ext = strtolower(
            pathinfo(
                $path,
                PATHINFO_EXTENSION
            )
        );

        // PDF
        if ($ext == 'pdf') {

            $count = $pdf->setSourceFile($path);

            for ($i=1; $i <= $count; $i++) {

                $tpl = $pdf->importPage($i);

                $size = $pdf->getTemplateSize($tpl);

                $pdf->AddPage(
                    $size['orientation'],
                    [
                        $size['width'],
                        $size['height']
                    ]
                );

                $pdf->useTemplate($tpl);

            }
        }

        // Images
        elseif (
            in_array(
                $ext,
                [
                    'jpg',
                    'jpeg',
                    'png'
                ]
            )
        ) {

            $pdf->AddPage();

            $pdf->Image(
                $path,
                10,
                20,
                180
            );

        }

    }

    return response(
        $pdf->Output(
            'S',
            'combined.pdf'
        )
    )->header(
        'Content-Type',
        'application/pdf'
    );
}

}
