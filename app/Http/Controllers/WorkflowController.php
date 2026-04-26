<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workflow;
use App\Models\Department;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    public function index()
    {
        $workflows = Workflow::with(['fromUser', 'toUser', 'toDepartment'])
            ->latest()
            ->paginate(15);

        return view('workflows.index', compact('workflows'));
    }

    public function pending()
    {
        $workflows = Workflow::with(['fromUser', 'toUser', 'toDepartment'])
            ->where('to_user_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('workflows.index', compact('workflows'));
    }

    public function sent()
    {
        $workflows = Workflow::with(['fromUser', 'toUser', 'toDepartment'])
            ->where('from_user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('workflows.index', compact('workflows'));
    }

    public function create()
    {
        $users = User::with('role')->orderBy('name')->get();
        $departments = Department::where('status', true)->orderBy('name')->get();

        return view('workflows.create', compact('users', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'to_user_id' => 'required|exists:users,id',
            'to_department_id' => 'nullable|exists:departments,id',
            'priority' => 'required|in:low,normal,high,urgent',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $workflow = Workflow::create([
            'title' => $request->title,
            'description' => $request->description,
            'from_user_id' => auth()->id(),
            'to_user_id' => $request->to_user_id,
            'to_department_id' => $request->to_department_id,
            'priority' => $request->priority,
            'status' => 'pending',
            'remarks' => $request->remarks,
        ]);

        if (function_exists('audit_log')) {
            audit_log('created', $workflow, null, $workflow->toArray());
        }

        return redirect()->route('workflows.index')->with('success', 'Workflow created successfully.');
    }

    public function show(Workflow $workflow)
    {
        $workflow->load(['fromUser', 'toUser', 'fromDepartment', 'toDepartment']);

        if (function_exists('audit_log')) {
            audit_log('viewed', $workflow, null, $workflow->toArray());
        }

        return view('workflows.show', compact('workflow'));
    }

    public function approve(Workflow $workflow)
    {
        $oldValues = $workflow->getOriginal();

        $workflow->update([
            'status' => 'approved',
            'acted_at' => now(),
        ]);

        if (function_exists('audit_log')) {
            audit_log('approved', $workflow, $oldValues, $workflow->getChanges());
        }

        return back()->with('success', 'Workflow approved.');
    }

    public function reject(Request $request, Workflow $workflow)
    {
        $request->validate([
            'remarks' => 'nullable|string',
        ]);

        $oldValues = $workflow->getOriginal();

        $workflow->update([
            'status' => 'rejected',
            'remarks' => $request->remarks,
            'acted_at' => now(),
        ]);

        if (function_exists('audit_log')) {
            audit_log('rejected', $workflow, $oldValues, $workflow->getChanges());
        }

        return back()->with('success', 'Workflow rejected.');
    }

    public function returnBack(Request $request, Workflow $workflow)
    {
        $request->validate([
            'remarks' => 'nullable|string',
        ]);

        $oldValues = $workflow->getOriginal();

        $workflow->update([
            'status' => 'returned',
            'remarks' => $request->remarks,
            'acted_at' => now(),
        ]);

        if (function_exists('audit_log')) {
            audit_log('returned', $workflow, $oldValues, $workflow->getChanges());
        }

        return back()->with('success', 'Workflow returned.');
    }

    public function complete(Workflow $workflow)
    {
        $oldValues = $workflow->getOriginal();

        $workflow->update([
            'status' => 'completed',
            'acted_at' => now(),
        ]);

        if (function_exists('audit_log')) {
            audit_log('completed', $workflow, $oldValues, $workflow->getChanges());
        }

        return back()->with('success', 'Workflow completed.');
    }
}