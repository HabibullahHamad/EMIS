<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role')->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        if ($request->filled('blocked_status')) {
            if ($request->blocked_status === 'blocked') {
                $query->where('is_blocked', 1);
            }

            if ($request->blocked_status === 'active') {
                $query->where('is_blocked', 0);
            }
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = Role::orderBy('display_name')->get();

        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::orderBy('display_name')->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'failed_login_attempts' => 0,
            'is_blocked' => 0,
            'blocked_at' => null,
        ]);

        if (function_exists('audit_log')) {
            audit_log('created', $user, null, $user->toArray());
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load('role');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('display_name')->get();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'confirmed', Password::min(6)],
        ]);

        $oldValues = $user->getOriginal();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if (function_exists('audit_log')) {
            audit_log('updated', $user, $oldValues, $user->getChanges());
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $oldValues = $user->toArray();

        if (function_exists('audit_log')) {
            audit_log('deleted', $user, $oldValues, null);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function block(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot block your own account.');
        }

        $oldValues = $user->getOriginal();

        $user->update([
            'is_blocked' => 1,
            'blocked_at' => now(),
        ]);

        if (function_exists('audit_log')) {
            audit_log('user_blocked', $user, $oldValues, $user->getChanges());
        }

        return back()->with('success', 'User blocked successfully.');
    }

    public function unblock(User $user)
    {
        $oldValues = $user->getOriginal();

        $user->update([
            'is_blocked' => 0,
            'failed_login_attempts' => 0,
            'blocked_at' => null,
        ]);

        if (function_exists('audit_log')) {
            audit_log('user_unblocked', $user, $oldValues, $user->getChanges());
        }

        return back()->with('success', 'User allowed again successfully.');
    }
}