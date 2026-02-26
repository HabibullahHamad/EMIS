<?php

namespace App\Http\Controllers;

use App\Models\IncomeLetter;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeLetterController extends Controller
{
    // د ټولو لیکونو لیست
    public function index() {
        $letters = IncomeLetter::orderBy('received_date', 'desc')->get();
        return view('letters.index', compact('letters'));
    }

    // د لیک تفصیل
    public function show($id) {
        $letter = IncomeLetter::with('tasks.assignedToUser')->findOrFail($id);
        $departments = \App\Models\User::where('role', 'department')->get(); // د څانګو لیست
        return view('letters.show', compact('letter', 'departments'));
    }
    // د لیک لپاره دنده ټاکل
    public function assignTask(Request $request, $letterId) {
        $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'required|integer',
            'due_date' => 'required|date',
        ]);
        Task::create([
            'income_letter_id' => $letterId,
            'title' => $request->title,
            'assigned_to' => $request->assigned_to,
            'status' => 'Pending',
            'due_date' => $request->due_date,
            'created_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'دنده په بریالیتوب سره ټاکل شوه!');
    }
}
