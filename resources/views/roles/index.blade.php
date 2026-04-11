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
        font-size: 12px;
        vertical-align: middle;
        text-align: center;
    }
</style>

<div class="container-fluid">

    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <form method="GET" action="{{ route('roles.index') }}" class="d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search role...">
            <button class="btn btn-sm btn-outline-secondary">Search</button>
            <a href="{{ route('roles.index') }}" class="btn btn-sm btn-outline-dark">Reset</a>
        </form>

        <h5 class="mb-0">Roles Management</h5>

        <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">
            + Add Role
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
                        <th>Display Name</th>
                        <th>Description</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->display_name }}</td>
                            <td>{{ $role->description ?? '-' }}</td>
                            <td>
                                <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-info">کتل</a>
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning">تغییر</a>

                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this role?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $roles->links() }}
        </div>
    </div>
</div>
@endsection