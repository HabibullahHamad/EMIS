@extends('new')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-body">

            <div class="d-flex align-items-center mb-4">
                <img src="{{ $employee->photo_url }}" width="100" height="100"
                     style="border-radius:50%; object-fit:cover; margin-right:20px;">

                <div>
                    <h3 class="mb-1">{{ $employee->full_name }}</h3>
                    <p class="mb-0"><strong>Code:</strong> {{ $employee->employee_code }}</p>
                    <p class="mb-0"><strong>Status:</strong> {{ ucfirst($employee->status) }}</p>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <p><strong>First Name:</strong> {{ $employee->first_name }}</p>
                </div>

                <div class="col-md-6">
                    <p><strong>Last Name:</strong> {{ $employee->last_name }}</p>
                </div>

                <div class="col-md-6">
                    <p><strong>Email:</strong> {{ $employee->email ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <p><strong>Phone:</strong> {{ $employee->phone ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <p><strong>Created At:</strong> {{ $employee->created_at }}</p>
                </div>

                <div class="col-md-6">
                    <p><strong>Updated At:</strong> {{ $employee->updated_at }}</p>
                </div>

            </div>

            <hr>

            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>

        </div>
    </div>

</div>
@endsection