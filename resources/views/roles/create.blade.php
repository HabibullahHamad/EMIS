@extends('new')

@section('content')

<div class="container-fluid">
    <h5 class="mb-3">Create Role</h5>

    @if($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li style="font-size:13px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-3">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Role Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Display Name</label>
                <input type="text" name="display_name" class="form-control" value="{{ old('display_name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <button class="btn btn-primary">Save</button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection