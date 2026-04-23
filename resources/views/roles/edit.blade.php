@extends('new')

@section('page_title', __('emis.edit') . ' ' . __('emis.roles'))

@section('content')
<style>
    .role-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        background: #fff;
    }

    .role-card .card-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 700;
        font-size: 15px;
    }

    .permission-group {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 18px;
        background: #fff;
    }

    .permission-group-header {
        background: #f8fafc;
        padding: 12px 16px;
        font-weight: 700;
        color: #1e293b;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .permission-group-body {
        padding: 16px;
    }

    .form-check {
        margin-bottom: 10px;
    }

    .form-check-label {
        font-size: 13px;
        color: #334155;
    }

    .permission-toolbar {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .permission-toolbar .btn,
    .module-actions .btn {
        border-radius: 10px;
        font-size: 12px;
    }

    .module-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
</style>

<div class="container-fluid">
    <div class="card role-card">
        <div class="card-header">
            {{ __('emis.edit') }} {{ __('emis.roles') }}
        </div>

        <div class="card-body">
            <form action="{{ route('roles.update', $role) }}" method="POST" id="roleForm">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('emis.name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">{{ __('emis.display_name') ?? 'Display Name' }}</label>
                        <input type="text" name="display_name" class="form-control" value="{{ old('display_name', $role->display_name) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">{{ __('emis.description') }}</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description', $role->description) }}">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <h5 class="mb-0">{{ __('emis.permissions') ?? 'Permissions' }}</h5>

                    <div class="permission-toolbar">
                        <button type="button" class="btn btn-success btn-sm" id="checkAllPermissions">Check All</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" id="uncheckAllPermissions">Uncheck All</button>
                    </div>
                </div>

                @foreach($permissions as $module => $modulePermissions)
                    <div class="permission-group">
                        <div class="permission-group-header">
                            <span>{{ $module }}</span>

                            <div class="module-actions">
                                <button type="button" class="btn btn-sm btn-primary check-module" data-module="{{ \Illuminate\Support\Str::slug($module) }}">
                                    Check Module
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary uncheck-module" data-module="{{ \Illuminate\Support\Str::slug($module) }}">
                                    Uncheck Module
                                </button>
                            </div>
                        </div>

                        <div class="permission-group-body">
                            <div class="row">
                                @foreach($modulePermissions as $permission)
                                    <div class="col-md-3 col-sm-6">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input permission-checkbox module-{{ \Illuminate\Support\Str::slug($module) }}"
                                                type="checkbox"
                                                name="permissions[]"
                                                value="{{ $permission->id }}"
                                                id="perm_{{ $permission->id }}"
                                                {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                {{ $permission->display_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">{{ __('emis.save') }}</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">{{ __('emis.back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('checkAllPermissions')?.addEventListener('click', function () {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
    });

    document.getElementById('uncheckAllPermissions')?.addEventListener('click', function () {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
    });

    document.querySelectorAll('.check-module').forEach(button => {
        button.addEventListener('click', function () {
            const module = this.dataset.module;
            document.querySelectorAll('.module-' + module).forEach(cb => cb.checked = true);
        });
    });

    document.querySelectorAll('.uncheck-module').forEach(button => {
        button.addEventListener('click', function () {
            const module = this.dataset.module;
            document.querySelectorAll('.module-' + module).forEach(cb => cb.checked = false);
        });
    });
</script>
@endsection