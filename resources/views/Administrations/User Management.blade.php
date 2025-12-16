@extends('new')
@section('title', 'User Management')
@section('content')


<link rel="stylesheet" href="{{ asset('css/user-management.css') }}">
<h1>User Management</h1>
<p class="page-desc">Manage EMIS users, roles, and activities</p>
{{-- Tabs --}}
<div class="tabs">
    <button class="tab-btn active" onclick="openTab('list')">Users List</button>
    <button class="tab-btn" onclick="openTab('create')">Create User</button>
    <button class="tab-btn" onclick="openTab('activity')">User Activity</button>
</div>

{{-- USERS LIST --}}
<div id="list" class="tab-content active">
    <h2>Users List</h2>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Admin User</td>
                <td>admin@emis.gov</td>
                <td>Administrator</td>
                <td>Active</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- CREATE USER --}}
<div id="create" class="tab-content">
    <h2>Create New User</h2>

    <form>
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" placeholder="Enter full name">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" placeholder="Enter email">
        </div>

        <div class="form-group">
            <label>Role</label>
            <select>
                <option>Administrator</option>
                <option>Manager</option>
                <option>Operator</option>
            </select>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password">
        </div>

        <button class="btn">Create User</button>
    </form>
</div>

{{-- USER ACTIVITY --}}
<div id="activity" class="tab-content">
    <h2>User Activity</h2>

    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Action</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Admin User</td>
                <td>Logged In</td>
                <td>2025-01-01 10:00</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- JS --}}
<script>
    function openTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

        document.getElementById(tabId).classList.add('active');
        event.target.classList.add('active');
    }
</script>

@endsection
