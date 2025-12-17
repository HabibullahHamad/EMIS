@extends('new')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">    
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/tabs.css') }}">
<link rel="stylesheet" href="{{ asset('css/user-management.css') }}">


  
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,.08);
            padding: 20px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .card-header h2 {
            color: #c0a407ff;
        }

        .btn {
            padding: 8px 14px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary { background: #2563eb; color: #fff; }
        .btn-warning { background: #f59e0b; color: #fff; }
        .btn-danger  { background: #dc2626; color: #fff; }

        .search-box {
            margin-bottom: 15px;
        }

        .search-box input {
            padding: 8px;
            width: 250px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #0941c4ff;
            color: #fff;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:hover {
            background: #f1f5f9;
        }

        .actions i {
            cursor: pointer;
            margin-right: 8px;
        }

        .pagination {
            margin-top: 15px;
            display: flex;
            gap: 6px;
        }

        .pagination span {
            padding: 6px 10px;
            background: #e5e7eb;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff;
            width: 400px;
            border-radius: 10px;
            padding: 20px;
        }

        .modal-content h3 {
            margin-bottom: 10px;
        }

        .modal-content input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
        }
    </style>
</head>
<body>

<div class="section-header">

    <button class="tab-btn active" onclick="openTab('list')">Users List</button>
    <button class="tab-btn" onclick="openTab('create')">Create User</button>
    <button class="tab-btn" onclick="openTab('activity')">User Activity</button>
    
</div>
<div class="card">

    <!-- Header -->
    <div class="card-header">
        <h2><i class="fa-solid fa-users"></i> User Management</h2>
        <button class="btn btn-primary" onclick="openAddModal()">
            <i class="fa-solid fa-plus"></i> Add User
        </button>
    </div>

    <!-- Search -->
    <div class="search-box">
        <input type="text" placeholder="Search user...">
    </div>

    <!-- Table -->
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users ?? [] as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name ?? 'Demo User' }}</td>
                <td>{{ $user->email ?? 'user@mail.com' }}</td>
                <td>{{ $user->role ?? 'Admin' }}</td>
                <td>{{ $user->status ?? 'Active' }}</td>
                <td class="actions">
                    <i class="fa-solid fa-pen text-warning" onclick="openEditModal()"></i>
                    <i class="fa-solid fa-trash text-danger" onclick="deleteUser()"></i>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <span>1</span>
        <span>2</span>
        <span>3</span>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal" id="addModal">
    <div class="modal-content">
        <h3>Add User</h3>
        <input type="text" placeholder="Full Name">
        <input type="email" placeholder="Email">
        <input type="password" placeholder="Password">
        <select>
        <option>Super Admin</option>    
        <option>Admin</option>
            <option>Moderator</option>
            <option>Editor</option>

            <option>User</option>
            <option>Viewer</option>
            
        </select>
        <button class="btn btn-primary" onclick="closeModals()">Save</button>
        <button class="btn btn-secondary" onclick="closeModals()">Close</button>
    </div>
    

</div>

<!-- Edit User Modal -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <h3>Edit User</h3>
        <input type="text" value="Demo User">
        <input type="email" value="user@mail.com">
        <select>
            <option selected>Admin</option>
            <option>User</option>
        </select>
        <button class="btn btn-warning" onclick="closeModals()">Update</button>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addModal').style.display = 'flex';
    }

    function openEditModal() {
        document.getElementById('editModal').style.display = 'flex';
    }

    function closeModals() {
        document.querySelectorAll('.modal').forEach(m => m.style.display = 'none');
    }

    function deleteUser() {
        Swal.fire({
            title: 'Delete User?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Yes, delete'
        });
    }
</script>

</body>
</html>
    @endsection