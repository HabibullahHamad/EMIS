<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::with('parent')->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('name_ps', 'like', "%{$search}%")
                  ->orWhere('name_fa', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $departments = $query->paginate(10)->withQueryString();

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $parents = Department::orderBy('name')->get();

        return view('departments.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_ps' => 'nullable|string|max:255',
            'name_fa' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:50|unique:departments,code',
            'parent_id' => 'nullable|exists:departments,id',
            'description' => 'nullable|string',
        ]);

        Department::create([
            'name' => $request->name,
            'name_ps' => $request->name_ps,
            'name_fa' => $request->name_fa,
            'code' => $request->code,
            'parent_id' => $request->parent_id,
            'status' => $request->has('status'),
            'description' => $request->description,
        ]);

        return redirect()->route('departments.index')
            ->with('success', __('messages.created'));
    }

    public function show(Department $department)
    {
        $department->load('parent', 'children');

        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        $parents = Department::where('id', '!=', $department->id)
            ->orderBy('name')
            ->get();

        return view('departments.edit', compact('department', 'parents'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_ps' => 'nullable|string|max:255',
            'name_fa' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:50|unique:departments,code,' . $department->id,
            'parent_id' => 'nullable|exists:departments,id|not_in:' . $department->id,
            'description' => 'nullable|string',
        ]);

        $department->update([
            'name' => $request->name,
            'name_ps' => $request->name_ps,
            'name_fa' => $request->name_fa,
            'code' => $request->code,
            'parent_id' => $request->parent_id,
            'status' => $request->has('status'),
            'description' => $request->description,
        ]);

        return redirect()->route('departments.index')
            ->with('success', __('messages.updated'));
    }

    public function destroy(Department $department)
    {
        if ($department->children()->count() > 0) {
            return back()->with('error', 'Cannot delete a department that has child departments.');
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', __('messages.deleted'));
    }
}