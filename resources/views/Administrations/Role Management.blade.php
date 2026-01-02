@extends('new')

@section('title', 'Role Management')

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
    background: #077ef5ff;
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
<h1 style="color: #057ef7ff;">Role Management</h1>
<p class="page-desc">Manage system roles, assignments, and permissions</p>

{{-- Tabs --}}
<div class="tabs">
    <button class="tab-btn active" onclick="openTab('roles')">Roles List</button>
    <button class="tab-btn" onclick="openTab('assign')">Assign Roles</button>
    <button class="tab-btn" onclick="openTab('permissions')">Permissions</button>
</div>
{{-- ROLES LIST --}}
<div id="roles" class="tab-content active">
    <h2>Roles List</h2>
 <a href="{{ route('settings.tabs.createroles') }}" class="btn btn-outline-primary w-6 mb-1">
                    <i class="fa-solid fa-user-check"></i> Add New Role
                </a> 
    <table class="table">
        <thead style="background-color: #064e96ff; color: white;">
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
                <td>Full system access</td>
                <td>Active</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Manager</td>
                <td>Manage departments & users</td>
                <td>Active</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Operator</td>
                <td>Limited data entry access</td>
                <td>Active</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- ASSIGN ROLES --}}
<div id="assign" class="tab-content">
    <h2>Assign Roles to Users</h2>

    <form>
        <div class="form-group">
            <label>Select User</label>
            <select>
                <option>Admin User</option>
                <option>Finance Manager</option>
                <option>Data Operator</option>
            </select>
        </div>

        <div class="form-group">
            <label>Select Role</label>
            <select>
                <option>Administrator</option>
                <option>Manager</option>
                <option>Operator</option>
            </select>
        </div>

        <button class="btn">Assign Role</button>
    </form>
</div>

{{-- PERMISSIONS --}}
<div id="permissions" class="tab-content">
    <h2>Role Permissions</h2>

    <table class="table">
        <thead style="background-color: #064e96ff; color: white;">
            <tr>
                <th>Permission</th>
                <th>Administrator</th>
                <th>Manager</th>
                <th>Operator</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>View Dashboard</td>
                <td><input type="checkbox" checked></td>
                <td><input type="checkbox" checked></td>
                <td><input type="checkbox" checked></td>
            </tr>
            <tr>
                <td>Manage Users</td>
                <td><input type="checkbox" checked></td>
                <td><input type="checkbox" checked></td>
                <td><input type="checkbox"></td>
            </tr>
            <tr>
                <td>System Settings</td>
                <td><input type="checkbox" checked></td>
                <td><input type="checkbox"></td>
                <td><input type="checkbox"></td>
            </tr>
             <tr>
                <td>System Settings</td>
                <td><input type="checkbox" checked></td>
                <td><input type="checkbox"></td>
                <td><input type="checkbox"></td>
            </tr>
             <tr>
                <td>System Settings</td>
                <td><input type="checkbox" checked></td>
                <td><input type="checkbox"></td>
                <td><input type="checkbox"></td>
            </tr>
        </tbody>
    </table>

    <button class="btn">Save Permissions</button>
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
