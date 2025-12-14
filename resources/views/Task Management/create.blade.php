@extends('welcome')

@section('content')
<div class="container">
<form method="POST" action="{{ route('tasks.store') }}">
@csrf

<div class="mb-3">
    <label>Task Title</label>
    <input type="text" name="title" class="form-control">
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Assign To</label>
    <select name="assigned_to" class="form-control">
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Priority</label>
    <select name="priority" class="form-control">
        <option>Low</option>
        <option>Medium</option>
        <option>High</option>
    </select>
</div>

<div class="mb-3">
    <label>Due Date</label>
    <input type="date" name="due_date" class="form-control">
</div>

<button class="btn btn-success">Save Task</button>
</form>
</div>
@endsection
