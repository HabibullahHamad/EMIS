@extends('new')

@section('content')

<div class="container-fluid">
    <h5 class="mb-3">User Details</h5>

    <div class="card p-3">
        <div class="mb-3">
            <strong>ID:</strong> {{ $user->id }}
        </div>

        <div class="mb-3">
            <strong>Name:</strong> {{ $user->name }}
        </div>

        <div class="mb-3">
            <strong>Email:</strong> {{ $user->email }}
        </div>

        <div class="mb-3">
            <strong>Role:</strong> {{ $user->role->display_name ?? '-' }}
        </div>

        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection