@extends('new')

@section('page_title', __('emis.roles'))

@section('content')
<style>
    .roles-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        background: #fff;
    }

    .roles-card .card-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 700;
        font-size: 15px;
    }

    .role-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 12px;
        background: #eef2ff;
        color: #3730a3;
        margin: 2px;
    }

    .permission-badge {
        display: inline-block;
        padding: 4px 9px;
        border-radius: 999px;
        font-size: 11px;
        background: #f1f5f9;
        color: #334155;
        margin: 2px;
    }

    .permission-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 28px;
        border-radius: 999px;
        background: #0b3563;
        color: white;
        font-size: 12px;
        font-weight: 700;
    }

    .table td, .table th {
        vertical-align: middle;
    }

    .actions-wrap {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .search-bar {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
</style>

<div class="container-fluid">
    <div class="card roles-card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span>{{ __('emis.roles') }}</span>

            <div class="search-bar">
                <form method="GET" action="{{ route('roles.index') }}" class="d-flex gap-2 flex-wrap">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control form-control-sm"
                        placeholder="{{ __('emis.search') }}"
                        style="min-width: 220px;"
                    >
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fa fa-search"></i>
                    </button>
                    <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary">
                        {{ __('emis.cancel') }}
                    </a>
                </form>

                @if(auth()->user()->canAccess('roles.create'))
                    <a href="{{ route('roles.create') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i> {{ __('emis.create') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>{{ __('emis.name') }}</th>
                            <th>{{ __('emis.display_name') ?? 'Display Name' }}</th>
                            <th>{{ __('emis.description') }}</th>
                            <th width="110">{{ __('emis.permissions') ?? 'Permissions' }}</th>
                            <th>{{ __('emis.permissions') ?? 'Permissions' }} {{ __('emis.summary') ?? 'Summary' }}</th>
                            <th width="210">{{ __('emis.actions') ?? 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration + (($roles->currentPage() - 1) * $roles->perPage()) }}</td>

                                <td>
                                    <span class="role-badge">{{ $role->name }}</span>
                                </td>

                                <td>{{ $role->display_name }}</td>

                                <td>{{ $role->description ?? '-' }}</td>

                                <td class="text-center">
                                    <span class="permission-count">
                                        {{ $role->permissions->count() }}
                                    </span>
                                </td>

                                <td>
                                    @forelse($role->permissions->take(6) as $permission)
                                        <span class="permission-badge">{{ $permission->display_name }}</span>
                                    @empty
                                        <span class="text-muted">-</span>
                                    @endforelse

                                    @if($role->permissions->count() > 6)
                                        <span class="permission-badge">
                                            +{{ $role->permissions->count() - 6 }} more
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="actions-wrap">
                                        @if(Route::has('roles.show') && auth()->user()->canAccess('roles.view'))
                                            <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-info">
                                                {{ __('emis.view') }}
                                            </a>
                                        @endif

                                        @if(auth()->user()->canAccess('roles.edit'))
                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning">
                                                {{ __('emis.edit') }}
                                            </a>
                                        @endif

                                        @if(auth()->user()->canAccess('roles.delete'))
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Delete this role?')">
                                                    {{ __('emis.delete') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    {{ __('emis.no_data_found') ?? 'No data found' }}
                                </td>
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
</div>
@endsection