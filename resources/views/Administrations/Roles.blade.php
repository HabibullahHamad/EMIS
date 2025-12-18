@extends('new')

@section('title', 'Roles')

@section('content')


<style>

    .page-desc {
    color: #777;
    margin-bottom: 20px;
}

.tabs {
    margin-bottom: 20px;
}

.tab-btn {
    padding: 10px 20px;
    border: none;
    background: #bdc3c7;
    cursor: pointer;
    margin-right: 5px;
}

.tab-btn.active {
    background: #2c3e50;
    color: #fff;
}

.tab-content {
    display: none;
    background: #fff;
    padding: 20px;
    border-radius: 5px;
}

.tab-content.active {
    display: block;
}

.form-group {
    margin-bottom: 15px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 8px;
}

.btn {
    padding: 10px 15px;
    background: #2c3e50;
    color: #fff;
    border: none;
    cursor: pointer;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    border: 1px solid #ddd;
    padding: 10px;
}

    </style>
<h1>Roles</h1>
<p class="page-desc">Define and manage system roles</p>

{{-- Tabs --}}
<div class="tabs">
    <button class="tab-btn active" onclick="openTab('list')">Roles List</button>
    <button class="tab-btn" onclick="openTab('create')">Create Role</button>
    <button class="tab-btn" onclick="openTab('edit')">Edit Role</button>
</div>

{{-- ROLES LIST --}}
<div id="list" class="tab-content active">
    <h2>Roles List</h2>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Role Name</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Administrator</td>
                <td>Full access to the system</td>
                <td>Active</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Manager</td>
                <td>Manage departments and reports</td>
                <td>Active</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Operator</td>
                <td>Limited operational access</td>
                <td>Inactive</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- CREATE ROLE --}}
<div id="create" style="width:80%; padding:60px;" margin:50px; alighn:center; class="tab-content">
    <h2>Create New Role</h2>
    <form>
        <div class="form-group">
            <label>Role Name</label>
            <input type="text" placeholder="e.g. Auditor">
        </div>

        <div class="form-group">
            <label>Description</label>
            <input type="text" placeholder="Describe role responsibility">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select>
                <option>Active</option>
                <option>Inactive</option>
                <option>Delayed</option>
            </select>
        </div>

        <button class="btn">Create Role</button>
    </form>
</div>

{{-- EDIT ROLE --}}
<div id="edit" class="tab-content">
    <h2>Edit Role</h2>

    <form>
        <div class="form-group">
            <label>Select Role</label>
            <select>
                <option>Administrator</option>
                <option>Manager</option>
                <option>Operator</option>
            </select>
        </div>

        <div class="form-group">
            <label>Role Name</label>
            <input type="text" value="Manager">
        </div>

        <div class="form-group">
            <label>Description</label>
            <input type="text" value="Manage departments and reports">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select>
                <option selected>Active</option>
                <option>Inactive</option>
            </select>
        </div>

        <button class="btn">Update Role</button>
    </form>
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
