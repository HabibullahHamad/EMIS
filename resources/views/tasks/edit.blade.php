@extends('new')

@section('content')

<style>
    .form-card {
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
    }

    .form-control,
    .form-select {
        font-size: 13px;
        height: 34px;
    }

    textarea.form-control {
        height: auto;
    }
</style>

<div class="container-fluid">

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit Task</h5>

        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-secondary">
            Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li style="font-size:13px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-3 mb-3">
                    <label class="form-label">Task Code *</label>
                    <input type="text"
                           name="task_code"
                           class="form-control"
                           value="{{ old('task_code', $task->task_code) }}"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Title *</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title', $task->title) }}"
                           required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Assign Employee</label>
                    <select name="employee_id" class="form-select">
                        <option value="">Select</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}"
                                {{ old('employee_id', $task->employee_id) == $emp->id ? 'selected' : '' }}>
                                {{ $emp->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Source Type</label>
                    <select name="source_type" class="form-select">
                        <option value="">Select</option>
                        <option value="office_task" {{ old('source_type', $task->source_type) == 'office_task' ? 'selected' : '' }}>Office Task</option>
                        <option value="incoming_letter" {{ old('source_type', $task->source_type) == 'incoming_letter' ? 'selected' : '' }}>Incoming Letter</option>
                        <option value="directive" {{ old('source_type', $task->source_type) == 'directive' ? 'selected' : '' }}>Directive</option>
                        <option value="memo" {{ old('source_type', $task->source_type) == 'memo' ? 'selected' : '' }}>Memo</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Reference No</label>
                    <input type="text"
                           name="source_reference"
                           class="form-control"
                           value="{{ old('source_reference', $task->source_reference) }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Priority *</label>
                    <select name="priority" class="form-select" required>
                        <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ old('priority', $task->priority) == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="new" {{ old('status', $task->status) == 'new' ? 'selected' : '' }}>New</option>
                        <option value="assigned" {{ old('status', $task->status) == 'assigned' ? 'selected' : '' }}>Assigned</option>
                        <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="overdue" {{ old('status', $task->status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        <option value="cancelled" {{ old('status', $task->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="date"
                           name="deadline"
                           class="form-control"
                           value="{{ old('deadline', optional($task->deadline)->format('Y-m-d')) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3">{{ old('description', $task->description) }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Remarks</label>
                    <textarea name="remarks"
                              class="form-control"
                              rows="3">{{ old('remarks', $task->remarks) }}</textarea>
                </div>

            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    Update Task
                </button>
            </div>
        </form>
    </div>

</div>
@endsection