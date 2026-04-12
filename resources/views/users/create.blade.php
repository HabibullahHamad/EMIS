@extends('new')

@section('content')

<style>
    .form-card {
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
    }

    .form-control,
    .form-select {
        font-size: 13px;
        height: 36px;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Create User</h5>
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">Back</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li style="font-size:13px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Role</label>
                    <select name="role_id" class="form-select">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3"></div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        required
                    >
                </div>
            </div>

            <button class="btn btn-primary">Save User</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection