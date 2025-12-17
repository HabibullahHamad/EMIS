<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <meta charset="UTF-8">
    <title>EMIS | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom scrollbar: smaller and smarter -->
    <style>
        /* ========== TOP NAVBAR ========== */
.top-navbar{
    position:fixed;
    top:0;
    left: 200px;px;
    right:0;
    height:40px;
    background:#ffffff;
    border-bottom:1px solid #e5e7eb;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 2px;
    z-index:999;
    transition:left 0.3s ease;
    background: #b7bbbbff;
}

/* Adjust when sidebar collapsed */
.sidebar.collapsed ~ .top-navbar{
    left:80px;
}

/* LEFT */





/* RIGHT */
.nav-right{
    display:flex;
    align-items:center;
    gap:18px;
}

/* SEARCH */
.nav-search{
    display:flex;
    align-items:center;
    gap:8px;
    background:#f1f5f9;
    padding:6px 10px;
    border-radius:8px;
}
.nav-search input{
    border:none;
    background:none;
    outline:none;
    font-size:13px;
}

/* NAV ITEMS */
.nav-item{
    position:relative;
    cursor:pointer;
    color:#334155;
}
.nav-item i{
    font-size:18px;
}

/* BADGE */
.badge{
    position:absolute;
    top:-6px;
    right:-6px;
    background:#dc2626;
    color:#fff;
    font-size:10px;
    padding:2px 6px;
    border-radius:50%;
}

/* DROPDOWN */
.dropdown-menu{
    position:absolute;
    top:120%;
    right:0;
    background:#fff;
    min-width:200px;
    border-radius:8px;
    box-shadow:0 10px 25px rgba(0,0,0,.1);
    display:none;
    flex-direction:column;
    padding:8px 0;
}
.dropdown-menu a,
.dropdown-menu p{
    padding:10px 15px;
    font-size:13px;
    color:#334155;
    text-decoration:none;
}
.dropdown-menu a:hover{
    background: #f1f5f9;
}
.dropdown-title{
    font-weight:bold;
    color:#475569;
}
.dropdown-menu hr{
    border:none;
    border-top:1px solid #e5e7eb;
    margin:6px 0;
}
.dropdown-menu .danger{
    color:#dc2626;
}

/* SHOW ON HOVER */
.dropdown:hover .dropdown-menu{
    display:flex;
}

/* USER */
.user{
    display:flex;
    align-items:center;
    gap:8px;
}
.user img{
    width:32px;
    height:32px;
    border-radius:50%;
}

/* CONTENT OFFSET */
.content{
    margin-top:64px;
}

