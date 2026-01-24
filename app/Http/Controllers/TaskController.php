<?php

namespace App\Http\Controllers;


use App\Models\Task;
use Illuminate\Http\Request;
class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::with('assignee')
            ->when($request->status, fn($q) =>
                $q->where('status', $request->status))
            ->paginate(10);
            


        return view('Task Management.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        Task::create([
            'task_code'  => 'TSK-' . now()->format('Ymd-His'),
            'title'      => $request->title,
            'description'=> $request->description,
            'assigned_to'=> $request->assigned_to,
            'assigned_by'=> $request->assigned_by,
            'priority'   => $request->priority,
            'due_date'   => $request->due_date,
        ]);

        return back()->with('success','Task assigned successfully');
    }

    public function updateStatus(Task $task, $status)
    {
        $task->update(['status'=>$status]);
        return back();
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success','Task deleted successfully');
    }


    

    public function show(Task $task)
    {
        return view('Task Management.show', compact('task'));
    }
}