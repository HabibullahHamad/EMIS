<?php
namespace App\Http\Controllers\CorrespondenceManagement;
use Illuminate\Http\Request;
use App\Models\Letter;
use App\Http\Controllers\Controller;
class LetterController extends Controller
{
    public function create()
    {
        return view('CorrespondenceManagement.inbox.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'letter_no' => 'required',
            'subject' => 'required',
            'sender' => 'required',
            'receiver' => 'required',
            'received_date' => 'required',
        ]);
        $data = $request->all();
        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('attachments'), $filename);
            $data['attachment'] = $filename;
        }
        Letter::create($data);

        return redirect()->route('inbox.create')->with('success', 'Letter Added Successfully!');
    }
}