/* end navbar */
        .menu::-webkit-scrollbar {
            width: 4px;
        }
        .menu::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 8px;
        }
        .menu::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
        .menu::-webkit-scrollbar-track {
            background: transparent;
        }
        /* For Firefox */
        .menu {
            scrollbar-width: thin;
            scrollbar-color: #334155 transparent;
        }
    </style>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Custom scrollbar */
        .menu::-webkit-scrollbar {
            width: 6px;
        }

        .menu::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }

        .menu::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }

        .menu::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: #f4f6f9;
        }
        /* Make menu scrollable so long sub-menus won't extend past the viewport */
        .sidebar {
            overflow: hidden; /* keep header/footer visible */
        }

        .menu {
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            max-height: calc(100vh - 130px); /* adjust if header/footer heights differ */
        }

        /* keep footer pinned to bottom */
        .sidebar-footer {
            margin-top: auto;
        }
        /* Sidebar */
        .sidebar {
            width: 200px;
            height:100%;
            background: #081e51ff;
            color: #fff;
            position: fixed;
            transition: 0.3s ease;
            display: flex;
            flex-direction: column;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        /* Header */
        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 20px;
            font-weight: bold;
        }

        .logo-text {
            transition: 0.3s;
        }

        .sidebar.collapsed .logo-text {
            display: none;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
        }

        /* Menu */
        .menu {
            list-style: none;
            padding: 10px;
            flex-grow: 3;
        }

        .menu li {
            margin-bottom: 1px;

        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 3px;
            color: #cbd5e1;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
            position: relative;
            spacing :1px;
           

        }

        .menu a:hover {
            background: #c76c05ff;
            color: #fff;
             border-radius: 8px;
            border-left: 4px solid #51f604ff;
            padding-top: 7px;
        }
        .menu span {
            white-space: nowrap;
        }

        .sidebar.collapsed .menu span,
        .sidebar.collapsed .arrow {
            display: none;
        }

        /* Tooltip on collapse */
        .sidebar.collapsed .menu a::after {
            content: attr(data-title);
            position: absolute;
            left: 90px;
            background: #1e293b;
            color: #fff;
            padding: 5px 5px;
            border-radius: 6px;
            font-size: 13px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: 0.2s;
        }
        .sidebar.collapsed .menu a:hover::after {
            opacity: 1;
        }
        /* Sub menu */
        .has-sub .sub-menu {
            list-style: none;
            padding-left: 22px;
            display: none;
            flex-direction: column;
        }
        .has-sub.active .sub-menu {
            display: block;
            padding-left: 5px;
            background: #02121f86;
            border-radius: 4px;
            margin-top: 1px;
            margin-bottom: 1px;
        }

        .sub-menu a {
            font-size: 12px;
            font-weight: bold;
            padding: 8px 12px;
            color: #cbd5e1;
        }

        /* Footer */
        .sidebar-footer {
            border-top: 1px solid #343435ff;
            margin-top: 2px;
            height: 50px;
            display: flex;
            align-items: center;
            border-top: 1px solid #1e293b;
            background: #131314ff;   
            padding-bottom: 1px;
            transition: 0.3s;   
        }

        .user-info {
            height: 40px;
            display: flex;
            align-items: center;
            padding-bottom: 4px;
            padding-left: 1px;
        }
        .user-info img {
            border-radius: 50%;
            width: 40px;
            height: 40px;

        }
        .sidebar.collapsed .user-info div {
            display: none;
        }
        /* Page Content (optional) */
        .content {
            margin-left: 260px;
            padding: 20px;
            transition: 0.3s;
        }
        .sidebar.collapsed ~ .content {
            margin-left: 80px;
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
<!-- Flexible Logo on Top -->
<div class="sidebar-header" style="justify-content: center;">
    <div class="logo" style="width:100%;justify-content:center;">
        <img src="/images/45.png" alt="Logo" style="width:36px;height:36px;">
        <span class="logo-text">EMIS</span>
    </div>
    <button class="toggle-btn" onclick="toggleSidebar()">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
</div>
<style>
    .sidebar.collapsed .logo-text {
        display: none;
    }
    .sidebar .logo img {
        transition: width 0.3s, height 0.3s;
    }
    .sidebar.collapsed .logo img {
        width: 36px;
        height: 36px;
    }
</style>
<script>
    // Ensure only one sidebar-header is present
    document.querySelectorAll('.sidebar-header')[1]?.remove();
</script>
    <!-- Logo & Toggle -->
<!-- Tooltip container for sub-menu tooltips -->
<div id="sidebar-tooltip" style="position:fixed; z-index:9999; pointer-events:none; background:#1e293b; color:#fff; padding:6px 14px; border-radius:6px; font-size:13px; white-space:nowrap; opacity:0; transition:opacity 0.15s;"></div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const tooltip = document.getElementById('sidebar-tooltip');

    function showTooltip(text, event) {
        tooltip.textContent = text;
        tooltip.style.opacity = '1';
        // Position tooltip near mouse, but not off-screen
        let x = event.clientX + 16;
        let y = event.clientY - 8;
        if (x + tooltip.offsetWidth > window.innerWidth) {
            x = window.innerWidth - tooltip.offsetWidth - 10;
        }
        if (y + tooltip.offsetHeight > window.innerHeight) {
            y = window.innerHeight - tooltip.offsetHeight - 10;
        }
        tooltip.style.left = x + 'px';
        tooltip.style.top = y + 'px';
    }

    function hideTooltip() {
        tooltip.style.opacity = '0';
    }

    // For main menu items
    sidebar.querySelectorAll('.menu > li > a').forEach(function (a) {
        a.addEventListener('mouseenter', function (e) {
            if (sidebar.classList.contains('collapsed')) {
                showTooltip(a.getAttribute('data-title') || a.textContent.trim(), e);
            }
        });
        a.addEventListener('mousemove', function (e) {
            if (sidebar.classList.contains('collapsed')) {
                showTooltip(a.getAttribute('data-title') || a.textContent.trim(), e);
            }
        });
        a.addEventListener('mouseleave', hideTooltip);
    });

    // For sub-menu items
    sidebar.querySelectorAll('.sub-menu a').forEach(function (a) {
        a.addEventListener('mouseenter', function (e) {
            if (sidebar.classList.contains('collapsed')) {
                showTooltip(a.textContent.trim(), e);
            }
        });
        a.addEventListener('mousemove', function (e) {
            if (sidebar.classList.contains('collapsed')) {
                showTooltip(a.textContent.trim(), e);
            }
        });
        a.addEventListener('mouseleave', hideTooltip);
    });

    // Hide tooltip if sidebar expands
    const observer = new MutationObserver(function () {
        if (!sidebar.classList.contains('collapsed')) hideTooltip();
    });
    observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
});
</script>

    <!-- Menu -->

    <ul class="menu">
        <li>
            <a href="{{ route('dashboard') }}" data-title="Dashboard">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="has-sub">
            <a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="Management">
                <i class="fa-solid fa-folder"></i>
                <span>Management</span>
                <i class="fa-solid fa-chevron-down arrow"></i>
            </a>
            <ul class="sub-menu">
                <li><a href="{{route('inbox.index')}}"><i class="fa-solid fa-users"></i>Users</a></li>

                <li><a href="{{ route('Administration.Roles') }}"><i class="fa-solid fa-user-tag"></i>Roles </a></li>
                <li><a href="{{ route('Administrations.login') }}"><i class="fa-solid fa-sign-in-alt"></i>Login</a></li>
                <li><a href="{{ route('Administrations.Role Management')}}"><i class="fa-solid fa-user-check"></i>Role Management</a></li>
                <li><a href="{{ route('Administrations.User Management')}}"><i class="fa-solid fa-user-friends"></i>User Management</a></li>
                <li><a href="#"><i class="fa-solid fa-user-shield"></i>Permissions</a></li>
            </ul>
        </li>
        <li>
            <a href="#" data-title="Analytics">
                <i class="fa-solid fa-chart-line"></i>
                <span>Analytics</span>
            </a>
        <li>
            <a href="#" data-title="Reports">
                <i class="fa-solid fa-chart-bar"></i>
                <span>Reports</span>
            </a>
        </li>
        <li>
            <a href="#" data-title="Settings">
                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>
            </a>
        </li>
           <li>
            <a href="#" data-title="Settings">
                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>
            </a>
        </li> 
    </ul>
    <!-- User -->
    <div class="sidebar-footer">

        <div class="user-info">
            <img src="/images/logo.png" alt="user">
            <div>
                <strong>{{ Auth::user()->name ?? 'User' }}</strong>
                
                <small>Logged In</small>
                <i class="fa-solid fa-sign-in-alt"></i>
            </div>
        </div>
    </div>
