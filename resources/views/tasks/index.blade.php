@extends('new')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    /* Small compact stats cards */
.small-card {
    min-height: 52px;
}

.small-card h4 {
    font-size: 14px;
}

.small-card .card-body {
    padding: 4px 6px !important;
}

.small-card h6 {
    font-size: 11px;
    margin-bottom: 2px;
}



/* Hover effect */
.hover-card {
    transition: 0.2s;
    cursor: pointer;
}

.hover-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(0,0,0,0.12);
}
.hover-card {
    transition: 0.2s;
    cursor: pointer;
   background: #14ca30;
}

.hover-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    
    background: #2166ab;
}


     .table-status-select {
    font-size: 11px;
    height: 28px;
    padding: 2px 6px;
}

    .page-header {
        background: #fff;
        border-radius: 8px;
        padding: 6px 12px;
        min-height: 45px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.05);
        margin-bottom: 1px;
        direction:rtl;
    }

    .page-header .form-control,
    .page-header .form-select,
    .page-header .btn,
    .page-header .input-group-text {
        height: 30px !important;
        font-size: 12px;
    }

    .stats-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
        border: none;
        margin-bottom: 0px;
    }

    .table-card {
        background: #fff;
        border-radius: 8px;
        padding: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
        margin-bottom: 1px;
    }

    .table thead th {
        font-size: 13px;
        text-align: center;
        vertical-align: middle;
        margin-bottom: 1px;
    }

    .table tbody td {
        font-size: 12px;
        text-align: center;
        vertical-align: middle;
    }
    .priority-badge,
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        color: #fff;
        min-width: 75px;
    }

    .priority-low { background: #6c757d; }
    .priority-medium { background: #0d6efd; }
    .priority-high { background: #fd7e14; }
    .priority-urgent { background: #dc3545; }

    .status-new { background: #6f42c1; }
    .status-assigned { background: #0d6efd; }
    .status-in_progress { background: #ffc107; color: #000; }
    .status-completed { background: #198754; }
    .status-overdue { background: #dc3545; }
    .status-cancelled { background: #6c757d; }

    .custom-pagination .page-link {
        color: #0d6efd;
        border-radius: 6px;
        padding: 3px 10px;
        font-size: 13px;
    }

    .custom-pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff !important;
    }
</style>

<div class="container-fluid">

    {{-- Header --}}
    <div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
<a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg"></i> Add Task
            </a>
        <form method="GET" action="{{ route('tasks.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
            <div class="input-group input-group-sm" style="width:220px;">
                <span class="input-group-text">🔍</span>
                <input type="text"
                       name="search"
                       class="form-control form-control-sm"
                       placeholder="Search task..."
                       value="{{ request('search') }}">
            </div>
<select name="status" class="form-select form-select-sm table-status-select" style="width:130px;">
                <option value="">All Status</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <button type="submit" class="btn btn-outline-secondary btn-sm">Filter</button>

            <a href="{{ route('tasks.index') }}" class="btn btn-outline-dark btn-sm">Reset</a>
        </form>

        <div class="text-center flex-grow-1">
            <h6 class="mb-0 fw-semibold">Task Management</h6>
        </div>

        <div>
            
   
        </div>
    </div>

    {{-- Success --}}
    @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif

   {{-- Stats --}}
<div class="row mb-2">

    @foreach([
        ['label' => 'Total', 'value' => $stats['total'] ?? 0, 'class' => ''],
        ['label' => 'New', 'value' => $stats['new'] ?? 0, 'class' => 'text-primary'],
        ['label' => 'Assigned', 'value' => $stats['assigned'] ?? 0, 'class' => 'text-info'],
        ['label' => 'Completed', 'value' => $stats['completed'] ?? 0, 'class' => 'text-success'],
        
    ] as $item)

    <div class="col-md-2 mb-2">
        <div class="card stats-card text-center small-card">
            <div class="card-body py-1">
                <h6 class="mb-0 {{ $item['class'] }}">{{ $item['label'] }}</h6>
                <h4 class="mb-0 {{ $item['class'] }}">{{ $item['value'] }}</h4>
            </div>
        </div>
    </div>

    @endforeach

    {{-- Charts Button --}}
    <div class="col-md-2 mb-2">
        <a href="{{ route('tasks.charts') }}" class="text-decoration-none">
            <div class="card stats-card text-center small-card hover-card">
                <div class="card-body py-1 d-flex flex-column justify-content-center align-items-center">
                    <i class="bi bi-bar-chart-line text-danger mb-1" style="font-size:16px;"></i>
                    <h6 class="mb-0 text-danger">Viewe in Charts</h6>
                </div>
            </div>
        </a>
    </div>

</div>
    <!-- js charts-->


    <!-- end chart -->

    {{-- Table --}}
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Task Code</th>
                        <th>Title</th>
                        <th>Employee</th>
                        <th>Source Type</th>
                        <th>Reference</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Deadline</th>
                        <th width="200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->task_code }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->employee->full_name ?? '-' }}</td>
                            <td>{{ $task->source_type ?? '-' }}</td>
                            <td>{{ $task->source_reference ?? '-' }}</td>

                            <td>
                                <span class="priority-badge priority-{{ $task->priority }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>

                       <td>
    <form action="{{ route('tasks.changeStatus', $task->id) }}" method="POST" class="d-flex align-items-center justify-content-center gap-1">
        @csrf
        @method('PATCH')

        <select name="status" class="form-select form-select-sm" style="width:130px;">
            <option value="new" {{ $task->status == 'new' ? 'selected' : '' }}>New</option>
            <option value="assigned" {{ $task->status == 'assigned' ? 'selected' : '' }}>Assigned</option>
            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="overdue" {{ $task->status == 'overdue' ? 'selected' : '' }}>Overdue</option>
            <option value="cancelled" {{ $task->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <button type="submit" class="btn btn-sm btn-success" title="Update Status">
            <i class="bi bi-check2"></i>
        </button>
    </form>
</td>

                            <td>{{ $task->deadline?->format('Y-m-d') ?? '-' }}</td>

                            <td>
                                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            title="Delete"
                                            onclick="return confirm('Delete this task?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('tasks.monitoring', $task->id) }}"
   class="btn btn-sm btn-primary"
   title="Monitoring">
    <i class="bi bi-bar-chart"></i>
</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No tasks found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $tasks->links() }}
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const statusChart = new Chart(document.getElementById('statusChart'), {
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
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    const priorityChart = new Chart(document.getElementById('priorityChart'), {
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
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    const employeeChart = new Chart(document.getElementById('employeeChart'), {
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
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection