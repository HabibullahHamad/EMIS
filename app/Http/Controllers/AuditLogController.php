<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
{
    $query = \App\Models\AuditLog::with('user')->latest();

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('action', 'like', "%{$search}%")
              ->orWhere('model_type', 'like', "%{$search}%")
              ->orWhere('ip_address', 'like', "%{$search}%")
              ->orWhereHas('user', function ($u) use ($search) {
                  $u->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
              });
        });
    }

    if ($request->filled('action')) {
        $query->where('action', $request->action);
    }

    $auditLogs = $query->paginate(15)->withQueryString();

    $stats = [
        'total' => \App\Models\AuditLog::count(),
        'created' => \App\Models\AuditLog::where('action', 'created')->count(),
        'updated' => \App\Models\AuditLog::where('action', 'updated')->count(),
        'deleted' => \App\Models\AuditLog::where('action', 'deleted')->count(),
        'today' => \App\Models\AuditLog::whereDate('created_at', today())->count(),
        'login' => \App\Models\AuditLog::where('action', 'login')->count(),
    ];

    return view('audit.index', compact('auditLogs', 'stats'));
}

    public function show(AuditLog $auditLog)
    {
        $auditLog->load('user');

        return view('audit.show', compact('auditLog'));
    }
}