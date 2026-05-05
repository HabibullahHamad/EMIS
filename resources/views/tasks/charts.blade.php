@extends('new')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .page-header {
        background: #fff;
        border-radius: 8px;
        padding: 8px 12px;
        min-height: 45px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.05);
        margin-bottom: 12px;
    }

    .stats-card,
    .chart-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
        border: none;
    }

    .chart-card {
        padding: 14px;
    }

    .chart-card h6 {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .stats-card .card-body {
        text-align: center;
        padding: 14px 10px;
    }

    .stats-card h6 {
        font-size: 13px;
        margin-bottom: 8px;
        color: #666;
    }

    .stats-card h3 {
        margin: 0;
        font-weight: 700;
    }

    canvas {
        max-height: 280px;
    }
</style>

<div class="container-fluid">

    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0">Task Charts Dashboard</h5>

        <div class="d-flex gap-2">
            <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-secondary">
                Back to Tasks
            </a>
        </div>
    </div>

    {{-- Summary cards --}}
    <div class="row mb-3">
        <div class="col-md-2 mb-2">
            <div class="card stats-card">
                <div class="card-body">
                    <h6>Total</h6>
                    <h3>{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2 mb-2">
            <div class="card stats-card">
                <div class="card-body">
                    <h6 class="text-primary">New</h6>
                    <h3 class="text-primary">{{ $stats['new'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2 mb-2">
            <div class="card stats-card">
                <div class="card-body">
                    <h6 class="text-info">Assigned</h6>
                    <h3 class="text-info">{{ $stats['assigned'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2 mb-2">
            <div class="card stats-card">
                <div class="card-body">
                    <h6 class="text-success">Completed</h6>
                    <h3 class="text-success">{{ $stats['completed'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2 mb-2">
            <div class="card stats-card">
                <div class="card-body">
                    <h6 class="text-danger">Overdue</h6>
                    <h3 class="text-danger">{{ $stats['overdue'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts row 1 --}}
    <div class="row mb-3">
        <div class="col-md-6 mb-3">
            <div class="card chart-card">
                <h6>Tasks by Status</h6>
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card chart-card">
                <h6>Tasks by Priority</h6>
                <canvas id="priorityChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Charts row 2 --}}
    <div class="row mb-3">
        <div class="col-md-12 mb-3">
            <div class="card chart-card">
                <h6>Tasks by Employee</h6>
                <canvas id="employeeChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['New', 'Assigned', 'In Progress', 'Completed', 'Overdue', 'Cancelled'],
            datasets: [{
                data: [
                    {{ $statusChart['new'] }},
                    {{ $statusChart['assigned'] }},
                    {{ $statusChart['in_progress'] }},
                    {{ $statusChart['completed'] }},
                    {{ $statusChart['overdue'] }},
                    {{ $statusChart['cancelled'] }}
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    new Chart(document.getElementById('priorityChart'), {
        type: 'pie',
        data: {
            labels: ['Low', 'Medium', 'High', 'Urgent'],
            datasets: [{
                data: [
                    {{ $priorityChart['low'] }},
                    {{ $priorityChart['medium'] }},
                    {{ $priorityChart['high'] }},
                    {{ $priorityChart['urgent'] }}
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });





    new Chart(document.getElementById('employeeChart'), {
        type: 'bar',
        data: {

            labels: {!! json_encode($employeeLabels) !!},
            datasets: [{
                label: 'Tasks',
                data: {!! json_encode($employeeData) !!}
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection
