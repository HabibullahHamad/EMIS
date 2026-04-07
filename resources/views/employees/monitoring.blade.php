@extends('new')

@section('content')


<style>
    .monitor-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
        background: #fff;
    }

    .monitor-stat {
        text-align: center;
        padding: 16px 10px;
    }

    .monitor-stat h6 {
        font-size: 13px;
        margin-bottom: 8px;
        color: #555;
    }

    .monitor-stat h3 {
        margin: 0;
        font-weight: 700;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 12px;
    }
</style>

<div class="container-fluid">

    <div class="card monitor-card mb-3">
        <div class="card-body">
            <h4 class="mb-1">{{ $employee->full_name }}</h4>
            <div><strong>Code:</strong> {{ $employee->employee_code }}</div>
            <div><strong>Status:</strong> {{ ucfirst($employee->status) }}</div>
            <div><strong>Email:</strong> {{ $employee->email ?? '-' }}</div>
            <div><strong>Phone:</strong> {{ $employee->phone ?? '-' }}</div>
        </div>
    </div>

    <div class="section-title">Task Monitoring</div>
    <div class="row mb-3">
        <div class="col-md-3 mb-2">
            <div class="card monitor-card">
                <div class="monitor-stat">
                    <h6>Total Tasks</h6>
                    <h3>{{ $taskStats['total'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-2">
            <div class="card monitor-card">
                <div class="monitor-stat">
                    <h6 class="text-success">Completed</h6>
                    <h3 class="text-success">{{ $taskStats['completed'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-2">
            <div class="card monitor-card">
                <div class="monitor-stat">
                    <h6 class="text-warning">Pending</h6>
                    <h3 class="text-warning">{{ $taskStats['pending'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-2">
            <div class="card monitor-card">
                <div class="monitor-stat">
                    <h6 class="text-danger">Overdue</h6>
                    <h3 class="text-danger">{{ $taskStats['overdue'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="section-title">Documents and Correspondence</div>
    <div class="row mb-3">
        <div class="col-md-4 mb-2">
            <div class="card monitor-card">
                <div class="monitor-stat">
                    <h6>Total Documents</h6>
                    <h3>{{ $documentStats['total'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-2">
            <div class="card monitor-card">
                <div class="monitor-stat">
                    <h6 class="text-primary">Inbox Correspondence</h6>
                    <h3 class="text-primary">{{ $correspondenceStats['inbox'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-2">
            <div class="card monitor-card">
                <div class="monitor-stat">
                    <h6 class="text-info">Outgoing Correspondence</h6>
                    <h3 class="text-info">{{ $correspondenceStats['outgoing'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card monitor-card">
                <div class="card-header">Recent Tasks</div>
                <div class="card-body">
                    @forelse($recentTasks as $task)
                        <div class="border-bottom py-2">
                            <strong>{{ $task->title ?? 'Task' }}</strong><br>
                            <small>Status: {{ $task->status ?? '-' }}</small><br>
                            <small>Due Date: {{ $task->due_date ?? '-' }}</small>
                        </div>
                    @empty
                        <div>No recent tasks found.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card monitor-card">
                <div class="card-header">Recent Correspondence</div>
                <div class="card-body">
                    @forelse($recentCorrespondences as $item)
                        <div class="border-bottom py-2">
                            <strong>{{ $item->subject ?? 'Correspondence' }}</strong><br>
                            <small>Direction: {{ $item->direction ?? '-' }}</small><br>
                            <small>Status: {{ $item->status ?? '-' }}</small>
                        </div>
                    @empty
                        <div>No recent correspondence found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>

</div>
@endsection