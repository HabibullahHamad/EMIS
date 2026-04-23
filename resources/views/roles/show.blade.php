@extends('new')

@section('page_title', __('emis.roles'))

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header fw-bold">
            {{ __('emis.view') }} {{ __('emis.roles') }}
        </div>

        <div class="card-body">
            <div class="mb-3">
                <strong>{{ __('emis.name') }}:</strong> {{ $role->name }}
            </div>

            <div class="mb-3">
                <strong>{{ __('emis.display_name') ?? 'Display Name' }}:</strong> {{ $role->display_name }}
            </div>

            <div class="mb-3">
                <strong>{{ __('emis.description') }}:</strong> {{ $role->description ?? '-' }}
            </div>

            <div class="mb-3">
                <strong>{{ __('emis.permissions') ?? 'Permissions' }}:</strong>
                <div class="mt-2">
                    @forelse($role->permissions as $permission)
                        <span class="badge bg-primary me-1 mb-1">{{ $permission->display_name }}</span>
                    @empty
                        <span class="text-muted">No permissions assigned.</span>
                    @endforelse
                </div>
            </div>

            <a href="{{ route('roles.index') }}" class="btn btn-secondary">{{ __('emis.back') }}</a>
            @if(auth()->user()->canAccess('roles.edit'))
                <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning">{{ __('emis.edit') }}</a>
            @endif
        </div>
    </div>
</div>
@endsection