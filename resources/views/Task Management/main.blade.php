@extends('new')

@section('content')
<div class="container-fluid">

    <!-- 🔹 PAGE TITLE -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">📋 Task Management – Director Panel</h4>
        <button class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> New Task
        </button>
    </div>

    <!-- 🔹 SUMMARY CARDS -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">New Tasks</h6>
                    <h3 class="fw-bold text-primary">12</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Assigned</h6>
                    <h3 class="fw-bold text-info">30</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Pending Approval</h6>
                    <h3 class="fw-bold text-warning">8</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Rejected</h6>
                    <h3 class="fw-bold text-danger">4</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔹 TASK LIST -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold">
            All Staff Tasks
        </div>

        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Task Title</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th class="text-center">Actions</th>
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
                        <td class="text-center">
                            <button class="btn btn-sm btn-success">
                                <i class="bi bi-check-circle"></i>
                            </button>

                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-x-circle"></i>
                            </button>

                            <button class="btn btn-sm btn-secondary">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
     @endforeach
                    {{-- More rows from DB --}}
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
