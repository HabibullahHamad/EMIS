@extends('new')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="container my-5">
    <h1 class="mb-4 text-primary fw-bold">Create New Task</h1>

    <form method="POST" action="{{ route('Task Management.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card shadow-sm p-4">
            <h5 class="mb-4 text-secondary fw-semibold">Task Information</h5>

            <div class="row g-3">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter task title" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-medium">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter task description" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label fw-medium">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Development">Development</option>
                            <option value="Design">Design</option>
                            <option value="Testing">Testing</option>
                            <option value="Research">Research</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label fw-medium">Tags</label>
                        <input type="text" class="form-control" id="tags" name="tags" placeholder="Comma separated tags">
                    </div>

                    <div class="mb-3">
                        <label for="attachments" class="form-label fw-medium">Attachments</label>
                        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="assigned_by" class="form-label fw-medium">Assigned By</label>
                        <select class="form-select" id="assigned_by" name="assigned_by" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="assigned_to" class="form-label fw-medium">Assigned To</label>
                        <select class="form-select" id="assigned_to" name="assigned_to" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label fw-medium">Priority</label>
                        <select class="form-select" id="priority" name="priority" required>
                            <option value="">Select Priority</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-medium">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="due_date" class="form-label fw-medium">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="estimated_hours" class="form-label fw-medium">Estimated Hours</label>
                        <input type="number" class="form-control" id="estimated_hours" name="estimated_hours" placeholder="Enter estimated hours">
                    </div>

                    <div class="mb-3">
                        <label for="progress" class="form-label fw-medium">Progress (%)</label>
                        <input type="number" class="form-control" id="progress" name="progress" min="0" max="100" placeholder="0%">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary btn-lg px-5 fw-semibold">Create Task</button>
            </div>
        </div>
    </form>
</div>

<style>
    .card {
        border-radius: 12px;
        transition: 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }
    h1 {
        font-weight: 700;
    }
    h5 {
        font-weight: 600;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px;
        font-size: 0.95rem;
    }
    .btn-lg {
        font-size: 1.05rem;
    }
</style>
@endsection
