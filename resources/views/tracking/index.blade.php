@extends('new')

@section('content')

<style>
    .tracking-header{
        background:#fff;
        border-radius:14px;
        padding:18px 22px;
        box-shadow:0 2px 10px rgba(0,0,0,.08);
        margin-bottom:18px;
    }

.kpi-card{

border:0;

border-radius:14px;

min-height:78px;

box-shadow:
0 2px 8px rgba(
0,0,0,.08
);

transition:.3s;

overflow:hidden;

}

.kpi-card:hover{

transform:
translateY(
-2px
);

}

.kpi-card .card-body{

padding:

12px 16px;

}

.kpi-card small{

font-size:11px;

font-weight:600;

opacity:.9;

display:block;

margin-bottom:2px;

}

.kpi-card h3{

font-size:20px;

font-weight:700;

margin:0;

}

.kpi-card .icon{

font-size:24px;

opacity:.18;

}
    
    .tracking-section{
        background:#fff;
        border-radius:16px;
        margin-bottom:18px;
        box-shadow:0 2px 12px rgba(0,0,0,.08);
        overflow:hidden;
    }

    .section-header{
        padding:16px 20px;
        background:#f8fafc;
        border-bottom:1px solid #e5e7eb;
        display:flex;
        justify-content:space-between;
        align-items:center;
        cursor:pointer;
        font-weight:700;
    }

    .section-body{
        display:none;
        padding:20px;
    }

    .section-body.active{
        display:block;
    }

    .chart-box{
        height:320px;
        position:relative;
    }

    .tab-panel{
        display:none;
        margin-top:15px;
    }

    .tab-panel.active{
        display:block;
    }

    .btn-tab{
        border-radius:10px;
        padding:6px 16px;
        font-size:13px;

    }

    .record-link{
        font-weight:700;
        text-decoration:none;
        color:#0d6efd;
    }

    .badge-priority-high{background:#dc3545;color:white;}
    .badge-priority-medium{background:#ffc107;color:#111;}
    .badge-priority-low{background:#198754;color:white;}

    .badge-deadline-overdue{background:#dc3545;color:white;}
    .badge-deadline-today{background:#fd7e14;color:white;}
    .badge-deadline-normal{background:#0dcaf0;color:white;}

    .table th{
        font-size:13px;
        background:#f8fafc;
        white-space:nowrap;
    }

    .table td{
        font-size:13px;
        vertical-align:middle;
    }

    @media print{
        .no-print{display:none!important;}
        .section-body{display:block!important;}
        body{background:#fff;}
    }
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="tracking-header no-print">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div>
                <h4 class="fw-bold mb-1">
                    <i class="fa-solid fa-location-crosshairs text-primary"></i>
                    Tracking & Monitoring Center
                </h4>
                <small class="text-muted">
                    Track incoming documents, outgoing documents, tasks, status, priority and deadlines.
                </small>
            </div>

          <button onclick="printAllTracking()"
class="btn btn-danger btn-sm">

<i class="fa fa-print"></i>

Print All

</button>

        </div>
    </div>

    {{-- FILTERS --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3 no-print">
        <div class="card-body">
            <div class="row g-2">

                <div class="col-md-6">
                    <input type="text"
                           id="liveSearch"
                           class="form-control"
                           placeholder="Live search: number, subject, sender, receiver, status, priority...">
                </div>

                <div class="col-md-3">
                    <select id="moduleFilter" class="form-select">
                        <option value="all">All Sections</option>
                        <option value="inbox">Inbox Documents</option>
                        <option value="outbox">Outbox Documents</option>
                        <option value="tasks">Tasks</option>
                        <option value="workflows">Workflows</option>
                        <option value="departments">Department Performance</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button type="button"
                            onclick="resetTrackingSearch()"
                            class="btn btn-secondary w-100">
                        {{ __('emis.reset') }}
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- KPI CARDS --}}
    <div class="row g-3 mb-3">

    <div class="col-lg-2 col-md-4 col-6">
        

<div class="card kpi-card bg-primary text-white">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<small>

Inbox

</small>

<h3>

{{$stats['inbox']??0}}

</h3>

</div>

<i class="fa fa-inbox icon">

</i>

</div>

</div>

</div>
<!-- outbox card -->
     <div class="col-lg-2 col-md-4 col-6">

<div class="card kpi-card bg-success text-white">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<small>

Outbox

</small>

<h3>

{{$stats['outbox']??0}}

</h3>

</div>

<i class="fa fa-paper-plane icon">

</i>

</div>

</div>

</div>
<!-- tasks -->
        <div class="col-lg-2 col-md-4 col-6">

<div class="card kpi-card bg-warning">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<small>

Tasks

</small>

<h3>

{{$stats['tasks']??0}}

</h3>

</div>

<i class="fa fa-tasks icon">

</i>

</div>

</div>

</div>

       <div class="col-lg-2 col-md-4 col-6">

<div class="card kpi-card bg-dark text-white">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<small>

Workflow

</small>

<h3>

{{$stats['workflows']??0}}

</h3>

</div>

<i class="fa fa-diagram-project icon">

</i>

</div>

</div>

</div>

<div class="col-lg-2 col-md-4 col-6">

<div class="card kpi-card bg-info text-white">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<small>

Departments

</small>

<h3>

{{$stats['departments']??0}}

</h3>

</div>

<i class="fa fa-building icon">

</i>

</div>

</div>

</div>
        <div class="col-lg-2 col-md-4 col-6">

<div class="card kpi-card bg-danger text-white">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<small>

Overdue

</small>

<h3>

{{$stats['overdue']??0}}

</h3>

</div>

<i class="fa fa-triangle-exclamation icon">

</i>

</div>

</div>

</div>

    {{-- INBOX SECTION --}}
    <div class="tracking-section tracking-block" data-section="inbox">

        <div class="section-header" onclick="toggleSection('inboxBody')">
            <span><i class="fa fa-inbox text-primary"></i> Inbox Documents Tracking</span>
            <i class="fa fa-chevron-down"></i>
        </div>

        <div id="inboxBody" class="section-body active">

            <div class="d-flex gap-2 mb-3 no-print">
                <button class="btn btn-primary btn-sm btn-tab" onclick="openTab('inboxChartTab', this)">Charts</button>
                <button class="btn btn-success btn-sm btn-tab" onclick="openTab('inboxTableTab', this)">Table</button>
                <button class="btn btn-dark btn-sm btn-tab" onclick="printSection('inboxPrintArea')">
                    <i class="fa fa-print"></i> Print Section
                </button>
            </div>

            <div id="inboxPrintArea">

                <div id="inboxChartTab" class="tab-panel active">
                    <div class="chart-box">
                        <canvas id="inboxStatusChart"></canvas>
                    </div>
                </div>

                <div id="inboxTableTab" class="tab-panel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center tracking-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Letter No</th>
                                    <th>Order No</th>
                                    <th>{{ __('emis.subject') }}</th>
                                    <th>{{ __('emis.sender') }}</th>
                                    <th>{{ __('emis.receiver') }}</th>
                                    <th>{{ __('emis.status') }}</th>
                                    <th>{{ __('emis.date') }}</th>
                                    <th class="no-print">{{ __('emis.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inboxRecords as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('inbox.show',$item->id) }}" class="record-link">
                                                {{ $item->letter_no }}
                                            </a>
                                        </td>
                                        <td>{{ $item->order_number ?? '-' }}</td>
                                        <td>{{ $item->subject }}</td>
                                        <td>{{ $item->sender }}</td>
                                        <td>{{ $item->receiver }}</td>
                                        <td><span class="badge bg-secondary">{{ $item->status }}</span></td>
                                        <td>{{ $item->received_date }}</td>
                                        <td class="no-print">
                                            <a href="{{ route('inbox.show',$item->id) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button type="button" onclick="printRecord(this)" class="btn btn-sm btn-dark">
                                                <i class="fa fa-print"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="9" class="text-muted">No inbox records found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- OUTBOX SECTION --}}
    <div class="tracking-section tracking-block" data-section="outbox">

        <div class="section-header" onclick="toggleSection('outboxBody')">
            <span><i class="fa fa-paper-plane text-success"></i> Outbox Documents Tracking</span>
            <i class="fa fa-chevron-down"></i>
        </div>

        <div id="outboxBody" class="section-body">

            <div class="d-flex gap-2 mb-3 no-print">
                <button class="btn btn-primary btn-sm btn-tab" onclick="openTab('outboxChartTab', this)">Charts</button>
                <button class="btn btn-success btn-sm btn-tab" onclick="openTab('outboxTableTab', this)">Table</button>
                <button class="btn btn-dark btn-sm btn-tab" onclick="printSection('outboxPrintArea')">
                    <i class="fa fa-print"></i> Print Section
                </button>
            </div>

            <div id="outboxPrintArea">

                <div id="outboxChartTab" class="tab-panel active">
                    <div class="chart-box">
                        <canvas id="outboxPriorityChart"></canvas>
                    </div>
                </div>

                <div id="outboxTableTab" class="tab-panel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center tracking-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Doc No</th>
                                    <th>Order No</th>
                                    <th>{{ __('emis.subject') }}</th>
                                    <th>{{ __('emis.sender') }}</th>
                                    <th>{{ __('emis.receiver') }}</th>
                                    <th>{{ __('emis.priority') }}</th>
                                    <th>{{ __('emis.date') }}</th>
                                    <th class="no-print">{{ __('emis.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($outboxRecords as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('outbox.show',$item->id) }}" class="record-link">
                                                {{ $item->doc_number }}
                                            </a>
                                        </td>
                                        <td>{{ $item->order_number ?? '-' }}</td>
                                        <td>{{ $item->subject }}</td>
                                        <td>{{ $item->sender }}</td>
                                        <td>{{ $item->receiver }}</td>
                                        <td>
                                            <span class="badge
                                                @if($item->priority == 'High') badge-priority-high
                                                @elseif($item->priority == 'Medium') badge-priority-medium
                                                @else badge-priority-low
                                                @endif">
                                                {{ $item->priority }}
                                            </span>
                                        </td>
                                        <td>{{ $item->doc_date }}</td>
                                        <td class="no-print">
                                            <a href="{{ route('outbox.show',$item->id) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button type="button" onclick="printRecord(this)" class="btn btn-sm btn-dark">
                                                <i class="fa fa-print"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="9" class="text-muted">No outbox records found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- TASK SECTION --}}
    <div class="tracking-section tracking-block" data-section="tasks">

        <div class="section-header" onclick="toggleSection('taskBody')">
            <span><i class="fa fa-tasks text-warning"></i> Tasks Tracking</span>
            <i class="fa fa-chevron-down"></i>
        </div>

        <div id="taskBody" class="section-body">

            <div class="d-flex gap-2 mb-3 no-print">
                <button class="btn btn-primary btn-sm btn-tab" onclick="openTab('taskChartTab', this)">Charts</button>
                <button class="btn btn-success btn-sm btn-tab" onclick="openTab('taskTableTab', this)">Table</button>
                <button class="btn btn-dark btn-sm btn-tab" onclick="printSection('taskPrintArea')">
                    <i class="fa fa-print"></i> Print Section
                </button>
            </div>

            <div id="taskPrintArea">

                <div id="taskChartTab" class="tab-panel active">
                    <div class="chart-box">
                        <canvas id="taskStatusChart"></canvas>
                    </div>
                </div>

                <div id="taskTableTab" class="tab-panel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center tracking-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('emis.task_code') }}</th>
                                    <th>{{ __('emis.title') }}</th>
                                    <th>{{ __('emis.status') }}</th>
                                    <th>{{ __('emis.priority') }}</th>
                                    <th>{{ __('emis.deadline') }}</th>
                                    <th class="no-print">{{ __('emis.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($taskRecords as $item)
                                    @php
                                        $deadline = $item->deadline ? \Carbon\Carbon::parse($item->deadline) : null;
                                    @endphp

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('tasks.show',$item->id) }}" class="record-link">
                                                {{ $item->task_code }}
                                            </a>
                                        </td>
                                        <td>{{ $item->title }}</td>
                                        <td><span class="badge bg-secondary">{{ $item->status }}</span></td>
                                        <td>
                                            <span class="badge
                                                @if(strtolower($item->priority) == 'high') badge-priority-high
                                                @elseif(strtolower($item->priority) == 'medium') badge-priority-medium
                                                @else badge-priority-low
                                                @endif">
                                                {{ ucfirst($item->priority) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if(!$deadline)
                                                -
                                            @elseif($deadline->isPast() && strtolower($item->status) != 'completed')
                                                <span class="badge badge-deadline-overdue">Overdue</span>
                                            @elseif($deadline->isToday())
                                                <span class="badge badge-deadline-today">Today</span>
                                            @else
                                                <span class="badge badge-deadline-normal">
                                                    {{ $deadline->format('Y-m-d') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="no-print">
                                            <a href="{{ route('tasks.show',$item->id) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button type="button" onclick="printRecord(this)" class="btn btn-sm btn-dark">
                                                <i class="fa fa-print"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-muted">No task records found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="tracking-section tracking-block" data-section="workflows">

    <div class="section-header" onclick="toggleSection('workflowBody')">
        <span><i class="fa fa-diagram-project text-dark"></i> Workflow Tracking</span>
        <i class="fa fa-chevron-down"></i>
    </div>

    <div id="workflowBody" class="section-body">

        <div class="d-flex gap-2 mb-3 no-print">
            <button class="btn btn-primary btn-sm btn-tab" onclick="openTab('workflowChartTab', this)">Charts</button>
            <button class="btn btn-success btn-sm btn-tab" onclick="openTab('workflowTableTab', this)">Table</button>
            <button class="btn btn-dark btn-sm btn-tab" onclick="printSection('workflowPrintArea')">
                <i class="fa fa-print"></i> Print Section
            </button>
        </div>

        <div id="workflowPrintArea">

            <div id="workflowChartTab" class="tab-panel active">
                <div class="chart-box">
                    <canvas id="workflowStatusChart"></canvas>
                </div>
            </div>

            <div id="workflowTableTab" class="tab-panel">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center tracking-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('emis.title') }}</th>
                                <th>From User</th>
                                <th>To User</th>
                                <th>{{ __('emis.department') }}</th>
                                <th>{{ __('emis.priority') }}</th>
                                <th>{{ __('emis.status') }}</th>
                                <th>{{ __('emis.date') }}</th>
                                <th class="no-print">{{ __('emis.action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($workflowRecords as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <a href="{{ route('workflows.show',$item->id) }}" class="record-link">
                                            {{ $item->title }}
                                        </a>
                                    </td>

                                    <td>{{ optional($item->fromUser)->name ?? '-' }}</td>
                                    <td>{{ optional($item->toUser)->name ?? '-' }}</td>
                                    <td>{{ optional($item->toDepartment)->name ?? '-' }}</td>

                                    <td>
                                        <span class="badge
                                            @if($item->priority == 'urgent' || $item->priority == 'high') badge-priority-high
                                            @elseif($item->priority == 'normal') badge-priority-medium
                                            @else badge-priority-low
                                            @endif">
                                            {{ ucfirst($item->priority) }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>

                                    <td>{{ $item->created_at?->format('Y-m-d') }}</td>

                                    <td class="no-print">
                                        <a href="{{ route('workflows.show',$item->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <button type="button" onclick="printRecord(this)" class="btn btn-sm btn-dark">
                                            <i class="fa fa-print"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-muted">No workflow records found.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="tracking-section tracking-block" data-section="departments">

    <div class="section-header" onclick="toggleSection('departmentBody')">
        <span>
            <i class="fa fa-building text-info"></i>
            Department Performance Tracking
        </span>
        <i class="fa fa-chevron-down"></i>
    </div>

    <div id="departmentBody" class="section-body">

        <div class="d-flex gap-2 mb-3 no-print">
            <button class="btn btn-primary btn-sm btn-tab"
                    onclick="openTab('departmentChartTab', this)">
                Charts
            </button>

            <button class="btn btn-success btn-sm btn-tab"
                    onclick="openTab('departmentTableTab', this)">
                Table
            </button>

            <button class="btn btn-dark btn-sm btn-tab"
                    onclick="printSection('departmentPrintArea')">
                <i class="fa fa-print"></i> Print Section
            </button>
        </div>

        <div id="departmentPrintArea">

            <div id="departmentChartTab" class="tab-panel active">
                <div class="chart-box">
                    <canvas id="departmentChart"></canvas>
                </div>
            </div>

            <div id="departmentTableTab" class="tab-panel">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center tracking-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('emis.department') }}</th>
                                <th>Pashto Name</th>
                                <th>Dari Name</th>
                                <th>{{ __('emis.code') }}</th>
                                <th>Sub Departments</th>
                                <th>{{ __('emis.status') }}</th>
                                <th class="no-print">{{ __('emis.action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($departmentRecords as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <a href="{{ route('departments.show', $item->id) }}" class="record-link">
                                            {{ $item->name }}
                                        </a>
                                    </td>

                                    <td>{{ $item->name_ps ?? '-' }}</td>
                                    <td>{{ $item->name_fa ?? '-' }}</td>
                                    <td>{{ $item->code ?? '-' }}</td>

                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $item->children_count }}
                                        </span>
                                    </td>

                                    <td>
                                        @if($item->status)
                                            <span class="badge bg-success">{{ __('emis.active') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('emis.inactive') }}</span>
                                        @endif
                                    </td>

                                    <td class="no-print">
                                        <a href="{{ route('departments.show', $item->id) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <button type="button"
                                                onclick="printRecord(this)"
                                                class="btn btn-sm btn-dark">
                                            <i class="fa fa-print"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-muted">
                                        No departments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

@endsection

@push('scripts')
<script>
function toggleSection(id){
    document.getElementById(id).classList.toggle('active');
}

function openTab(tabId, btn){
    let body = btn.closest('.section-body');

    body.querySelectorAll('.tab-panel').forEach(el => el.classList.remove('active'));
    body.querySelectorAll('.btn-tab').forEach(el => el.classList.remove('active'));

    document.getElementById(tabId).classList.add('active');
    btn.classList.add('active');
}

function printSection(id){

let content=

document
.getElementById(id)

.cloneNode(true);

content
.querySelectorAll('.no-print')

.forEach(
e=>e.remove()
);

let w=

window.open(
'',
'_blank'
);

w.document.write(`

<html>

<head>

<title>

EMIS Tracking Report

</title>

<link rel="stylesheet"

href="{{ asset('css/bootstrap.min.css') }}">

<style>

body{

padding:25px;

font-family:Arial;

direction:rtl;

}

.report-header{

text-align:center;

margin-bottom:20px;

border-bottom:2px solid black;

padding-bottom:10px;

}

table{

width:100%;

border-collapse:collapse;

}

table,
th,
td{

border:1px solid #999;

}

th{

background:#f1f1f1;

}

</style>

</head>

<body>

<div class="report-header">

<h3>

EMIS Tracking Report

</h3>

</div>

${content.innerHTML}

</body>

</html>

`);

w.document.close();

setTimeout(()=>{

w.print();

},500);

}

function printRecord(button){
    let row = button.closest('tr').cloneNode(true);
    row.querySelectorAll('.no-print').forEach(el => el.remove());

    let win = window.open('', '', 'width=900,height=500');

    win.document.write(`
        <html>
        <head>
            <title>EMIS Record Print</title>
            <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
            <style>
                body{padding:25px;font-family:Arial}
                table{width:100%}
            </style>
        </head>
        <body>
            <h4>EMIS Tracking Record</h4>
            <table class="table table-bordered">${row.outerHTML}</table>
        </body>
        </html>
    `);

    win.document.close();
    win.focus();
    win.print();
}

function resetTrackingSearch(){
    document.getElementById('liveSearch').value = '';
    document.getElementById('moduleFilter').value = 'all';

    document.querySelectorAll('.tracking-block').forEach(s => s.style.display = '');
    document.querySelectorAll('.tracking-table tbody tr').forEach(r => r.style.display = '');
}

document.getElementById('liveSearch').addEventListener('keyup', function(){
    let value = this.value.toLowerCase();

    document.querySelectorAll('.tracking-table tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});

document.getElementById('moduleFilter').addEventListener('change', function(){
    let value = this.value;

    document.querySelectorAll('.tracking-block').forEach(section => {
        section.style.display = (value === 'all' || section.dataset.section === value) ? '' : 'none';
    });
});

document.addEventListener('DOMContentLoaded', function(){
    if(typeof Chart === 'undefined'){
        console.error('Chart.js not loaded');
        return;
    }

    new Chart(document.getElementById('inboxStatusChart'), {
        type:'doughnut',
        data:{
            labels:@json($inboxStatus->keys()),
            datasets:[{data:@json($inboxStatus->values())}]
        },
        options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom'}}}
    });

    new Chart(document.getElementById('outboxPriorityChart'), {
        type:'bar',
        data:{
            labels:@json($outboxPriority->keys()),
            datasets:[{label:'Outbox Priority',data:@json($outboxPriority->values())}]
        },
        options:{responsive:true,maintainAspectRatio:false,scales:{y:{beginAtZero:true}},plugins:{legend:{display:false}}}
    });

    new Chart(document.getElementById('taskStatusChart'), {
        type:'pie',
        data:{
            labels:@json($taskStatus->keys()),
            datasets:[{data:@json($taskStatus->values())}]
        },
        options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom'}}}
    });
});

new Chart(document.getElementById('workflowStatusChart'), {
    type:'doughnut',
    data:{
        labels:@json($workflowStatus->keys()),
        datasets:[{data:@json($workflowStatus->values())}]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{legend:{position:'bottom'}}
    }
});
function printAllTracking(){

let body=

document
.querySelector(
'.container-fluid'
)

.cloneNode(true);

body

.querySelectorAll(
'.no-print'
)

.forEach(
e=>e.remove()
);

let w=

window.open(
'',
'_blank'
);

w.document.write(`

<html>

<head>

<title>

EMIS Full Report

</title>

<link rel="stylesheet"

href="{{ asset('css/bootstrap.min.css') }}">

<style>

body{

padding:25px;

font-family:Arial;

direction:rtl;

}

h3{

text-align:center;

}

.section-body{

display:block!important;

}

table{

width:100%;

}

</style>

</head>

<body>

<h3>

EMIS Executive Tracking Report

</h3>

${body.innerHTML}

</body>

</html>

`);

w.document.close();

setTimeout(()=>{

w.print();

},700);

}
new Chart(document.getElementById('departmentChart'), {
    type: 'bar',
    data: {
        labels: @json($departmentLabels),
        datasets: [{
            label: 'Sub Departments',
            data: @json($departmentData)
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
@endpush