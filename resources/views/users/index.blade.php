@extends('new')

@section('page_title', __('emis.users'))

@section('content')

<div class="container-fluid">

    <x-emis.alert />

    <x-emis.card :title="__('emis.users')" icon="fa fa-users">
        <x-slot name="actions">
            @if(Route::has('users.create'))
                <x-emis.button :href="route('users.create')" type="primary">
                    <i class="fa fa-plus"></i> {{ __('emis.add') }}
                </x-emis.button>
            @endif
        </x-slot>

        <form method="GET" action="{{ route('users.index') }}" class="emis-filter">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control emis-form-control"
                   placeholder="{{ __('emis.search') }}">

            <select name="role_id" class="form-select emis-form-control">
                <option value="">{{ __('emis.all_roles') }}</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->display_name ?? $role->name }}
                    </option>
                @endforeach
            </select>

            <select name="blocked_status" class="form-select emis-form-control">
                <option value="">{{ __('emis.all_status') }}</option>
                <option value="active" {{ request('blocked_status') == 'active' ? 'selected' : '' }}>
                    {{ __('emis.active') }}
                </option>
                <option value="blocked" {{ request('blocked_status') == 'blocked' ? 'selected' : '' }}>
                    {{ __('emis.blocked') }}
                </option>
            </select>

            <button class="btn emis-btn emis-btn-primary">
                <i class="fa fa-search"></i> {{ __('emis.search') }}
            </button>

            <a href="{{ route('users.index') }}" class="btn emis-btn emis-btn-light">
                {{ __('emis.reset') }}
            </a>
        </form>
    </x-emis.card>

    <x-emis.card>
        <x-emis.table>
            <x-slot name="head">
                <tr>
                    <th>#</th>
                    <th>{{ __('emis.name') }}</th>
                    <th>{{ __('emis.email') }}</th>
                    <th>{{ __('emis.role') }}</th>
                    <th>{{ __('emis.attempts') }}</th>
                    <th>{{ __('emis.status') }}</th>
                    <th>{{ __('emis.blocked_at') }}</th>
                    <th width="220">{{ __('emis.action') }}</th>
                </tr>
            </x-slot>

            @forelse($users as $user)
                <tr>
                    <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        <x-emis.badge type="info">
                            {{ optional($user->role)->display_name ?? optional($user->role)->name ?? '-' }}
                        </x-emis.badge>
                    </td>

                    <td>
                        <x-emis.badge type="secondary">
                            {{ $user->failed_login_attempts ?? 0 }}/5
                        </x-emis.badge>
                    </td>

                    <td>
                        @if((int) $user->is_blocked === 1)
                            <x-emis.badge type="danger">{{ __('emis.blocked') }}</x-emis.badge>
                        @else
                            <x-emis.badge type="success">{{ __('emis.active') }}</x-emis.badge>
                        @endif
                    </td>

                    <td>
                        {{ $user->blocked_at ? \Carbon\Carbon::parse($user->blocked_at)->format('Y-m-d H:i') : '-' }}
                    </td>

                    <td>

               <td class="actions-cell">
                
                        <div class="d-flex gap-1 justify-content-center">
                            @if(Route::has('users.show'))
                                <x-emis.button :href="route('users.show', $user->id)" type="info" class="btn-sm">
                                    <i class="fa fa-eye"></i>
                                </x-emis.button>
                            @endif

                            @if(Route::has('users.edit'))
                                <x-emis.button :href="route('users.edit', $user->id)" type="primary" class="btn-sm">
                                    <i class="fa fa-edit"></i>
                                </x-emis.button>
                            @endif

                            @if((int) $user->is_blocked === 1)
                                @if(Route::has('users.unblock'))
                                    <form action="{{ route('users.unblock', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn emis-btn emis-btn-success btn-sm" type="submit">
                                            <i class="fa fa-unlock"></i> {{ __('emis.allow') }}
                                        </button>
                                    </form>
                                @endif
                            @else
                                @if(Route::has('users.block') && auth()->id() !== $user->id)
                                    <form action="{{ route('users.block', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn emis-btn emis-btn-warning btn-sm" type="submit">
                                            <i class="fa fa-lock"></i> {{ __('emis.block') }}
                                        </button>
                                    </form>
                                @endif
                            @endif

                            @if(Route::has('users.destroy') && auth()->id() !== $user->id)
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                      onsubmit="return confirm('{{ __('emis.are_you_sure') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn emis-btn emis-btn-danger btn-sm" type="submit">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            @endif

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-muted">
                        {{ __('emis.no_users_found') }}
                    </td>
                </tr>
            @endforelse
        </x-emis.table>

        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </x-emis.card>

</div>

@endsection