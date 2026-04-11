@extends('new')

@section('content')

<div class="container-fluid">
    <h5 class="mb-3">Role Details</h5>

    <div class="card p-3">
        <div class="mb-3">
            <strong>ID:</strong> {{ $role->id }}
        </div>

        <div class="mb-3">
            <strong>Name:</strong> {{ $role->name }}
        </div>

        <div class="mb-3">
            <strong>Display Name:</strong> {{ $role->display_name }}
        </div>

        <div class="mb-3">
            <strong>Description:</strong> {{ $role->description ?? '-' }}
        </div>

        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection