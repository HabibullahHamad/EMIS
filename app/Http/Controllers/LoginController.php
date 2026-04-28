<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->onlyInput('email');
        }

        if ((int) $user->is_blocked === 1) {
            return back()->withErrors([
                'email' => 'Your account is blocked. Please contact admin.',
            ])->onlyInput('email');
        }

        if (!Hash::check($request->password, $user->password)) {
            $user->failed_login_attempts = (int) $user->failed_login_attempts + 1;

            if ($user->failed_login_attempts > 4) {
                $user->is_blocked = 1;
                $user->blocked_at = now();

                if (SchemaHasColumn('users', 'blocked_reason')) {
                    $user->blocked_reason = 'Too many failed login attempts';
                }
            }

            $user->save();

            if (function_exists('audit_log')) {
                audit_log('failed_login', $user, null, [
                    'email' => $user->email,
                    'attempt' => $user->failed_login_attempts,
                    'ip' => $request->ip(),
                ]);
            }

            if ((int) $user->is_blocked === 1) {
                return back()->withErrors([
                    'email' => 'Account blocked after 5 wrong login attempts.',
                ])->onlyInput('email');
            }

            return back()->withErrors([
                'email' => 'Invalid email or password. Attempt ' . $user->failed_login_attempts . ' of 5.',
            ])->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        $updateData = [
            'failed_login_attempts' => 0,
        ];

        if (SchemaHasColumn('users', 'last_login_ip')) {
            $updateData['last_login_ip'] = $request->ip();
        }

        if (SchemaHasColumn('users', 'last_login_at')) {
            $updateData['last_login_at'] = now();
        }

        $user->update($updateData);

        if (function_exists('audit_log')) {
            audit_log('login', $user, null, [
                'email' => $user->email,
                'name' => $user->name,
                'ip' => $request->ip(),
            ]);
        }

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        if ($user && function_exists('audit_log')) {
            audit_log('logout', $user, null, [
                'email' => $user->email,
                'name' => $user->name,
                'ip' => $request->ip(),
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

if (!function_exists('SchemaHasColumn')) {
    function SchemaHasColumn($table, $column)
    {
        return \Illuminate\Support\Facades\Schema::hasTable($table)
            && \Illuminate\Support\Facades\Schema::hasColumn($table, $column);
    }
}