@extends('welcome')
@section('content')

<div class="container">
    <a href="{{ route('Task Management.create') }}" class="btn btn-primary mb-3">
        + Delegate Task
    </a>

    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Title</th>
                <th>Assigned To</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
          @foreach($tasks as $task)
    <tr>
        <td>{{ $task->title }}</td>
        <td>{{ $task->assignedBy->name ?? 'N/A' }}</td>
        <td>{{ $task->assignedTo->name ?? 'N/A' }}</td>
        <td>{{ $task->priority }}</td>
        <td>{{ $task->due_date }}</td>
    </tr>
@endforeach
            
                    <a href="#" class="btn btn-sm btn-warning">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
