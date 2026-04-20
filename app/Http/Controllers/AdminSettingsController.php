<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::current();

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::current();

        $validated = $request->validate([
            'system_name' => 'required|string|max:255',
            'system_short_name' => 'required|string|max:50',
            'default_language' => 'required|in:en,ps,fa',
            'timezone' => 'required|string|max:100',
            'date_format' => 'required|string|max:20',
            'system_description' => 'nullable|string',

            'organization_name' => 'nullable|string|max:255',
            'department_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',

            'password_min_length' => 'required|integer|min:6|max:50',
            'session_timeout' => 'required|integer|min:5|max:1440',

            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['enable_user_registration'] = $request->boolean('enable_user_registration');
        $validated['enable_task_notifications'] = $request->boolean('enable_task_notifications');
        $validated['enable_document_tracking'] = $request->boolean('enable_document_tracking');
        $validated['email_notifications'] = $request->boolean('email_notifications');
        $validated['browser_notifications'] = $request->boolean('browser_notifications');
        $validated['maintenance_mode'] = $request->boolean('maintenance_mode');
        $validated['debug_mode'] = $request->boolean('debug_mode');

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('settings', 'public');
            $validated['logo_path'] = $path;
        }

        $settings->update($validated);

        return redirect()
            ->route('admin.settings')
            ->with('success', __('messages.saved'));
    }
}