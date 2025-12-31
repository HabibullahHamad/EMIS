@extends('new')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h4><i class="bi bi-list-check"></i> Task Management</h4>
        <button class="btn btn-primary">+ Add Task</button>
    </div>
    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>Pending Tasks</h6>
                    <h3>5</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>In Progress</h6>
                    <h3>3</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Completed</h6>
                    <h3>12</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h6>Overdue</h6>
                    <h3>1</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Task Table --}}
    <div class="card">
        <div class="card-header">All Tasks</div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>System Backup</td>
                        <td>Admin</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                        <td>2025-01-10</td>
                        <td>
                            <button class="btn btn-sm btn-info">View</button>
                            <button class="btn btn-sm btn-success">Complete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
