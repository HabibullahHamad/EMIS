@extends('new')

@section('content')

<style>
    .form-card {
        background: #fff;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 1px 8px rgba(0,0,0,0.08);
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
    }

    .permission-card {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        margin-bottom: 16px;
        overflow: hidden;
        background: #fff;
    }

    .permission-card .card-header {
        background: #f8f9fa;
        font-weight: 700;
        font-size: 14px;
        padding: 10px 14px;
        border-bottom: 1px solid #e9ecef;
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

    .module-badge {
        background: #0d6efd;
        color: #fff;
        padding: 2px 8px;
        border-radius: 999px;
        font-size: 11px;
    }

    .module-tools {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        align-items: center;
    }

    .section-title {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #334155;
    }

    .permission-search {
        max-width: 260px;
    }

    .sticky-bar {
        position: sticky;
        top: 8px;
        z-index: 20;
        background: #fff;
        padding-bottom: 8px;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0">{{ __('emis.role_management') }} - {{ __('emis.edit') }}</h5>
        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary">
            {{ __('emis.back') }}
        </a>
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

            @php
                $selectedPermissions = old('permissions', $role->permissions->pluck('id')->toArray());
            @endphp

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('emis.name') }}</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $role->name) }}"
                        required
                    >
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('emis.title') }}</label>
                    <input
                        type="text"
                        name="display_name"
                        class="form-control"
                        value="{{ old('display_name', $role->display_name) }}"
                        required
                    >
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('emis.description') }}</label>
                    <input
                        type="text"
                        name="description"
                        class="form-control"
                        value="{{ old('description', $role->description) }}"
                    >
                </div>
            </div>

            <hr>

            <div class="sticky-bar">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                    <div class="section-title mb-0">{{ __('emis.permissions') }}</div>

                    <div class="d-flex gap-2 flex-wrap">
                        <input type="text"
                               id="permissionSearch"
                               class="form-control form-control-sm permission-search"
                               placeholder="{{ __('emis.search') }}">

                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleAllPermissions(true)">
                            Check All
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-dark" onclick="toggleAllPermissions(false)">
                            Uncheck All
                        </button>
                    </div>
                </div>
            </div>

            @foreach($permissions as $module => $modulePermissions)
                @php
                    $moduleSlug = \Illuminate\Support\Str::slug($module, '_');
                @endphp

                <div class="permission-card permission-module" data-module="{{ strtolower($module) }}">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span>{{ $module }}</span>
                            <span class="module-badge">{{ count($modulePermissions) }}</span>
                        </div>

                        <div class="module-tools">
                            <button type="button"
                                    class="btn btn-sm btn-outline-primary"
                                    onclick="toggleModulePermissions('{{ $moduleSlug }}', true)">
                                Check Module
                            </button>
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary"
                                    onclick="toggleModulePermissions('{{ $moduleSlug }}', false)">
                                Uncheck Module
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($modulePermissions as $permission)
                                <div class="col-md-3 col-sm-6 mb-2 permission-item"
                                     data-name="{{ strtolower($permission->display_name . ' ' . $permission->name . ' ' . $module) }}">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input permission-checkbox module-{{ $moduleSlug }}"
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->id }}"
                                            id="perm_{{ $permission->id }}"
                                            {{ in_array($permission->id, $selectedPermissions) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->display_name }}
                                            <br>
                                            <small class="text-muted">{{ $permission->name }}</small>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    {{ __('emis.save') }} {{ __('emis.roles') }}
                </button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                    {{ __('emis.cancel') }}
                </a>
            </div>
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

    document.getElementById('permissionSearch')?.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();

        document.querySelectorAll('.permission-item').forEach(function (item) {
            const text = item.dataset.name || '';
            item.style.display = text.includes(keyword) ? '' : 'none';
        });

        document.querySelectorAll('.permission-module').forEach(function (moduleCard) {
            if (keyword === '') {
                moduleCard.style.display = '';
            } else {
                let hasVisible = false;
                moduleCard.querySelectorAll('.permission-item').forEach(function (item) {
                    if (item.style.display !== 'none') {
                        hasVisible = true;
                    }
                });
                moduleCard.style.display = hasVisible ? '' : 'none';
            }
        });
    });
</script>

@endsection