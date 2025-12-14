@extends('Welcome')
@section('content')
<div class="container">
    <h2 class="mb-4">
        

    
    </h2>
    <div class="card">
        <div class="card-header">
            Assign a New Task
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="task_title" class="form-label">Task Title</label>
                    <input type="text" class="form-control" id="task_title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="task_description" class="form-label">Description</label>
                    <textarea class="form-control" id="task_description" name="description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="assignee" class="form-label">Assign To</label>
                    <select class="form-select" id="assignee" name="assignee_id" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" class="form-control" id="due_date" name="due_date">
                </div>
                <button type="submit" class="btn btn-primary">Delegate Task</button>
            </form>
        </div>
    </div>

    <hr class="my-5">

    <h4>Delegated Tasks</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Title</th>
                <th>Assignee</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->assignee->name ?? 'N/A' }}</td>
                    <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : '-' }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No tasks delegated yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection