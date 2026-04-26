<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Employee;
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

        // NEW: Audit log for create
        if (function_exists('audit_log')) {
            audit_log('created', $task, null, $task->toArray());
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task->load('employee');

        // NEW: Audit log for view
        if (function_exists('audit_log')) {
            audit_log('viewed', $task, null, $task->toArray());
        }

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $employees = Employee::orderBy('full_name')->get();

        // NEW: Audit log for edit page open
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

        // NEW: keep old values before update
        $oldValues = $task->getOriginal();

        $task->update($request->all());

        // NEW: Audit log for update
        if (function_exists('audit_log')) {
            audit_log('updated', $task, $oldValues, $task->getChanges());
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        // NEW: keep old values before delete
        $oldValues = $task->toArray();

        // NEW: Audit log before delete
        if (function_exists('audit_log')) {
            audit_log('deleted', $task, $oldValues, null);
        }

        $task->delete();

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

        // NEW: Audit log for monitoring page
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

        // NEW: keep old values before status change
        $oldValues = $task->getOriginal();

        $task->status = $request->status;
        $task->save();

        // NEW: Audit log for status change
        if (function_exists('audit_log')) {
            audit_log('status_changed', $task, $oldValues, $task->getChanges());
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

        $employeeTaskCounts = Task::selectRaw('employee_id, COUNT(*) as total')
            ->whereNotNull('employee_id')
            ->groupBy('employee_id')
            ->with('employee')
            ->get();

        $employeeLabels = $employeeTaskCounts->map(function ($item) {
            return $item->employee->full_name ?? 'Unknown';
        })->values();

        $employeeData = $employeeTaskCounts->pluck('total')->values();

        return view('tasks.charts', compact(
            'stats',
            'statusChart',
            'priorityChart',
            'employeeLabels',
            'employeeData'
        ));
    }
}