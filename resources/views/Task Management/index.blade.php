@extends('new')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 text-primary fw-bold">Latest Tasks</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Assighned By</th>
                        <th>Assigned To</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Progress</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
<td>{{ $loop->iteration + ($tasks->currentPage() - 1) * $tasks->perPage() }}</td>                             <td>{{ $task->title }}</td>
                                 <td>{{ $task->assignedBy->name ?? 'N/A' }}</td>
                    <td>{{ $task->assignedTo->name ?? 'N/A' }}</td>
                            <td>{{ $task->priority }}</td>
                            <td>{{ $task->status }}</td>
                            <td>{{ $task->due_date}}</td>
                            <td>{{ $task->progress }}%</td>
                            <td>
                                <a href="{{ route('Task Management.show', $task->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('Task Management.edit', $task->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No tasks found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination: Previous / Next -->
            <div class="d-flex justify-content-between mt-3">
                @if ($tasks->onFirstPage())
                    <button class="btn btn-secondary" disabled>Previous</button>
                @else
                    <a href="{{ $tasks->previousPageUrl() }}" class="btn btn-secondary">Previous</a>
                @endif

                @if ($tasks->hasMorePages())
                    <a href="{{ $tasks->nextPageUrl() }}" class="btn btn-secondary">Next</a>
                @else
                    <button class="btn btn-secondary" disabled>Next</button>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.table-hover tbody tr:hover {
    background-color: #e9f5ff;

}
</style>
@endsection
