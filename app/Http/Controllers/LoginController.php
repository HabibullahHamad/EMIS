<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // NEW: audit log after successful login
            if (function_exists('audit_log')) {
                audit_log('login', auth()->user(), null, [
                    'email' => auth()->user()->email,
                    'name' => auth()->user()->name,
                ]);
            }

            return redirect()->route('dashboard');
        }

        // Optional: log failed login attempt
        if (function_exists('audit_log')) {
            audit_log('failed_login', null, null, [
                'email' => $request->email,
            ]);
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // NEW: audit log before logout
        if (function_exists('audit_log')) {
            audit_log('logout', auth()->user(), null, [
                'email' => auth()->user()?->email,
                'name' => auth()->user()?->name,
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}