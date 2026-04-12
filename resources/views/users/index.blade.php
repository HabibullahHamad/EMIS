@extends('new')

@section('content')

<style>
    .page-header {
        background: #fff;
        border-radius: 8px;
        padding: 8px 12px;
        min-height: 45px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.05);
        margin-bottom: 12px;
    }

    .table-card {
        background: #fff;
        border-radius: 8px;
        padding: 8px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.08);
    }

    .table thead th,
    .table tbody td {
        font-size: 13px;
        vertical-align: middle;
        text-align: center;
    }

    .badge-role {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        background: #e9f2ff;
        color: #0d6efd;
    }
</style>

<div class="container-fluid">

    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <form method="GET" action="{{ route('users.index') }}" class="d-flex gap-2 flex-wrap">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="form-control form-control-sm"
                placeholder="Search user..."
            >

            <select name="role_id" class="form-select form-select-sm">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->display_name }}
                    </option>
                @endforeach
            </select>

            <button class="btn btn-sm btn-outline-secondary">Filter</button>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-dark">Reset</a>
        </form>

        <h5 class="mb-0">Users Management</h5>

        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
            + Add User
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif

    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if(optional($user->role)->display_name)
                                    <span class="badge-role">{{ $user->role->display_name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">کتل</a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">تغییر</a>

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this user?')"
                                    >
                                        له منځه وړل
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection