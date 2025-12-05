@extends('Welcome')

@section('content')
<div class="container">
    <h3>User Management</h3>

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">+ Add New User</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ ucfirst($u->role) }}</td>
                <td>{{ $u->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('users.edit', $u->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete user?')">Delete</button>
                    </form>
                    <form action="{{ route('users.reset-password', $u->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning">Reset Password</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
<!-- tast bar -->