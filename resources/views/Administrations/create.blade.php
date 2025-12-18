@extends('new')

@section('content')
<div class="container">
    <h3>Add New User</h3>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="mb-3"><label>Name</label><input name="name" class="form-control" required></div>
        <div class="mb-3"><label>Email</label><input name="email" class="form-control" required></div>
        <div class="mb-3"><label>Username</label><input name="username" class="form-control" required></div>
        <div class="mb-3"><label>Role</label>
            <select name="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>
        <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
