<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Workflow;
use App\Models\AuditLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalUsers = Schema::hasTable('users') ? User::count() : 0;

        $totalEmployees = (
            class_exists(Employee::class) &&
            Schema::hasTable('employees')
        ) ? Employee::count() : 0;

        $incomingDocuments = Schema::hasTable('inboxes')
            ? DB::table('inboxes')->count()
            : 0;

        $outgoingDocuments = Schema::hasTable('outboxes')
            ? DB::table('outboxes')->count()
            : 0;

        $pendingTasks = Schema::hasTable('tasks')
            ? DB::table('tasks')->whereIn(DB::raw('LOWER(status)'), ['pending', 'new', 'assigned'])->count()
            : 0;

        $completedTasks = Schema::hasTable('tasks')
            ? DB::table('tasks')->whereRaw('LOWER(status) = ?', ['completed'])->count()
            : 0;

        $overdueTasks = Schema::hasTable('tasks')
            ? DB::table('tasks')
                ->whereDate('deadline', '<', $today)
                ->whereRaw('LOWER(status) != ?', ['completed'])
                ->count()
            : 0;

        // NEW: Workflow cards
        $pendingApprovals = (
            class_exists(Workflow::class) &&
            Schema::hasTable('workflows')
        )
            ? Workflow::where('to_user_id', auth()->id())
                ->whereRaw('LOWER(status) = ?', ['pending'])
                ->count()
            : 0;

        $approvedWorkflows = Schema::hasTable('workflows')
            ? Workflow::whereRaw('LOWER(status) = ?', ['approved'])->count()
            : 0;

        $rejectedWorkflows = Schema::hasTable('workflows')
            ? Workflow::whereRaw('LOWER(status) = ?', ['rejected'])->count()
            : 0;

        // NEW: Audit cards
        $todayAuditLogs = (
            class_exists(AuditLog::class) &&
            Schema::hasTable('audit_logs')
        )
            ? AuditLog::whereDate('created_at', $today)->count()
            : 0;

        $recentAuditLogs = (
            class_exists(AuditLog::class) &&
            Schema::hasTable('audit_logs')
        )
            ? AuditLog::with('user')->latest()->limit(5)->get()
            : collect();

        $recentWorkflowActions = (
            class_exists(Workflow::class) &&
            Schema::hasTable('workflows')
        )
            ? Workflow::with(['fromUser', 'toUser'])->latest()->limit(5)->get()
            : collect();

        $recentOutboxes = Schema::hasTable('outboxes')
            ? DB::table('outboxes')
                ->select('id', 'doc_number', 'subject', 'receiver', 'doc_date', 'created_at')
                ->latest()
                ->limit(5)
                ->get()
            : collect();

        $recentTasks = Schema::hasTable('tasks')
            ? DB::table('tasks')
                ->select('id', 'title', 'task_code', 'status', 'deadline', 'created_at')
                ->latest()
                ->limit(5)
                ->get()
            : collect();

        $outboxChartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $outboxChartData = array_fill(0, 12, 0);

        if (Schema::hasTable('outboxes')) {
            $monthlyOutbox = DB::table('outboxes')
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', now()->year)
                ->groupByRaw('MONTH(created_at)')
                ->orderByRaw('MONTH(created_at)')
                ->get();

            for ($m = 1; $m <= 12; $m++) {
                $found = $monthlyOutbox->firstWhere('month', $m);
                $outboxChartData[$m - 1] = $found ? (int) $found->total : 0;
            }
        }

        $taskStatusCounts = Schema::hasTable('tasks')
            ? [
                DB::table('tasks')->whereIn(DB::raw('LOWER(status)'), ['pending', 'new', 'assigned'])->count(),
                DB::table('tasks')->whereIn(DB::raw('LOWER(status)'), ['in progress', 'in_progress'])->count(),
                DB::table('tasks')->whereRaw('LOWER(status) = ?', ['completed'])->count(),
                DB::table('tasks')
                    ->whereDate('deadline', '<', $today)
                    ->whereRaw('LOWER(status) != ?', ['completed'])
                    ->count(),
            ]
            : [0, 0, 0, 0];

        return view('dashboard', compact(
            'totalUsers',
            'totalEmployees',
            'incomingDocuments',
            'outgoingDocuments',
            'pendingTasks',
            'completedTasks',
            'overdueTasks',
            'pendingApprovals',
            'approvedWorkflows',
            'rejectedWorkflows',
            'todayAuditLogs',
            'recentAuditLogs',
            'recentWorkflowActions',
            'recentOutboxes',
            'recentTasks',
            'outboxChartLabels',
            'outboxChartData',
            'taskStatusCounts'
        ));
    }
}