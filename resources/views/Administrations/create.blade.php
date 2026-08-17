@extends('new')
@section('content')

tarnslate all lables 


<div class="container">
    <h3>Add New User</h3>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="mb-3"><label>{{ __('emis.name') }} </label><input name="name" class="form-control" required></div>
        <div class="mb-3"><label>{{ __('emis.email') }}</label><input name="email" class="form-control" required></div>
        <div class="mb-3"><label>Username</label><input name="username" class="form-control" required></div>
        <div class="mb-3"><label>{{ __('emis.role') }}</label>
            <select name="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="user">{{ __('emis.user') }}</option>
            </select>
            
        </div>
        <div class="mb-3"><label>{{ __('emis.password') }}</label><input name="password" type="password" class="form-control" required></div>
        <button class="btn btn-success">{{ __('emis.save') }}</button>
    </form>
</div>
@endsection
