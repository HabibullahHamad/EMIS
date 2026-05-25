<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inbox;
use App\Models\Workflow;
use App\Models\OutgoingDocument;
use App\Models\Task;
use Carbon\Carbon;
use App\Models\Department;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        // INBOX

        $inboxQuery = Inbox::query();

        if($search){

            $inboxQuery->where(function($q)use($search){

                $q->where('letter_no','like',"%$search%")
                ->orWhere('order_number','like',"%$search%")
                ->orWhere('subject','like',"%$search%")
                ->orWhere('sender','like',"%$search%")
                ->orWhere('receiver','like',"%$search%")
                ->orWhere('status','like',"%$search%");

            });

        }

        // OUTBOX

        $outboxQuery = OutgoingDocument::query();

        if($search){

            $outboxQuery->where(function($q)use($search){

                $q->where('doc_number','like',"%$search%")
                ->orWhere('order_number','like',"%$search%")
                ->orWhere('subject','like',"%$search%")
                ->orWhere('sender','like',"%$search%")
                ->orWhere('receiver','like',"%$search%")
                ->orWhere('priority','like',"%$search%");

            });

        }

        // TASKS

        $taskQuery = Task::query();

        if($search){

            $taskQuery->where(function($q)use($search){

                $q->where('task_code','like',"%$search%")
                ->orWhere('title','like',"%$search%")
                ->orWhere('status','like',"%$search%")
                ->orWhere('priority','like',"%$search%");

            });

        }

        $inboxRecords=$inboxQuery->latest()->get();

        $outboxRecords=$outboxQuery->latest()->get();

        $taskRecords=$taskQuery->latest()->get();


        // KPIs

        $stats=[

            'inbox'=>Inbox::count(),

            'outbox'=>OutgoingDocument::count(),

            'tasks'=>Task::count(),

            'completed'=>

            Task::where(
            'status',
            'completed'
            )->count(),

            'overdue'=>

            Task::whereDate(
            'deadline',
            '<',
            Carbon::today()
            )->count()

        ];


        // CHARTS

        $inboxStatus=

        Inbox::

        selectRaw(
        'status,
        count(*) total'
        )

        ->groupBy(
        'status'
        )

        ->pluck(
        'total',
        'status'
        );


        $outboxPriority=

        OutgoingDocument::

        selectRaw(
        'priority,
        count(*) total'
        )

        ->groupBy(
        'priority'
        )

        ->pluck(
        'total',
        'priority'
        );


        $taskStatus=

        Task::

        selectRaw(
        'status,
        count(*) total'
        )

        ->groupBy(
        'status'
        )

        ->pluck(
        'total',
        'status'
        );

$workflowQuery = Workflow::with(['fromUser', 'toUser', 'toDepartment']);

if ($search) {
    $workflowQuery->where(function ($q) use ($search) {
        $q->where('title', 'like', "%{$search}%")
          ->orWhere('status', 'like', "%{$search}%")
          ->orWhere('priority', 'like', "%{$search}%");
    });
}

$workflowRecords = $workflowQuery->latest()->get();

$workflowStatus = Workflow::selectRaw('status, COUNT(*) as total')
    ->groupBy('status')
    ->pluck('total', 'status');

$stats['workflows'] = Workflow::count();
$stats['pending_workflows'] = Workflow::where('status', 'pending')->count();


$departmentRecords = Department::withCount([
    'children',
])
->latest()
->get();

$departmentLabels = $departmentRecords->pluck('name');

$departmentData = $departmentRecords->pluck('children_count');

$stats['departments'] = Department::count();
        return view(

        'tracking.index',

        compact(

        'stats',

        'inboxRecords',

        'outboxRecords',

        'taskRecords',

        'inboxStatus',

        'outboxPriority',

        'taskStatus',
        'workflowRecords',
        'workflowStatus',
        'departmentRecords',
'departmentLabels',
'departmentData',

        )

        );

    }
}