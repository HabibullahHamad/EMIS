<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['assigner','assignee'])->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'assigned_to' => 'required',
            'priority' => 'required',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_by' => Auth::id(),
            'assigned_to' => $request->assigned_to,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.index')
            ->with('success','Task delegated successfully');
    }

    public function edit(Task $task)
    {
        $users = User::all();
        return view('tasks.edit', compact('task','users'));
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        return redirect()->route('tasks.index')
            ->with('success','Task updated');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success','Task deleted');
    }
}

