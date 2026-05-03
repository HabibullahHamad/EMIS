@extends('new')

@section('page_title', 'Users')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <strong>
                <i class="fa fa-users"></i> Users Management
            </strong>

            @if(Route::has('users.create'))
                <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> Add User
                </a>
            @endif
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success py-2">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger py-2">{{ session('error') }}</div>
            @endif

            <form method="GET" action="{{ route('users.index') }}" class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control form-control-sm"
                           placeholder="Search name or email">
                </div>

                <div class="col-md-3">
                    <select name="role_id" class="form-select form-select-sm">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name ?? $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="blocked_status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="active" {{ request('blocked_status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="blocked" {{ request('blocked_status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-1">
                    <button class="btn btn-sm btn-primary w-100">
                        <i class="fa fa-search"></i>
                    </button>

                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary w-100">
                        Reset
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>

                            <th>{{ __('emis.No.') }}</th>
                            <th>{{ __('emis.Name') }}</th>
                            <th>{{ __('emis.Email') }}</th>
                            <th>{{ __('emis.Role') }}</th>
                            <th>{{ __('emis.Attempts') }}</th>
                            <th>{{ __('emis.Status') }}</th>
                            <th>{{ __('emis.Blocked At') }}</th>
                            <th width="220">{{ __('emis.Actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>

                                <td>{{ $user->name }}</td>

                                <td>{{ $user->email }}</td>

                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ optional($user->role)->display_name ?? optional($user->role)->name ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $user->failed_login_attempts ?? 0 }}/5
                                    </span>
                                </td>

                                <td>
                                    @if((int) $user->is_blocked === 1)
                                        <span class="badge bg-danger">Blocked</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $user->blocked_at ? \Carbon\Carbon::parse($user->blocked_at)->format('Y-m-d H:i') : '-' }}
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-1 flex-wrap">

                                        @if(Route::has('users.show'))
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif

                                        @if(Route::has('users.edit'))
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif

                                        @if((int) $user->is_blocked === 1)
                                            @if(Route::has('users.unblock'))
                                                <form action="{{ route('users.unblock', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-sm btn-success" type="submit">
                                                        <i class="fa fa-unlock"></i> Allow
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            @if(Route::has('users.block') && auth()->id() !== $user->id)
                                                <form action="{{ route('users.block', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-sm btn-warning" type="submit">
                                                        <i class="fa fa-lock"></i> Block
                                                    </button>
                                                </form>
                                            @endif
                                        @endif

                                        @if(Route::has('users.destroy') && auth()->id() !== $user->id)
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" type="submit">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted">No users found.</td>
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
</div>

@endsection