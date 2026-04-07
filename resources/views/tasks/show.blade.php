@extends('new')

@section('content')

<style>
    .detail-card {
        background: #fff;
        border-radius: 10px;
        padding: 16px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
    }

    .detail-label {
        font-size: 13px;
        font-weight: 700;
        color: #555;
        margin-bottom: 3px;
    }

    .detail-value {
        font-size: 14px;
        margin-bottom: 12px;
    }

    .priority-badge,
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        color: #fff;
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
</style>

<div class="container-fluid">

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Task Details</h5>

        <div class="d-flex gap-2">
            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">
                Edit
            </a>
            <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-secondary">
                Back
            </a>
        </div>
    </div>

    <div class="detail-card">
        <div class="row">

            <div class="col-md-3">
                <div class="detail-label">Task Code</div>
                <div class="detail-value">{{ $task->task_code }}</div>
            </div>

            <div class="col-md-6">
                <div class="detail-label">Title</div>
                <div class="detail-value">{{ $task->title }}</div>
            </div>

            <div class="col-md-3">
                <div class="detail-label">Assigned Employee</div>
                <div class="detail-value">{{ $task->employee->full_name ?? '-' }}</div>
            </div>

            <div class="col-md-3">
                <div class="detail-label">Source Type</div>
                <div class="detail-value">{{ $task->source_type ?? '-' }}</div>
            </div>

            <div class="col-md-3">
                <div class="detail-label">Reference No</div>
                <div class="detail-value">{{ $task->source_reference ?? '-' }}</div>
            </div>

            <div class="col-md-3">
                <div class="detail-label">Priority</div>
                <div class="detail-value">
                    <span class="priority-badge priority-{{ $task->priority }}">
                        {{ ucfirst($task->priority) }}
                    </span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    <span class="status-badge status-{{ $task->status }}">
                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                    </span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="detail-label">Deadline</div>
                <div class="detail-value">{{ optional($task->deadline)->format('Y-m-d') ?? '-' }}</div>
            </div>

            <div class="col-md-3">
                <div class="detail-label">Created At</div>
                <div class="detail-value">{{ optional($task->created_at)->format('Y-m-d H:i') }}</div>
            </div>

            <div class="col-md-12">
                <div class="detail-label">Description</div>
                <div class="detail-value">{{ $task->description ?? '-' }}</div>
            </div>

            <div class="col-md-12">
                <div class="detail-label">Remarks</div>
                <div class="detail-value">{{ $task->remarks ?? '-' }}</div>
            </div>

        </div>
    </div>

</div>
@endsection