@extends('new')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .dashboard-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        padding: 16px;
        background: #fff;
        height: 100%;
    }

    .dashboard-stat {
        font-size: 28px;
        font-weight: 700;
        color: #074582;
        margin-bottom: 6px;
    }

    .dashboard-label {
        font-size: 14px;
        color: #475569;
        margin-bottom: 0;
    }

    .dashboard-icon {
        font-size: 24px;
        color: #074582;
    }

    .section-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        background: #fff;
        padding: 18px;
        margin-top: 20px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 16px;
    }

    .table-emis {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .table-emis thead {
        background: #074582;
        color: #fff;
    }

    .table-emis thead th,
    .table-emis tbody td {
        padding: 10px;
        text-align: right;
    }

    .table-emis tbody tr:nth-child(even) {
        background: #f8fafc;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .status-pending { background: #fff3cd; color: #856404; }
    .status-progress { background: #d1ecf1; color: #0c5460; }
    .status-completed { background: #d4edda; color: #155724; }
    .status-overdue { background: #f8d7da; color: #721c24; }

    .chart-box {
        position: relative;
        height: 320px;
    }
</style>

<div class="container-fluid">

    <div class="row g-3">
        <div class="col-md-3">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <div class="dashboard-stat">{{ $totalUsers }}</div>
                    <p class="dashboard-label">{{ __('emis.all_system_users') }}</p>
                </div>
                <div class="dashboard-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <div class="dashboard-stat">{{ $totalEmployees }}</div>
                    <p class="dashboard-label">{{ __('emis.total_employees') }}</p>
                </div>
                <div class="dashboard-icon">
                    <i class="fa-solid fa-id-badge"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <div class="dashboard-stat">{{ $incomingDocuments }}</div>
                    <p class="dashboard-label">{{ __('emis.incoming_documents') }}</p>
                </div>
                <div class="dashboard-icon">
                    <i class="fa-solid fa-file-import"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <div class="dashboard-stat">{{ $outgoingDocuments }}</div>
                    <p class="dashboard-label">{{ __('emis.outgoing_documents') }}</p>
                </div>
                <div class="dashboard-icon">
                    <i class="fa-solid fa-file-export"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <div class="dashboard-stat">{{ $pendingTasks }}</div>
                    <p class="dashboard-label">{{ __('emis.pending_tasks') }}</p>
                </div>
                <div class="dashboard-icon">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <div class="dashboard-stat">{{ $completedTasks }}</div>
                    <p class="dashboard-label">{{ __('emis.completed_tasks') }}</p>
                </div>
                <div class="dashboard-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <div class="dashboard-stat">{{ $overdueTasks }}</div>
                    <p class="dashboard-label">{{ __('emis.overdue_tasks') }}</p>
                </div>
                <div class="dashboard-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-md-7">
            <div class="section-card">
                <div class="section-title">{{ __('emis.outgoing_documents') }} {{ __('emis.charts') }}</div>
                <div class="chart-box">
                    <canvas id="outboxChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="section-card">
                <div class="section-title">{{ __('emis.tasks_management') }} {{ __('emis.charts') }}</div>
                <div class="chart-box">
                    <canvas id="tasksChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="section-card">
                <div class="section-title">{{ __('emis.outgoing_documents') }}</div>
                <div class="table-responsive">
                    <table class="table-emis">
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
                                    <td colspan="5">{{ __('emis.no_data_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="section-card">
                <div class="section-title">{{ __('emis.all_tasks') }}</div>
                <div class="table-responsive">
                    <table class="table-emis">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('emis.title') }}</th>
                                <th>{{ __('emis.task_code') }}</th>
                                <th>{{ __('emis.deadline') }}</th>
                                <th>{{ __('emis.status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTasks as $task)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $task->title ?? '-' }}</td>
                                    <td>{{ $task->task_code ?? '-' }}</td>
                                    <td>{{ $task->deadline ?? '-' }}</td>
                                    <td>
                                        @php
                                            $normalizedStatus = strtolower(trim($task->status ?? ''));

                                            $statusClass = match($normalizedStatus) {
                                                'pending' => 'status-pending',
                                                'in progress', 'in_progress' => 'status-progress',
                                                'completed' => 'status-completed',
                                                default => 'status-overdue',
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $task->status ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">{{ __('emis.no_data_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    const outboxCtx = document.getElementById('outboxChart');
    if (outboxCtx) {
        new Chart(outboxCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($outboxChartLabels) !!},
                datasets: [{
                    label: "{{ __('emis.outgoing_documents') }}",
                    data: {!! json_encode($outboxChartData) !!},
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
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
                    "In Progress",
                    "{{ __('emis.completed_tasks') }}",
                    "{{ __('emis.overdue_tasks') }}"
                ],
                datasets: [{
                    data: {!! json_encode($taskStatusCounts) !!},
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
</script>

@endsection