@extends('new')

@section('content')
<div class="container">
    <h2 class="mb-3">Edit Employee</h2>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            {{-- Employee Code --}}
            <div class="col-md-6 mb-3">
                <label>Employee Code</label>
                <input type="text" name="employee_code" class="form-control"
                       value="{{ old('employee_code', $employee->employee_code) }}" required>
            </div>

            {{-- First Name --}}
            <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control"
                       value="{{ old('first_name', $employee->first_name) }}" required>
            </div>

            {{-- Last Name --}}
            <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control"
                       value="{{ old('last_name', $employee->last_name) }}" required>
            </div>

            {{-- Email --}}
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $employee->email) }}">
            </div>

            {{-- Phone --}}
            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control"
                       value="{{ old('phone', $employee->phone) }}">
            </div>

            {{-- Status --}}
            <div class="col-md-6 mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $employee->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Photo --}}
            <div class="col-md-6 mb-3">
                <label>Photo</label>
                <input type="file" name="photo" class="form-control">
            </div>

            {{-- Current Photo --}}
            <div class="col-md-6 mb-3">
                <label>Current Photo</label><br>
                <img src="{{ $employee->photo_url }}" width="80" height="80" style="border-radius:50%;">
            </div>

        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection