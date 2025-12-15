<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\User;
class TaskController extends Controller


{
    public function index()
    {
      $tasks = Task::with(['assignedBy', 'assignedTo'])->latest()->get();
        return view('Task Management.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        return view('Task Management.show', compact('task'));
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
            'assigned_by' => 'required',
            'assigned_to' => 'required',
            'due_date' => 'required',
            'priority' => 'required',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_by' => $request->assigned_by,
            'assigned_to' => $request->assigned_to,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('Task Management.index')
            ->with('success','Task delegated successfully');
    }

    public function edit(Task $task)
    {
        $users = User::all();
        return view('Task Management.edit', compact('task','users'));
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        return redirect()->route('tasks.index')
            ->with('success','Task updated Successfully');
    }


    public function destroy(Task $task)
    {
        $task->delete();
        
        return back()->with('success','Task deleted Successfully');
    }
}
