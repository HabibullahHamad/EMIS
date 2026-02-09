<!DOCTYPE html>
<html lang="ps" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EMIS | Dashboard</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <style>
        :root{ --sidebar-width:230px; --sidebar-collapsed-width:70px; }
        html,body{ direction:rtl !important; font-family: 'Noto Sans Arabic', sans-serif !important; }

        /* Sidebar */
        .sidebar{ width:var(--sidebar-width); position:fixed; top:0; right:0; bottom:0; left:auto; background:#081e51; color:#fff; z-index:1000; overflow:auto; }
        .sidebar.collapsed{ width:var(--sidebar-collapsed-width); }

        /* Top navbar */
        .top-navbar{ position:fixed; top:0; left:0; right:var(--sidebar-width); height:40px; background:#b7bbbbff; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; padding:0 12px; z-index:9999; transition:right .25s ease; }
        .sidebar.collapsed ~ .top-navbar{ right:var(--sidebar-collapsed-width); }

        main.content{ margin-top:48px; margin-right:var(--sidebar-width); margin-left:12px; transition:margin-right .25s ease; }
        .sidebar.collapsed ~ main.content{ margin-right:var(--sidebar-collapsed-width); }

        .nav-left{ display:flex; align-items:center; gap:12px; }
        .nav-right{ display:flex; align-items:center; gap:18px; }
        .nav-search{ display:flex; align-items:center; gap:8px; background:#f1f5f9; padding:6px 10px; border-radius:8px; }
        .nav-search input{ border:none; background:none; outline:none; font-size:13px; text-align:right; }

        .top-navbar .dropdown-menu{ left:auto; right:0; }

        .menu{ list-style:none; padding:8px; max-height:calc(100vh - 130px); overflow-y:auto; }
        .menu a{ display:flex; align-items:center; gap:14px; color:#fff; padding:8px 12px; text-decoration:none; border-radius:4px; transition:.2s; }
        .menu a:hover{ background:#c76c05; color:#fff; }

        /* Modal helper */
        .modal-dialog-bottom-right{ position:fixed; bottom:20px; right:20px; margin:0; max-width:500px; }
        .modal.fade .modal-dialog-bottom-right{ transform:translateY(100%); }
        .modal.show .modal-dialog-bottom-right{ transform:translateY(0); transition:transform .3s ease-out; }

        /* Misc */
        .toggle-btn{ background:none; border:none; color:#fff; font-size:22px; cursor:pointer; padding:0 8px; transition:transform .2s; }
        .sidebar.collapsed .toggle-btn i{ transform:rotate(180deg); }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <div position:start>
      <button class="toggle-btn" onclick="toggleSidebar()">
        <!-- <i class="fa-solid fa-chevron-left"></i> -->
        <i class="fa-sharp fa-solid fa-align-left" style="color: #e4b301;"></i>

    </button>
<!-- Flexible Logo on Top -->
<div class="sidebar-header" style="justify-content: center;">
    <div class="logo" style="width:100%;justify-content:center;">
        <img src="/images/45.png" alt="Logo" style="width:36px;height:36px;">
        <span class="logo-text">EMIS</span>
 </div>
  </div>
</div>
<style>
    .sidebar.collapsed .logo-text { display: none; }
    .sidebar .logo img { transition: width 0.3s, height 0.3s; }
    .sidebar.collapsed .logo img { width: 20px; height: 20px; }
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
        let x = event.clientX + 16;
        let y = event.clientY - 8;
        if (x + tooltip.offsetWidth > window.innerWidth) x = window.innerWidth - tooltip.offsetWidth - 10;
        if (y + tooltip.offsetHeight > window.innerHeight) y = window.innerHeight - tooltip.offsetHeight - 10;
        tooltip.style.left = x + 'px';
        tooltip.style.top = y + 'px';
    }

    function hideTooltip() { tooltip.style.opacity = '0'; }

    sidebar.querySelectorAll('.menu > li > a').forEach(function (a) {
        a.addEventListener('mouseenter', function (e) {
            if (sidebar.classList.contains('collapsed')) showTooltip(a.getAttribute('data-title') || a.textContent.trim(), e);
        });
        a.addEventListener('mousemove', function (e) {
            if (sidebar.classList.contains('collapsed')) showTooltip(a.getAttribute('data-title') || a.textContent.trim(), e);
        });
        a.addEventListener('mouseleave', hideTooltip);
    });

    sidebar.querySelectorAll('.sub-menu a').forEach(function (a) {
        a.addEventListener('mouseenter', function (e) {
            if (sidebar.classList.contains('collapsed')) showTooltip(a.textContent.trim(), e);
        });
        a.addEventListener('mousemove', function (e) {
            if (sidebar.classList.contains('collapsed')) showTooltip(a.textContent.trim(), e);
        });
        a.addEventListener('mouseleave', hideTooltip);
    });

    const observer = new MutationObserver(function () { if (!sidebar.classList.contains('collapsed')) hideTooltip(); });
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
            <a href="javascript:void(0)" onclick="toggleSubMenuSlide(this)" data-title="Correspondence">
                <i class="fa-solid fa-envelope"></i>
                <span>Correspondence</span>
                <i class="fa-solid fa-chevron-down arrow"></i>
            </a>
            <ul class="sub-menu">
                <li class="has-sub">
                    <a href="javascript:void(0)" onclick="toggleSubMenuSlide(this)" data-title="Inbox">
                        <i class="fa-solid fa-inbox"></i>
                        <span>Inbox</span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('CorrespondenceManagement.inbox.inbox') }}"><i class="fa-solid fa-list"></i> All Inbox</a></li>
                        <li><a href="{{ route('CorrespondenceManagement.inbox.create') }}"><i class="fa-solid fa-plus"></i> Create Incoming</a></li>
                        <li><a href="{{ route('CorrespondenceManagement.inbox.edit') }}"><i class="fa-solid fa-filter"></i> Search & Filter</a></li>
                    </ul>
                </li>

                <li class="has-sub">
                    <a href="javascript:void(0)" onclick="toggleSubMenuSlide(this)" data-title="Outbox">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Outbox</span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('correspondencemanagement.outbox.index') }}"><i class="fa-solid fa-list"></i> All Outbox</a></li>
                        <li><a href="{{ route('correspondencemanagement.outbox.create') }}"><i class="fa-solid fa-plus"></i> Create Outgoing</a></li>
                        <li><a href="{{ route('correspondencemanagement.outbox.reports') }}"><i class="fa-solid fa-file-alt"></i> Sent Reports</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li class="has-sub">
            <a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="Management">
                <i class="fa-solid fa-folder"></i>
                <span>Management</span>
                <i class="fa-solid fa-chevron-down arrow"></i>
            </a>
            <ul class="sub-menu">
                <li><a href="{{route('Administrations.create')}}"><i class="fa-solid fa-users"></i>Craete Users</a></li>

                <li><a href="{{ route('Administrations.Roles') }}"><i class="fa-solid fa-user-tag"></i>Roles </a></li>
                <li><a href="{{ route('Administrations.login') }}"><i class="fa-solid fa-sign-in-alt"></i>Login</a></li>
                <li><a href="{{ route('Administrations.Role Management')}}"><i class="fa-solid fa-user-check"></i>Role Management</a></li>
                <li><a href="{{ route('Administrations.User Management')}}"><i class="fa-solid fa-user-friends"></i>User Management</a></li>
                <li><a href="#"><i class="fa-solid fa-user-shield"></i>Permissions</a></li>
            </ul>
        </li>
       <!-- Task Manage,ent -->

<li class="has-sub">
            <a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="Management">
                <i class="fa-solid fa-tasks"></i>
                <span>Task Management</span>
                <i class="fa-solid fa-chevron-down arrow"></i>
            </a>
            <ul class="sub-menu">
                <li><a href="{{route('inbox.index')}}"><i class="fa-solid fa-users"></i>Users</a></li>

                <li><a href="{{ route('Administrations.login') }}"><i class="fa-solid fa-sign-in-alt"></i>Login</a></li>
                <li><a href="{{ route('Administrations.Role Management')}}"><i class="fa-solid fa-user-check"></i>Role Management</a></li>
                <li><a href="{{ route('Administrations.User Management')}}"><i class="fa-solid fa-user-friends"></i>User Management</a></li>
                <li><a href="#"><i class="fa-solid fa-user-shield"></i>Permissions</a></li>
            </ul>
        </li>

       <!-- end task ma -->
        <!-- start documentation -->

<li class="has-sub">
            <a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="Management">
                <i class="fa-solid fa-tasks"></i>
                <span>Documnets Management</span>
                <i class="fa-solid fa-chevron-down arrow"></i>
            </a>
            <ul class="sub-menu">
                <li><a href="{{route('inbox.index')}}"><i class="fa-solid fa-box-archive"></i>Inbox</a></li>

                <li><a href="#"><i class="fa-solid fa-file-import"></i>Coming</a></li>           
                <li><a href="{{route('inbox.index')}}"><i class="fa-solid fa-file-export"></i>Outgoing Dts</a></li>
                <li><a href="{{route('inbox.index')}}"><i class="fa-solid fa-file-export"></i>Create</a></li>
                <li><a href="{{route('Document Management.Search & Filter')}}"><i class="fa-solid fa-file-export"></i>Search and filter</a></li>
            </ul>
        </li>

<!-- Tasks  -->
<li class="has-sub">
            <a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="Management">
                <i class="fa-solid fa-tasks"></i>
                <span>Tasks Management</span>
                <i class="fa-solid fa-chevron-down arrow"></i>
            </a>
            <ul class="sub-menu">
                <li><a href="{{ route('Task Management.tasks')}}"><i class="fa-solid fa-users"></i>Inbox</a></li><li>
                 <a href="#"><i class="fa-solid fa-sign-in-alt"></i>Coming</a></li>           
               <li><a href="{{route('Task Management.Task Delegation')}}"><i class="fa-solid fa-user-check"></i>Task Delegation</a></li>
                <li><a href="{{ route('Task Management.create')}}"><i class="fa-solid fa-user-friends"></i>Create Task</a></li>
                <li><a href="{{route('Task Management.main')}}"><i class="fa-solid fa-user-shield"></i>Main Page</a></li>
                <li><a href="{{route('Task Management.index')}}"><i class="fa-solid fa-user-shield"></i>index</a></li>
                <li><a href="{{route('Task Management.dashboard')}}"><i class="fa-solid fa-user-shield"></i>dashboard</a></li>
            </ul>
        </li>

<!-- end tasks -->


       <!-- end documentation -->
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
            
            <a href="{{ route('admin.settings') }}" data-title="Settings">
                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>
            </a>
        </li>
           <li>
            <a href="{{ route('admin.settings') }}" data-bs-toggle="modal" data-bs-target="#myModal">
                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>
            </a>
           
        </li> 

        <li>
            <a href="#" data-bs-toggle="modal" data-bs-target="#myModel">
            <i class ="fa-solid fa-model"></i>
            <span>demp</span>
            </a>
        </li>
    </ul>
    <!-- User -->
       <a href="#" data-bs-toggle="modal" data-bs-target="#settingsModal" style="text-decoration:none; color:#fff; display:fixed; align-items:center; gap:1px; padding:3px;">
        <div class="user-info">
            <img src="/images/logo.png" alt="user">
            <div>
                    <strong>{{ Auth::user()->name ?? 'User' }}</strong>
                <small>Logged In</small>
                <i class="fa-solid fa-sign-in-alt"></i>
        </div>
    </div>

</a>
   
<!-- sss -->
<!-- User logged in link -->

    <!-- end user -->
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
                <a href="{{ route('admin.settings') }}">English</a>
                <a href="{{ route('lang.ps') }}">پښتو</a>
                <a href="{{ route('lang.fa') }}">دری</a>
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
        <a href="{{ route('clock')}}"><i class="fa-solid fa-clock"></i>Clock</a>
        <!-- USER -->
        <div class="nav-item dropdown user">
            <img src="/images/logo.png">
            <span>#</span>
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


<!-- model  -->
<!-- Settings Modal -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom-right" style="width:250px; height:300px;">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center p-4">

                <!-- Avatar -->
                <div class="mx-auto mb-2"
                     style="width:80px;height:80px;border-radius:50%;
                     background:#0b7c8f;display:flex;align-items:center;
                     justify-content:center;color:#fff;font-size:44px;">
                    H
                </div>

                <span class="badge rounded-pill border border-info text-info px-3 py-1">
                    Admin
                </span>

                <h5 class="mt-3 mb-4">Hamad</h5>

                <hr>
              
              <a href="{{ route('admin.settings') }}" class="btn btn-outline-dark w-100 mb-2">
                    <i class="fa-solid fa-gear"></i> Settings
                </a>    
               
                <form method="POST" action="#">
                    @csrf
                    <button class="btn btn-outline-danger w-100">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- stye -->

<!-- end  -->


<!-- end model -->



<!-- SETTINGS MODEL  -->
<!-- Button trigger modal -->
 

  </div>
</div>
<!-- END MODEL USER  -->




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
