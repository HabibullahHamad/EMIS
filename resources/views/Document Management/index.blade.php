@extends('new')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <h4><i class="bi bi-folder"></i> Document Management</h4>
        <button class="btn btn-success">Upload Document</button>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Total Documents</h6>
                    <h3>120</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Approved</h6>
                    <h3>95</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>Pending</h6>
                    <h3>20</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Document List --}}
    <div class="card">
        <div class="card-header">Documents</div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Document Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Uploaded</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Project Proposal.pdf</td>
                    <td>Reports</td>
                    <td><span class="badge bg-success">Approved</span></td>
                    <td>2025-01-01</td>
                    <td>
                        <button class="btn btn-sm btn-primary">View</button>
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection
