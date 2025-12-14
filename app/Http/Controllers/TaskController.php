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
        return view('Task Management.index', compact('tasks'));
    }

    public function create()
    {
        $users = User::all();
        return view('Task Management.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'priority' => 'required',
            'status' => 'required',
            'due_date' => 'required|date',
            'assigned_to' => 'required|exists:users,id',
        ]);

       
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_by' => $request->input('assigned_by'),
            'assigned_to' => $request->input('assigned_to'),
            'priority' => $request->priority,
            'status' => $request->status,
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

