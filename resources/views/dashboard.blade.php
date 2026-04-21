@extends('new')

@section('page_title', __('emis.dashboard'))

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.dashboard-wrapper {
    max-width: 1400px;
    margin: auto;
}

.stats-grid {
    display:grid;
    grid-template-columns: repeat(4, 1fr);
    gap:16px;
    margin-bottom:20px;
}

.stats-grid-small {
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:16px;
    margin-bottom:20px;
}

.stat-card {
    background:#fff;
    border-radius:16px;
    padding:18px;
    border:1px solid #e2e8f0;
    box-shadow:0 6px 20px rgba(0,0,0,0.05);
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.stat-icon {
    width:50px;
    height:50px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
    color:white;
}

.bg-blue { background:#0b3563; }
.bg-green { background:#16a34a; }
.bg-orange { background:#ea580c; }
.bg-red { background:#dc2626; }

.stat-text h5 {
    margin:0;
    font-size:14px;
    color:#64748b;
}

.stat-text h3 {
    margin:4px 0 0;
    font-size:22px;
    font-weight:700;
    color:#1e293b;
}

.card-box {
    background:#fff;
    border-radius:16px;
    padding:18px;
    border:1px solid #e2e8f0;
    box-shadow:0 6px 20px rgba(0,0,0,0.05);
    margin-bottom:20px;
}

.card-title {
    font-size:16px;
    font-weight:700;
    margin-bottom:14px;
    color:#1e293b;
}

.chart-grid {
    display:grid;
    grid-template-columns: 2fr 1fr;
    gap:20px;
    margin-bottom:20px;
}

.chart-box {
    position:relative;
    height:320px;
}

.table th {
    font-size:12px;
    color:#64748b;
    background:#f8fafc;
}

.table td {
    font-size:13px;
    vertical-align:middle;
}

.badge-status {
    padding:4px 10px;
    border-radius:10px;
    font-size:12px;
}

.badge-pending { background:#fef3c7; color:#92400e; }
.badge-progress { background:#dbeafe; color:#1d4ed8; }
.badge-done { background:#dcfce7; color:#166534; }
.badge-overdue { background:#fee2e2; color:#991b1b; }

@media(max-width: 1200px){
    .stats-grid {
        grid-template-columns: repeat(2,1fr);
    }

    .stats-grid-small {
        grid-template-columns: repeat(3,1fr);
    }

    .chart-grid {
        grid-template-columns: 1fr;
    }
}

@media(max-width: 768px){
    .stats-grid,
    .stats-grid-small {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="dashboard-wrapper">

    {{-- Main Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-text">
                <h5>{{ __('emis.total_users') }}</h5>
                <h3>{{ $totalUsers ?? 0 }}</h3>
            </div>
            <div class="stat-icon bg-blue">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-text">
                <h5>{{ __('emis.total_employees') }}</h5>
                <h3>{{ $totalEmployees ?? 0 }}</h3>
            </div>
            <div class="stat-icon bg-green">
                <i class="fa-solid fa-id-badge"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-text">
                <h5>{{ __('emis.incoming_documents') }}</h5>
                <h3>{{ $incomingDocuments ?? 0 }}</h3>
            </div>
            <div class="stat-icon bg-orange">
                <i class="fa-solid fa-inbox"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-text">
                <h5>{{ __('emis.outgoing_documents') }}</h5>
                <h3>{{ $outgoingDocuments ?? 0 }}</h3>
            </div>
            <div class="stat-icon bg-red">
                <i class="fa-solid fa-file-export"></i>
            </div>
        </div>
    </div>

    {{-- Task Stats --}}
    <div class="stats-grid-small">
        <div class="stat-card">
            <div class="stat-text">
                <h5>{{ __('emis.pending_tasks') }}</h5>
                <h3>{{ $pendingTasks ?? 0 }}</h3>
            </div>
            <div class="stat-icon bg-orange">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-text">
                <h5>{{ __('emis.completed_tasks') }}</h5>
                <h3>{{ $completedTasks ?? 0 }}</h3>
            </div>
            <div class="stat-icon bg-green">
                <i class="fa-solid fa-check"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-text">
                <h5>{{ __('emis.overdue_tasks') }}</h5>
                <h3>{{ $overdueTasks ?? 0 }}</h3>
            </div>
            <div class="stat-icon bg-red">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="chart-grid">
        <div class="card-box">
            <div class="card-title">{{ __('emis.outgoing_documents') }} {{ __('emis.charts') }}</div>
            <div class="chart-box">
                <canvas id="outboxChart"></canvas>
            </div>
        </div>

        <div class="card-box">
            <div class="card-title">{{ __('emis.tasks_management') }} {{ __('emis.charts') }}</div>
            <div class="chart-box">
                <canvas id="tasksChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Outbox --}}
    <div class="card-box">
        <div class="card-title">{{ __('emis.recent_outgoing_documents') }}</div>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('emis.document_number') }}</th>
                    <th>{{ __('emis.subject') }}</th>
                    <th>{{ __('emis.receiver') }}</th>
                    <th>{{ __('emis.date') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOutboxes as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->doc_number ?? '-' }}</td>
                    <td>{{ $item->subject ?? '-' }}</td>
                    <td>{{ $item->receiver ?? '-' }}</td>
                    <td>{{ $item->doc_date ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">{{ __('emis.no_data') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Recent Tasks --}}
    <div class="card-box">
        <div class="card-title">{{ __('emis.recent_tasks') }}</div>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('emis.task_code') }}</th>
                    <th>{{ __('emis.title') }}</th>
                    <th>{{ __('emis.status') }}</th>
                    <th>{{ __('emis.deadline') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTasks as $task)
                @php
                    $normalizedStatus = strtolower(trim($task->status ?? ''));
                    $statusClass = match($normalizedStatus) {
                        'pending' => 'badge-pending',
                        'in progress', 'in_progress' => 'badge-progress',
                        'completed' => 'badge-done',
                        default => 'badge-overdue',
                    };
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $task->task_code ?? '-' }}</td>
                    <td>{{ $task->title ?? '-' }}</td>
                    <td>
                        <span class="badge-status {{ $statusClass }}">
                            {{ $task->status ?? '-' }}
                        </span>
                    </td>
                    <td>{{ $task->deadline ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">{{ __('emis.no_data') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
const outboxCtx = document.getElementById('outboxChart');
if (outboxCtx) {
    new Chart(outboxCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($outboxChartLabels ?? []) !!},
            datasets: [{
                label: "{{ __('emis.outgoing_documents') }}",
                data: {!! json_encode($outboxChartData ?? []) !!},
                backgroundColor: '#0b3563',
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
}

const tasksCtx = document.getElementById('tasksChart');
if (tasksCtx) {
    new Chart(tasksCtx, {
        type: 'doughnut',
        data: {
            labels: [
                "{{ __('emis.pending_tasks') }}",
                "{{ __('emis.in_progress') }}",
                "{{ __('emis.completed_tasks') }}",
                "{{ __('emis.overdue_tasks') }}"
            ],
            datasets: [{
                data: {!! json_encode($taskStatusCounts ?? [0,0,0,0]) !!},
                backgroundColor: ['#f59e0b', '#3b82f6', '#16a34a', '#dc2626'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '68%',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}
</script>

@endsection