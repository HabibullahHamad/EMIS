@extends('new')
@section('content')
<h4>Account Settings</h4>
<hr>

<form method="POST" action="#">
    @csrf

    <div class="row mb-3">
        <div class="col-md-6">
            <label>Full Name</label>
            <input type="text" class="form-control" value="#">
        </div>

        <div class="col-md-6">
            <label>Username</label>
            <input type="text" class="form-control" value="#" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label>Role</label>
            <input type="text" class="form-control" value="Administrator" readonly>
        </div>

        <div class="col-md-6">
            <label>Change Password</label>
            <input type="password" class="form-control">
        </div>
    </div>

    <button class="btn btn-success float-end">✔ Save Changes</button>
</form>
@endsection
