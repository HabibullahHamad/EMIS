<!-- <?php

namespace App\Http\Controllers\CorrespondenceManagement;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class DashboardController extends Controller
{
    public function index()
    {
        try {

            // ==============================
            // 📊 KPI COUNTS
            // ==============================

            // $allTasks = Task::count();
            // $systemUsers = User::count();
            // $employees = Employee::count();
            $documents = Document::count();

            // ==============================
            // 📌 TASK STATUS COUNTS
            // ==============================

            $completedTasks = Task::where('status', 'completed')->count();
            $assignedTasks  = Task::where('status', 'assigned')->count();
            $pendingTasks   = Task::where('status', 'pending')->count();

            // ==============================
            // 📄 DOCUMENT TYPES
            // ==============================

            $incomingDocs = Document::where('type', 'incoming')->count();
            $outgoingDocs = Document::where('type', 'outgoing')->count();

            // ==============================
            // 📈 CHART DATA (Monthly Tasks)
            // ==============================

            $monthlyTasks = Task::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month');

            // Format for Chart.js
            $months = [];
            $taskCounts = [];

            for ($i = 1; $i <= 12; $i++) {
                $months[] = date("M", mktime(0, 0, 0, $i, 1));
                $taskCounts[] = $monthlyTasks[$i] ?? 0;
            }

            // ==============================
            // 📊 TASK STATUS CHART
            // ==============================

            $taskStatusChart = [
                'completed' => $completedTasks,
                'assigned'  => $assignedTasks,
                'pending'   => $pendingTasks,
            ];

            // ==============================
            // 👥 TEAM PERFORMANCE (STATIC / DEMO)
            // ==============================

            $teamPerformance = [
                ['team' => 'Team A', 'value' => 96.0],
                ['team' => 'Team B', 'value' => 89.8],
                ['team' => 'Team C', 'value' => 99.0],
            ];

            // ==============================
            // 📤 RETURN VIEW
            // ==============================

            return view('dashboard.index', compact(
                'allTasks',
                'systemUsers',
                'employees',
                'documents',
                'completedTasks',
                'assignedTasks',
                'pendingTasks',
                'incomingDocs',
                'outgoingDocs',
                'months',
                'taskCounts',
                'taskStatusChart',
                'teamPerformance'
            ));

        } catch (\Exception $e) {

            // Optional: log error

            \Log::error('Dashboard Error: ' . $e->getMessage());

            return back()->with('error', 'Dashboard failed to load.');
        }
    }
} -->