@extends('new')

@section('content')
<div class="container">
    <h3 class="mb-3">Create Employee</h3>

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

    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

            {{-- Employee Code --}}
            <div class="col-md-6 mb-3">
                <label>Employee Code</label>
                <input type="text" name="employee_code" class="form-control"
                       value="{{ old('employee_code') }}" required>
            </div>

            {{-- First Name --}}
            <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control"
                       value="{{ old('first_name') }}" required>
            </div>

            {{-- Last Name --}}
            <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control"
                       value="{{ old('last_name') }}" required>
            </div>

            {{-- Email --}}
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}">
            </div>

            {{-- Phone --}}
            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control"
                       value="{{ old('phone') }}">
            </div>

            {{-- Status --}}
            <div class="col-md-6 mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="other">other</option>
                </select>
            </div>

            {{-- Photo --}}
            <div class="col-md-6 mb-3">
                <label>Photo</label>
                <input type="file" name="photo" class="form-control">
            </div>

        </div>

        {{-- Buttons --}}
        <div class="mt-3">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
        </div>

    </form>
</div>
@endsection