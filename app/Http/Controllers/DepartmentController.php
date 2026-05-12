<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // ================= INDEX =================
    public function index(Request $request)
    {
        $query = Department::with('parent')->latest();

        // SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('name_ps', 'like', "%{$search}%")
                  ->orWhere('name_fa', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");

            });
        }

        // FILTER TYPE
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // FILTER PARENT
        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        }

        $departments = $query->paginate(10)->withQueryString();

        $parents = Department::orderBy('name')->get();

        return view('departments.index', compact('departments', 'parents'));
    }

    // ================= CREATE =================
    public function create()
    {
        $parents = Department::orderBy('name')->get();

        return view('departments.create', compact('parents'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $data = $request->validate([

            'name' => 'required|string|max:255',
            'name_ps' => 'nullable|string|max:255',
            'name_fa' => 'nullable|string|max:255',

            'code' => 'required|string|max:50|unique:departments,code',

            'type' => 'required|in:general_directorate,directorate,department',

            'parent_id' => 'nullable|exists:departments,id',

            'description' => 'nullable|string',

        ]);

        // STATUS
        $data['status'] = $request->has('status') ? 1 : 0;

        // LEVELS
        if ($data['type'] === 'general_directorate') {

            $data['parent_id'] = null;
            $data['level'] = 1;

        } elseif ($data['type'] === 'directorate') {

            $data['level'] = 2;

        } else {

            $data['level'] = 3;

        }

        // CREATE ONLY ONCE
        $department = Department::create($data);

        // AUDIT
        if (function_exists('audit_log')) {

            audit_log(
                'created',
                $department,
                null,
                $department->toArray()
            );
        }

        return redirect()
            ->route('departments.index')
            ->with('success', __('messages.created'));
    }

    // ================= SHOW =================
    public function show(Department $department)
    {
        $department->load('parent', 'children');

        return view('departments.show', compact('department'));
    }

    // ================= EDIT =================
    public function edit(Department $department)
    {
        $parents = Department::where('id', '!=', $department->id)
            ->orderBy('name')
            ->get();

        return view('departments.edit', compact('department', 'parents'));
    }

    // ================= UPDATE =================
    public function update(Request $request, Department $department)
    {
        $data = $request->validate([

            'name' => 'required|string|max:255',
            'name_ps' => 'nullable|string|max:255',
            'name_fa' => 'nullable|string|max:255',

            'code' => 'required|string|max:50|unique:departments,code,' . $department->id,

            'type' => 'required|in:general_directorate,directorate,department',

            'parent_id' => 'nullable|exists:departments,id|not_in:' . $department->id,

            'description' => 'nullable|string',

        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        // LEVELS
        if ($data['type'] === 'general_directorate') {

            $data['parent_id'] = null;
            $data['level'] = 1;

        } elseif ($data['type'] === 'directorate') {

            $data['level'] = 2;

        } else {

            $data['level'] = 3;

        }

        // OLD VALUES
        $oldValues = $department->getOriginal();

        // UPDATE ONLY ONCE
        $department->update($data);

        // AUDIT
        if (function_exists('audit_log')) {

            audit_log(
                'updated',
                $department,
                $oldValues,
                $department->getChanges()
            );
        }

        return redirect()
            ->route('departments.index')
            ->with('success', __('messages.updated'));
    }

    // ================= DELETE =================
    public function destroy(Department $department)
    {
        // CHECK CHILDREN
        if ($department->children()->count() > 0) {

            return back()->with(
                'error',
                'Cannot delete department with child departments.'
            );
        }

        $oldValues = $department->toArray();

        // AUDIT
        if (function_exists('audit_log')) {

            audit_log(
                'deleted',
                $department,
                $oldValues,
                null
            );
        }

        // DELETE ONLY ONCE
        $department->delete();

        return redirect()
            ->route('departments.index')
            ->with('success', __('messages.deleted'));
    }

    // ================= PRINT =================
    public function print(Request $request)
    {
        $query = Department::with('parent')->latest();

        // PRINT SELECTED
        if ($request->filled('ids')) {

            $ids = explode(',', $request->ids);

            $query->whereIn('id', $ids);

        } else {

            // SEARCH
            if ($request->filled('search')) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('name_ps', 'like', "%{$search}%")
                      ->orWhere('name_fa', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");

                });
            }

            // FILTER TYPE
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            // FILTER STATUS
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // FILTER PARENT
            if ($request->filled('parent_id')) {
                $query->where('parent_id', $request->parent_id);
            }
        }

        $departments = $query->get();

        return view('departments.print', compact('departments'));
    }
}