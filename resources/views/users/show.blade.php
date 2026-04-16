@extends('new')

@section('content')

<div class="container-fluid">
    <div class="card p-4 shadow-sm">

        <h5 class="mb-3">{{ __('emis.view') }} {{ __('emis.user_management') }}</h5>

        <table class="table table-bordered">
            <tr>
                <th>{{ __('emis.name') }}</th>
                <td>{{ $user->name }}</td>
            </tr>

            <tr>
                <th>{{ __('emis.email') }}</th>
                <td>{{ $user->email }}</td>
            </tr>

            <tr>
                <th>{{ __('emis.roles') }}</th>
                <td>{{ $user->role->display_name ?? '-' }}</td>
            </tr>
        </table>

        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            {{ __('emis.back') }}
        </a>

    </div>
    
</div>

@endsection