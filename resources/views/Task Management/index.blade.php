@extends('new')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="container">
    <a href="{{ route('Task Management.create') }}" class="btn btn-primary mb-3">
        + Delegate Task
    </a>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                 <th>ID</th>
                    <th>Title</th>
                    <th>Assigned By</th>
                    <th>Assigned To</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{$task->id}} </td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->assignedBy->name ?? 'N/A' }}</td>
                    <td>{{ $task->assignedTo->name ?? 'N/A' }}</td>
                    <td>{{ $task->priority }}</td>
                    <td>{{ $task->status ?? 'N/A' }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Actions">
                            <a href="{{ route('Task Management.show', $task->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('Task Management.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form id="deleteForm{{ $task->id }}" action="{{ route('Task Management.destroy', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" onclick="confirmDelete('deleteForm{{ $task->id }}')" class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(formId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>

@endsection