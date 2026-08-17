@extends('new')

@section('content')

<style>
    .page-header {
        background: #fff;
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 16px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
    }

    .stats-card,
    .chart-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
        border: none;
    }

    .stats-card .card-body {
        text-align: center;
        padding: 16px 10px;
    }

    .stats-card h6 {
        font-size: 13px;
        color: #666;
        margin-bottom: 8px;
    }

    .stats-card h3 {
        margin: 0;
        font-weight: 700;
    }

    .chart-card {
        padding: 18px;
    }

    .chart-card h6 {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .chart-box {
        height: 300px;
        position: relative;
    }
</style>

<div class="container-fluid">

    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0">
            <i class="fa-solid fa-chart-pie"></i>
            Task Charts Dashboard
        </h5>

        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Tasks
        </a>
    </div>

    <div class="row mb-3">

        <div class="col-md-2 mb-2">
            <div class="card stats-card">
                <div class="card-body">
                    <h6>Total</h6>
                    <h3>{{ $stats['total'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2 mb-2">
            <div class="card stats-card">
                <div class="card-body">
                    <h6 class="text-primary">New</h6>
                    <h3 class="text-primary">{{ $stats['new'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2 mb-2">
            <div class="card stats-card">
                <div class="card-body">
                    <h6 class="text-info">Assigned</h6>
                    <h3 class="text-info">{{ $stats['assigned'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2 mb-2">
            <div class="card stats-card">
                <div class="card-body">
                    <h6 class="text-success">{{ __('emis.completed') }}</h6>
                    <h3 class="text-success">{{ $stats['completed'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2 mb-2">
            <div class="card stats-card">
                <div class="card-body">
                    <h6 class="text-danger">Overdue</h6>
                    <h3 class="text-danger">{{ $stats['overdue'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-md-6 mb-3">
            <div class="card chart-card">
                <h6>Tasks by Status</h6>
                <div class="chart-box">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card chart-card">
                <h6>Tasks by Priority</h6>
                <div class="chart-box">
                    <canvas id="priorityChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-md-12 mb-3">
            <div class="card chart-card">
                <h6>Tasks by Employee</h6>
                <div class="chart-box">
                    <canvas id="employeeChart"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    if (typeof Chart === 'undefined') {
        console.error('Chart.js not loaded. Check public/js/chart.umd.min.js and new.blade.php');
        return;
    }

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['New', 'Assigned', 'In Progress', 'Completed', 'Overdue', 'Cancelled'],
            datasets: [{
                data: [
                    {{ $statusChart['new'] ?? 0 }},
                    {{ $statusChart['assigned'] ?? 0 }},
                    {{ $statusChart['in_progress'] ?? 0 }},
                    {{ $statusChart['completed'] ?? 0 }},
                    {{ $statusChart['overdue'] ?? 0 }},
                    {{ $statusChart['cancelled'] ?? 0 }}
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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
                    {{ $priorityChart['low'] ?? 0 }},
                    {{ $priorityChart['medium'] ?? 0 }},
                    {{ $priorityChart['high'] ?? 0 }},
                    {{ $priorityChart['urgent'] ?? 0 }}
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    new Chart(document.getElementById('employeeChart'), {
        type: 'bar',
        data: {
            labels: @json($employeeLabels ?? []),
            datasets: [{
                label: 'Tasks',
                data: @json($employeeData ?? [])
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

});
</script>
@endpush