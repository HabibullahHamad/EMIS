<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::query();

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('display_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $roles = $query->latest()->paginate(10)->withQueryString();

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('module')
            ->orderBy('display_name')
            ->get()
            ->groupBy('module');

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'display_name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create($request->only('name', 'display_name', 'description'));

        $role->permissions()->sync($request->permissions ?? []);

        if (function_exists('audit_log')) {
            audit_log('created', $role, null, $role->load('permissions')->toArray());
        }

        return redirect()->route('roles.index')->with('success', __('messages.created'));
    }

    public function show(Role $role)
    {
        $role->load('permissions');

        if (function_exists('audit_log')) {
            audit_log('viewed', $role, null, $role->toArray());
        }

        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('module')
            ->orderBy('display_name')
            ->get()
            ->groupBy('module');

        $role->load('permissions');

        if (function_exists('audit_log')) {
            audit_log('edit_opened', $role, null, $role->toArray());
        }

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $role->id,
            'display_name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $oldValues = $role->load('permissions')->toArray();

        $role->update($request->only('name', 'display_name', 'description'));

        $role->permissions()->sync($request->permissions ?? []);

        if (function_exists('audit_log')) {
            audit_log('updated', $role, $oldValues, $role->load('permissions')->toArray());
        }

        return redirect()->route('roles.index')->with('success', __('messages.updated'));
    }

    public function destroy(Role $role)
    {
        $oldValues = $role->load('permissions')->toArray();

        if (function_exists('audit_log')) {
            audit_log('deleted', $role, $oldValues, null);
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', __('messages.role_deleted'));
    }
}