</div>
<!-- Navbar -->
 <!-- TOP NAVBAR -->
<div class="top-navbar" id="topNavbar">
    <!-- LEFT -->
    <div class="nav-left">
        </button>
        <div class="page-title">  
        </div>
    </div>
    <!-- RIGHT -->
    <div class="nav-right">
        <!-- SEARCH -->
        <div class="nav-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search EMIS...">
        </div>
        <!-- LANGUAGE -->
        <div class="nav-item dropdown">
            <i class="fa-solid fa-globe"></i>
            <div class="dropdown-menu">
                <a href="#">English</a>
                <a href="#">پښتو</a>
                <a href="#">دری</a>
            </div>
        </div>
        <!-- NOTIFICATIONS -->
        <div class="nav-item dropdown">
            <i class="fa-solid fa-bell"></i>
            <span class="badge">4</span>
            <div class="dropdown-menu">
                <p class="dropdown-title">Notifications</p>
                <a href="#">📊 New report generated</a>
                <a href="#">👤 New user added</a>
                <a href="#">⚠ Budget alert</a>
            </div>
        </div>
        <!-- USER -->
        <div class="nav-item dropdown user">
            <img src="/images/logo.png">
            <span>{{ Auth::user()->name ?? 'User' }}</span>
            <div class="dropdown-menu">
                <a href="#"><i class="fa-solid fa-user"></i> Profile</a>
                <a href="#"><i class="fa-solid fa-gear"></i> Settings</a>
                <hr>
                <a href="#" class="danger">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </div>

    </div>
</div>
<!-- end navbar -->
 <main class="content">
        @yield('content')
    </main>
<!-- Content -->
<style>
    /* Custom style for the sidebar toggle ">" icon */
    .toggle-btn {
        background: none;
        border: none;
        color: #fff;
        font-size: 22px;
        cursor: pointer;
        padding: 0 8px;
        transition: transform 0.2s;
    }
    .sidebar.collapsed .toggle-btn i {
        transform: rotate(180deg);
    }
</style>
<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("collapsed");
        // Optionally, you can toggle the icon direction here if needed
    }
</script>
<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("collapsed");
    }
    function toggleSubMenu(el) {
        el.parentElement.classList.toggle("active");
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // ✅ SUCCESS MESSAGE
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
        @endif

        // ❌ ERROR MESSAGE
        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('error') }}",
        });
        @endif

        // ⚠️ WARNING MESSAGE
        @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: "{{ session('warning') }}",
        });
        @endif

        // ❗ VALIDATION ERRORS
        @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: `{!! implode('<br>', $errors->all()) !!}`,
        });
        @endif

    });
</script>
<script>
function confirmDelete(formId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
</body>
</html>
