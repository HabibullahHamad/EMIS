<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correspondence;
use App\Models\User;

class CorrespondenceController extends Controller
{
    // Display list of correspondences
    public function index(Request $request)
    {
        $query = Correspondence::query();

        if ($request->sender) $query->where('sender', 'like', "%{$request->sender}%");
        if ($request->subject) $query->where('subject', 'like', "%{$request->subject}%");
        if ($request->date) $query->whereDate('deadline', $request->date);

        $correspondences = $query->with(['comments.user'])->paginate(10);
        $users = User::all();

        return view('comming', compact('correspondences', 'users'));
    }

    // Assign a staff to correspondence
    public function assign(Request $request, $id)
    {
        $letter = Correspondence::findOrFail($id);
        $letter->assigned_to = $request->assigned_to;
        $letter->save();

        return back();
    }

    // Add comment to correspondence
    public function comment(Request $request, $id)
    {
        $letter = Correspondence::findOrFail($id);
        $letter->comments()->create([
            'user_id' => auth()->id(),
            'text' => $request->comment,
        ]);

        return back();
    }
}
