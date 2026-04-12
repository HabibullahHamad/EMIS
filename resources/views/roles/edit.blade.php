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

    .permission-card {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        margin-bottom: 14px;
        overflow: hidden;
    }

    .permission-card .card-header {
        background: #f8f9fa;
        font-weight: 700;
        font-size: 14px;
        padding: 10px 14px;
    }

    .permission-card .card-body {
        padding: 14px;
    }

    .form-check-label {
        font-size: 13px;
    }

    .permission-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Edit Role</h5>
        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary">Back</a>
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
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Role Name</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $role->name) }}"
                        required
                    >
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Display Name</label>
                    <input
                        type="text"
                        name="display_name"
                        class="form-control"
                        value="{{ old('display_name', $role->display_name) }}"
                        required
                    >
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Description</label>
                    <input
                        type="text"
                        name="description"
                        class="form-control"
                        value="{{ old('description', $role->description) }}"
                    >
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <label class="form-label fw-bold">Permissions</label>

                <div class="permission-actions">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleAllPermissions(true)">
                        Check All
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-dark" onclick="toggleAllPermissions(false)">
                        Uncheck All
                    </button>
                </div>

                @php
                    $selectedPermissions = old('permissions', $role->permissions->pluck('id')->toArray());
                @endphp

                @foreach($permissions as $module => $modulePermissions)
                    <div class="permission-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>{{ $module }}</span>
                            <div class="d-flex gap-2">
                                <button type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        onclick="toggleModulePermissions('{{ \Illuminate\Support\Str::slug($module, '_') }}', true)">
                                    Check Module
                                </button>
                                <button type="button"
                                        class="btn btn-sm btn-outline-secondary"
                                        onclick="toggleModulePermissions('{{ \Illuminate\Support\Str::slug($module, '_') }}', false)">
                                    Uncheck Module
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @foreach($modulePermissions as $permission)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input permission-checkbox module-{{ \Illuminate\Support\Str::slug($module, '_') }}"
                                                type="checkbox"
                                                name="permissions[]"
                                                value="{{ $permission->id }}"
                                                id="perm_{{ $permission->id }}"
                                                {{ in_array($permission->id, $selectedPermissions) ? 'checked' : '' }}
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
            </div>

            <button class="btn btn-primary">Update Role</button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<script>
    function toggleAllPermissions(state) {
        document.querySelectorAll('.permission-checkbox').forEach(function (checkbox) {
            checkbox.checked = state;
        });
    }

    function toggleModulePermissions(moduleClass, state) {
        document.querySelectorAll('.module-' + moduleClass).forEach(function (checkbox) {
            checkbox.checked = state;
        });
    }
</script>

@endsection