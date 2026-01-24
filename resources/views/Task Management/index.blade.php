@extends('new')
@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
        position: inherit;
    }
    .tablel{
        width: 100%;
         font-size:15px;
      color: #1169ec;
      height: inherit;
      width:100%;
        margin-bottom: 0px; 
        font-style: bold;     
    }
    .tablel th, .tablel td {
        padding: 0px;
        text-align: center;
    }
    .tablel th {
        background-color: #1674d1ff;
        color: white;
    }
</style>    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- ================= HEADER ================= -->
<div>
<div class="d-flex justify-content-between align-items-center mb-0 p-0 bg-light border-bottom shadow-sm">
    <div>
        <h4 class="mb-0">Task Management</h4>
        <small class="text-muted">Assigned, Managed, Controlled & Followed-up Tasks</small>
    </div>

    <div class="d-flex gap-1">
        <a href="{{ route('Task Management.index') }}" class="btn btn-outline-primary">
            Refresh
        </a>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createTaskModal">
            + New Task
        </button>
    </div>
</div>

<!-- ================= SYSTEM STATUS BAR ================= -->

<!-- ================= SUMMARY CARDS ================= -->
<div class="row g-1 mb-0 PB-0">
    <div class="col-md-3">
        <div class="card bg-warning text-white shadow-sm">
            <div class="card-body">
                <h3>{{ \App\Models\Task::where('status','Assigned')->count() }}</h3>
                <div>Assigned</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body">
                <h3>{{ \App\Models\Task::where('status','In Progress')->count() }}</h3>
                <div>In Progress</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body">
                <h3>{{ \App\Models\Task::where('status','Completed')->count() }}</h3>
                <div>Completed</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-danger text-white shadow-sm">
            <div class="card-body">
                <h3>{{ \App\Models\Task::where('status','Cancelled')->count() }}</h3>
                <div>Cancelled</div>
            </div>
        </div>
    </div>
</div>

<!-- ================= FILTER PANEL ================= -->
<div class="card mb-0 mt-0 pt-0 shadow-sm">
    <div class="card-body"> 
        <form method="GET" action="{{ route('Task Management.index') }}" class="row g-2 align-items-end">

            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="Assigned">Assigned</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-select">
                    <option value="">All Priority</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control">
            </div>

            <div class="col-md-3 d-flex gap-1">
                <button class="btn btn-primary w-100 font-weight-normal size:sm">
                    Apply Filters
                </button>
                <a href="{{ route('Task Management.index') }}" class="btn btn-outline-secondary w-100">
                    Reset
                </a>
            </div>

        </form>
    </div>
</div>

<!-- ================= TASK TABLE ================= -->
<div class="mt-3 mb-3 items center justify-center fixed">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <Medium>All Tasks</Medium>
            <span class="badge bg-secondary">Total: {{ $tasks->total() }}</span>
            </div>

    <div class="card-body p-0">
        <style>
        /* Compact table rows for Task Management table */
        .tablel th, .tablel td {
            padding: 0px 1px; /* Reduced padding for compactness */
        }
        </style>
        <div class="container mt-1 mb-1 p-0 content-center content-middle-fixed">
      <table class="tablel">
          <thead style="font-size: 0.8rem; text-transform: uppercase; background-color:#1674d1ff; color: white;">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Assigned By</th>
                <th>Assigned To</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Actions</th>

                </tr>
            </thead>
            <tbody>
            @forelse($tasks as $task)
                <tr>
                  <td>{{ $loop->iteration + ($tasks->currentPage()-1) * $tasks->perPage(10) }}</td>
                   <td>{{ $task->title }}</td>
                   <td>{{ $task->assignedBy->name ?? 'N/A' }}</td>
                    <td>{{ $task->assignedTo->name ?? 'N/A' }}</td>
                     <td>{{ $task->priority }}</td>
                      <td>{{ $task->status }}</td>
                       <td>{{ $task->due_date}}</td>
                       <td style="text-align: center;">
                    <a href="{{ route('Task Management.show', $task->id) }}" class="btn btn-sm btn-info" title="View">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('Task Management.edit', $task->id) }}" class="btn btn-sm btn-warning" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="{{ route('Task Management.destroy', $task->id) }}" class="btn btn-sm btn-danger" title="Delete" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $task->id }}').submit();">
                        <i class="bi bi-trash"></i>
                    </a>

                    <form id="delete-form-{{ $task->id }}" action="{{ route('Task Management.destroy', $task->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        No tasks found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
 
    
    <div class="paginationDiv mt-3 mb-3 d-flex justify-content-center">
        {{ $tasks->links('pagination::bootstrap-5')}}

    </div>

</div>

<!-- ================= CREATE TASK MODAL ================= -->
<div class="modal fade" id="createTaskModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="{{ route('Task Management.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Create New Task</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Title</label>
                            <input name="title" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Assign To</label>
                            <select name="assigned_to" class="form-select" required>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Assign By</label>
                            <select name="assigned_by" class="form-select" required>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Priority</label>
                            <select name="priority" class="form-select">
                                <option>Low</option>
                                <option selected>Medium</option>
                                <option>High</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Due Date</label>
                            <input type="date" name="due_date" class="form-control">
                        </div>

                        <div class="col-12">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success">Create Task</button>
                </div>

            </form>

        </div>
    </div>
</div>

</div>


<style>
.table-hover tbody tr:hover {
    background-color: #e9f5ff;
}

/* Adjust the size of icons in the Actions column */
.table .bi {
    font-size: 1rem; /* Adjust the size as needed */
}
</style>
@endsection
