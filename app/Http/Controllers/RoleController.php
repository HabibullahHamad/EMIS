<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::query();

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('display_name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $roles = $query->latest()->paginate(10)->withQueryString();

        return view('roles.index', compact('roles'));
    }



    public function create()
{
    $permissions = \App\Models\Permission::orderBy('module')->orderBy('display_name')->get()->groupBy('module');

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

    $role = \App\Models\Role::create([
        'name' => $request->name,
        'display_name' => $request->display_name,
        'description' => $request->description,
    ]);

    $role->permissions()->sync($request->permissions ?? []);

    return redirect()->route('roles.index')->with('success', __('messages.created'));
}
// ROLES EDITS 
public function edit(Role $role)
{
    $permissions = \App\Models\Permission::orderBy('module')->orderBy('display_name')->get()->groupBy('module');
    $role->load('permissions');

    return view('roles.edit', compact('role', 'permissions'));
}
// ROLES UPDATE 
public function update(Request $request, Role $role)
{
    $request->validate([
        'name' => 'required|string|max:100|unique:roles,name,' . $role->id,
        'display_name' => 'required|string|max:150',
        'description' => 'nullable|string',
        'permissions' => 'nullable|array',
        'permissions.*' => 'exists:permissions,id',
    ]);

    $role->update([
        'name' => $request->name,
        'display_name' => $request->display_name,
        'description' => $request->description,
    ]);

    $role->permissions()->sync($request->permissions ?? []);

    return redirect()->route('roles.index')->with('success', __('messages.updated'));
}
   

//  ROLES DELETE 
    public function destroy(Role $role)
    {
        $role->delete();

return redirect()->route('roles.index')
        ->with('success', __('messages.role_deleted'));    
        }

        public function show(Role $role)
        {
            $role->load('permissions');

            return view('roles.show', compact('role'));
        }
    
}