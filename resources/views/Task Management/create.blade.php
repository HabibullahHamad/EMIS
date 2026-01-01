@extends('new')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="container">
<form method="POST" action="{{ route('Task Management.store') }}">
@csrf
<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control" id="title" name="title" required>
</div>
<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
</div>
<div class="mb-3">
    <label for="assigned_by" class="form-label">Assigned By</label>
    <select class="form-select" id="assigned_by" name="assigned_by" required>
        <option value="">Select User</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
</div>


<div class="mb-3">
    <label for="assigned_to" class="form-label">Assigned To</label>
    <select class="form-select" id="assigned_to" name="assigned_to" required>
        <option value="">Select User</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="priority" class="form-label">Priority</label>
    <select class="form-select" id="priority" name="priority" required>
        <option value="">Select Priority</option>
        <option value="Low">Low</option>
        <option value="Medium">Medium</option>
        <option value="High">High</option>
    </select>
</div>
<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select class="form-select" id="status" name="status" required>
        <option value="">Select Status</option>
        <option value="Pending">Pending</option>
        <option value="In Progress">In Progress</option>
        <option value="Completed">Completed</option>
    </select>
</div>
<div class="mb-3">
    <label for="due_date" class="form-label">Due Date</label>
    <input type="date" class="form-control" id="due_date" name="due_date" required>
</div>
<button type="submit" class="btn btn-primary">Create Task</button>
</form>
</div>
@endsection