<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        return view('settings.settings');
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'timezone' => 'required|string',
        ]);

        // Update settings logic here.

        return redirect()->route('settings.settings')
            ->with('status', 'Settings updated successfully.');
    }
}