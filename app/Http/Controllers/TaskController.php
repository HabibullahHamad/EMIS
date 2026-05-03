<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Employee;
use App\Models\Notification;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with('employee');

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('task_code', 'like', '%' . $search . '%')
                  ->orWhere('source_reference', 'like', '%' . $search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $tasks = $query->latest()->paginate(7)->withQueryString();

        $stats = [
            'total' => Task::count(),
            'new' => Task::where('status', 'new')->count(),
            'assigned' => Task::where('status', 'assigned')->count(),
            'completed' => Task::where('status', 'completed')->count(),
            'overdue' => Task::where('status', 'overdue')->count(),
        ];

        $statusChart = [
            'new' => Task::where('status', 'new')->count(),
            'assigned' => Task::where('status', 'assigned')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'completed' => Task::where('status', 'completed')->count(),
            'overdue' => Task::where('status', 'overdue')->count(),
            'cancelled' => Task::where('status', 'cancelled')->count(),
        ];

        $priorityChart = [
            'low' => Task::where('priority', 'low')->count(),
            'medium' => Task::where('priority', 'medium')->count(),
            'high' => Task::where('priority', 'high')->count(),
            'urgent' => Task::where('priority', 'urgent')->count(),
        ];

        $employeeTaskCounts = Task::selectRaw('employee_id, COUNT(*) as total')
            ->whereNotNull('employee_id')
            ->groupBy('employee_id')
            ->with('employee')
            ->get();

        $employeeLabels = $employeeTaskCounts->map(function ($item) {
            return $item->employee->full_name ?? 'Unknown';
        });

        $employeeData = $employeeTaskCounts->pluck('total');

        return view('tasks.index', compact(
            'tasks',
            'stats',
            'statusChart',
            'priorityChart',
            'employeeLabels',
            'employeeData'
        ));
    }

    public function create()
    {
        $employees = Employee::orderBy('full_name')->get();

        return view('tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_code' => 'required|unique:tasks,task_code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'employee_id' => 'nullable|exists:employees,id',
            'source_type' => 'nullable|string|max:100',
            'source_reference' => 'nullable|string|max:100',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:new,assigned,in_progress,completed,overdue,cancelled',
            'deadline' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['assigned_by'] = auth()->id();

        $task = Task::create($data);

        if (function_exists('audit_log')) {
            audit_log('created', $task, null, $task->toArray());
        }

        $task->load('employee');

        $notificationUserId = optional($task->employee)->user_id ?? auth()->id();

        if (function_exists('notify_user')) {
            notify_user(
                $notificationUserId,
                'New Task Assigned',
                'A new task has been assigned to you.',
                'task',
                $task->priority ?? 'normal',
                $task
            );
        } else {
            Notification::create([
                'user_id' => $notificationUserId,
                'title' => 'New Task Assigned',
                'message' => 'A new task has been assigned to you.',
                'type' => 'task',
                'priority' => $task->priority ?? 'normal',
                'related_type' => Task::class,
                'related_id' => $task->id,
            ]);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task->load('employee');

        if (function_exists('audit_log')) {
            audit_log('viewed', $task, null, $task->toArray());
        }

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $employees = Employee::orderBy('full_name')->get();

        if (function_exists('audit_log')) {
            audit_log('edit_opened', $task, null, $task->toArray());
        }

        return view('tasks.edit', compact('task', 'employees'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'task_code' => 'required|unique:tasks,task_code,' . $task->id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'employee_id' => 'nullable|exists:employees,id',
            'source_type' => 'nullable|string|max:100',
            'source_reference' => 'nullable|string|max:100',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:new,assigned,in_progress,completed,overdue,cancelled',
            'deadline' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $oldValues = $task->getOriginal();
        $oldEmployeeId = $task->employee_id;

        $task->update($request->all());

        if (function_exists('audit_log')) {
            audit_log('updated', $task, $oldValues, $task->getChanges());
        }

        $task->load('employee');

        $notificationUserId = optional($task->employee)->user_id ?? auth()->id();

        if (function_exists('notify_user')) {
            notify_user(
                $notificationUserId,
                'Task Updated',
                'A task assigned to you has been updated.',
                'task',
                $task->priority ?? 'normal',
                $task
            );

            if ($oldEmployeeId && $oldEmployeeId != $task->employee_id) {
                $oldEmployee = Employee::find($oldEmployeeId);

                if ($oldEmployee && $oldEmployee->user_id) {
                    notify_user(
                        $oldEmployee->user_id,
                        'Task Reassigned',
                        'A task was reassigned from you to another employee.',
                        'task',
                        'normal',
                        $task
                    );
                }
            }
        } else {
            Notification::create([
                'user_id' => $notificationUserId,
                'title' => 'Task Updated',
                'message' => 'A task assigned to you has been updated.',
                'type' => 'task',
                'priority' => $task->priority ?? 'normal',
                'related_type' => Task::class,
                'related_id' => $task->id,
            ]);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->load('employee');

        $oldValues = $task->toArray();
        $notificationUserId = optional($task->employee)->user_id ?? auth()->id();

        if (function_exists('audit_log')) {
            audit_log('deleted', $task, $oldValues, null);
        }

        $task->delete();

        if (function_exists('notify_user')) {
            notify_user(
                $notificationUserId,
                'Task Deleted',
                'A task assigned to you has been deleted.',
                'task',
                'high'
            );
        } else {
            Notification::create([
                'user_id' => $notificationUserId,
                'title' => 'Task Deleted',
                'message' => 'A task assigned to you has been deleted.',
                'type' => 'task',
                'priority' => 'high',
            ]);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    public function monitoring(Task $task)
    {
        $task->load('employee');

        $isOverdue = false;

        if ($task->deadline && $task->status !== 'completed') {
            $isOverdue = now()->gt($task->deadline);
        }

        if (function_exists('audit_log')) {
            audit_log('monitoring_viewed', $task, null, $task->toArray());
        }

        return view('tasks.monitoring', compact('task', 'isOverdue'));
    }

    public function changeStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:new,assigned,in_progress,completed,overdue,cancelled',
        ]);

        $oldValues = $task->getOriginal();

        $task->status = $request->status;
        $task->save();

        if (function_exists('audit_log')) {
            audit_log('status_changed', $task, $oldValues, $task->getChanges());
        }

        $task->load('employee');

        $notificationUserId = optional($task->employee)->user_id ?? auth()->id();

        if (function_exists('notify_user')) {
            notify_user(
                $notificationUserId,
                'Task Status Changed',
                'Your task status changed to: ' . $task->status,
                'task',
                $task->priority ?? 'normal',
                $task
            );
        } else {
            Notification::create([
                'user_id' => $notificationUserId,
                'title' => 'Task Status Changed',
                'message' => 'Your task status changed to: ' . $task->status,
                'type' => 'task',
                'priority' => $task->priority ?? 'normal',
                'related_type' => Task::class,
                'related_id' => $task->id,
            ]);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task status updated successfully.');
    }

    public function charts()
    {
        $stats = [
            'total' => Task::count(),
            'new' => Task::where('status', 'new')->count(),
            'assigned' => Task::where('status', 'assigned')->count(),
            'completed' => Task::where('status', 'completed')->count(),
            'overdue' => Task::where('status', 'overdue')->count(),
        ];

        $statusChart = [
            'new' => Task::where('status', 'new')->count(),
            'assigned' => Task::where('status', 'assigned')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'completed' => Task::where('status', 'completed')->count(),
            'overdue' => Task::where('status', 'overdue')->count(),
            'cancelled' => Task::where('status', 'cancelled')->count(),
        ];

        $priorityChart = [
            'low' => Task::where('priority', 'low')->count(),
            'medium' => Task::where('priority', 'medium')->count(),
            'high' => Task::where('priority', 'high')->count(),
            'urgent' => Task::where('priority', 'urgent')->count(),
        ];

        return view('tasks.charts', compact('stats', 'statusChart', 'priorityChart'));
    }

}