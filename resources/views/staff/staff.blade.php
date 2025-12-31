@extends('new')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <h4><i class="bi bi-people"></i> Staff Management</h4>
        <button class="btn btn-primary">Add Employee</button>
    </div>

    {{-- Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Total Staff</h6>
                    <h3>15</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Active</h6>
                    <h3>13</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Staff Table --}}
    <div class="card">
        <div class="card-header">Employees</div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>EMP001</td>
                    <td>Admin User</td>
                    <td>Manager</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>
                        <button class="btn btn-sm btn-info">View</button>
                        <button class="btn btn-sm btn-warning">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection
