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

    {{-- Header --}}
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Create Task</h5>

        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-secondary">
            Back
        </a>
    </div>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li style="font-size:13px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div class="form-card">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="row">

                {{-- Task Code --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Task Code *</label>
                    <input type="text"
                           name="task_code"
                           class="form-control"
                           value="{{ old('task_code') }}"
                           placeholder="T-001"
                           required>
                </div>

                {{-- Title --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Title *</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title') }}"
                           required>
                </div>

                {{-- Employee --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Assign Employee</label>
                    <select name="employee_id" class="form-select">
                        <option value="">Select</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">
                                {{ $emp->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Source Type --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Source Type</label>
                    <select name="source_type" class="form-select">
                        <option value="">Select</option>
                        <option value="office_task">Office Task</option>
                        <option value="incoming_letter">Incoming Letter</option>
                        <option value="directive">Directive</option>
                        <option value="memo">Memo</option>
                    </select>
                </div>

                {{-- Reference --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Reference No</label>
                    <input type="text"
                           name="source_reference"
                           class="form-control"
                           value="{{ old('source_reference') }}">
                </div>

                {{-- Priority --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Priority *</label>
                    <select name="priority" class="form-select" required>
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>

                {{-- Status --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="new">New</option>
                        <option value="assigned">Assigned</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="overdue">Overdue</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                {{-- Deadline --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="date"
                           name="deadline"
                           class="form-control"
                           value="{{ old('deadline') }}">
                </div>

                {{-- Description --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3">{{ old('description') }}</textarea>
                </div>

                {{-- Remarks --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Remarks</label>
                    <textarea name="remarks"
                              class="form-control"
                              rows="3">{{ old('remarks') }}</textarea>
                </div>

            </div>

            {{-- Submit --}}
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    Save Task
                </button>
            </div>

        </form>
    </div>

</div>
@endsection