<doctype html>
<html lang="en">    
    <head>
        <style>

/* Sidebar top/profile */
    .sidebar-top{
        display:flex;
        align-items:center;
        gap:12px;
        padding:12px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.03);
    }
    .sidebar-top img.avatar{
        width:44px;
        height:44px;
        border-radius:50%;
        object-fit:cover;
        border:2px solid rgba(255,255,255,0.06);
    }
    .sidebar-top .user-info{
        display:flex;
        flex-direction:column;
        line-height:1;
    }
    .sidebar-top .user-name{ font-size:14px; color:#fff; font-weight:600; }
    .sidebar-top .user-role{ font-size:12px; color:#cbd5f5; opacity:0.8; }

    /* Footer (logged-in user) */
    .sidebar-footer{
        position:absolute;
        bottom:18px;
        left:0;
        right:0;
        padding:12px 20px;
        display:flex;
        gap:10px;
        align-items:center;
        border-top:1px solid rgba(255,255,255,0.03);
    }
    .sidebar-footer img{ width:36px; height:36px; border-radius:50%; object-fit:cover; }
    .sidebar-footer .user-name{ color:#fff; font-size:13px; }
    .sidebar-footer .user-status{ color:#cbd5f5; font-size:12px; opacity:0.8; }

    /* Hide labels when collapsed */
    .sidebar.collapsed .sidebar-top .user-info,
    .sidebar.collapsed .sidebar-footer .user-name,
    .sidebar.collapsed .sidebar-footer .user-status{
        display:none;
    }

    /* Submenu styles */
    .menu li.has-sub > a{ cursor:pointer; position:relative; }
    .menu li.has-sub > a::after{
        content: "\u25B6";
        margin-left:auto;
        transition: transform .18s;
        opacity:0.9;
        font-size:12px;
    }
    .menu li.has-sub.open > a::after{ transform: rotate(90deg); }
    .menu .submenu{
        list-style:none;
        padding-left:18px;
        display:none;
        background: transparent;
    }
    .menu li.has-sub.open > .submenu{ display:block; }
    .menu .submenu li a{
        padding:8px 20px 8px 44px;
        font-size:13px;
        color:#cbd5f5;
    }
    .menu .submenu li a i{ font-size:10px; min-width:18px; opacity:0.9; }

    /* Tooltip for submenu (inherit same behavior) */
    .menu li.has-sub .tooltip{ left:75px; }
    </style>

    <div class="sidebar-top">
        <img class="avatar" src="public/images/logo.png" alt="avatar">
        <div class="user-info">
            <span class="user-name">Admin User</span>
            <span class="user-role">Administrator</span>
        </div>
    </div>

    <!-- footer: shown at bottom of sidebar -->
    <div class="sidebar-footer" id="sidebar-footer">
        <img src="https://via.placeholder.com/72" alt="profile">
        <div>
            <div class="user-name">John Doe</div>
            <div class="user-status">Logged in</div>
        </div>
    </div>
</div>
    <script>
    // add submenus into existing menu items and enable toggle
    document.addEventListener('DOMContentLoaded', function(){
        // helper: attach submenu to a menu item by visible span text
        function attachSubmenuTo(label, items){
            var anchors = Array.from(document.querySelectorAll('.menu li > a'));
            var target = anchors.find(a => a.querySelector('span') && a.querySelector('span').textContent.trim() === label);
            if(!target) return;
            var li = target.parentElement;
            li.classList.add('has-sub');
            var submenu = document.createElement('ul');
            submenu.className = 'submenu';
            items.forEach(function(it){
                var subLi = document.createElement('li');
                subLi.innerHTML = '<a href="#"><i class="bi bi-dot"></i><span>'+it+'</span></a><div class="tooltip">'+it+'</div>';
                submenu.appendChild(subLi);
            });
            li.appendChild(submenu);
        }

        // Example: add submenu under "Documentation" and "Settings"
        attachSubmenuTo('Documentation', ['API Reference','Guides','Changelog']);
        attachSubmenuTo('Settings', ['Profile','Security','Integrations']);

        // toggle behavior for any has-sub anchors
        document.querySelectorAll('.menu li.has-sub > a').forEach(function(a){
            a.addEventListener('click', function(e){
                e.preventDefault();
                this.parentElement.classList.toggle('open');
            });
        });

        // when sidebar collapses, close open submenus to avoid overflow
        var sidebar = document.getElementById('sidebar');
        var obs = new MutationObserver(function(){
            if(sidebar.classList.contains('collapsed')){
                document.querySelectorAll('.menu li.has-sub.open').forEach(function(li){ li.classList.remove('open'); });
            }
        });
        obs.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
    });
</script>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<style>
/* Use Inter for toasts so they match the layout font */
.swal2-popup { font-family: 'Inter', sans-serif; }
/* Toast container tweaks to match the screenshot */
.swal2-toast {
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    border-radius: 10px;
    padding: 0.7rem 0.9rem;
    min-width: 360px;
    align-items: center;
}
/* Header layout: icon + title aligned like image */
.swal2-toast .swal2-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0;
}
/* Title styling */
.swal2-toast .swal2-title {
    font-size: 1.05rem;
    font-weight: 500;
    color: #374151; /* gray-700 */
    margin: 0;
    line-height: 1;
}
/* Make the success icon look like a green circle with white check */
.swal2-icon.swal2-success {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #10b981; /* green */
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    justify-content: center;
}
/* Tweak the check mark color and stroke (works for SVG inside Swal) */
.swal2-icon.swal2-success .swal2-success-circular-line,
.swal2-icon.swal2-success .swal2-success-fix,
.swal2-icon.swal2-success .swal2-success-line-tip,
.swal2-icon.swal2-success .swal2-success-line-long {
    stroke: #ffffff;
    background: transparent;
}
/* Progress bar (timer) styling */
.swal2-toast .swal2-timer-progress-bar {
    height: 8px;
    border-radius: 6px;
    background: #16a34a; /* darker green */
    margin-top: 10px;
    box-shadow: 0 2px 0 rgba(0,0,0,0.06);
}
/* Reduce default padding around the icon/title for compact look */
.swal2-toast .swal2-content {
    padding: 0;
}
/* Optional: make confirm / action buttons hidden for pure toast */
.swal2-toast .swal2-actions {
    display: none;
}
</style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EMIS Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body { background-color: #f8f9fa; overflow-x: hidden; font-family: 'Inter', sans-serif; }
        /* Sidebar base */
        #sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 220px; background: #0a5acaff; color: #0c0c0cff; transition: all 0.3s ease; overflow-y: auto; z-index: 1040; }
        #sidebar.collapsed { width: 80px; }
        #sidebar .sidebar-header { padding: 1rem; text-align: center; font-size: 1.1rem; background: #0f8febff; color: #fff; font-weight: 200; }

        /* Nav links */
        #sidebar .nav-link { color: #cbd5e1; display:flex; align-items:center; justify-content:space-between; padding:0.8rem 1rem; transition: all 0.3s ease; border-left:3px solid transparent; }
        #sidebar .nav-link:hover { background:#02112aff; color:#fff; border-left:5px solid #c0bd05ff; }
        #sidebar .nav-link i { margin-right:10px; transition: transform 0.3s ease; }
        #sidebar .nav-link:hover i { transform: rotate(15deg) scale(1.2); }
        #sidebar .submenu { display:flex; flex-direction:column; background:#1556c6ff; color:#f9f9f9ff; max-height:0; overflow:hidden; transition:max-height 0.28s ease; }
        #sidebar .submenu .nav-link { padding-left:2.5rem; font-size:0.9rem; }
        #sidebar .nav-item.open > .submenu { max-height:480px; }
        .menu-arrow { margin-left:auto; transition: transform 0.3s; }
        .nav-item.open .menu-arrow { transform: rotate(90deg); }
        :root{
            --sidebar-expanded: 250px;
            --sidebar-collapsed: 80px;
        }
        /* Ensure CSS sizes align with JS measurements */
        #sidebar { width: var(--sidebar-expanded); }
        #sidebar.collapsed { width: var(--sidebar-collapsed); }
        /* Make top navbar and main content follow the sidebar width */
        #top-navbar { left: var(--sidebar-expanded); transition: left .3s ease, right .3s ease; }
        #sidebar.collapsed ~ #top-navbar { left: var(--sidebar-collapsed); }
        #main-content { margin-left: var(--sidebar-expanded); transition: margin-left .3s ease; padding: 1.25rem; }
        #sidebar.collapsed ~ #main-content { margin-left: var(--sidebar-collapsed); }
        /* Fixed toggle button at the top-left corner (adjusts with sidebar) */
        #sidebarToggle{
            position: fixed;
            top: 10px;
            left: calc(var(--sidebar-expanded) + 12px);
            z-index: 1101;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            transition: left .3s ease, transform .15s ease;
        }
        /* When sidebar is collapsed, move toggle closer to the edge */
        #sidebar.collapsed ~ #top-navbar #sidebarToggle {
            left: calc(var(--sidebar-collapsed) + 12px);
        }
        /* Mobile / small screens: treat sidebar as off-canvas and keep toggle accessible */
        @media (max-width: 768px) {
            /* Let JS manage open state; CSS will assume sidebar off-canvas by default */
            #sidebar { transform: translateX(-100%); width: var(--sidebar-collapsed); transition: transform .25s ease; }
            #sidebar.open { transform: translateX(0); } /* optional if you add an "open" class for mobile */
            #top-navbar, #main-content { left: 0 !important; margin-left: 0 !important; }
            #sidebarToggle { left: 10px !important; }
        }
        /* Top Navbar and main content */
        #top-navbar { position: fixed; left: var(--sidebar-expanded); right: 0; top: 0; background: #fff; border-bottom: 1px solid #ddd; height: 60px; transition: left 0.3s; z-index:1050; }
        #sidebar.collapsed ~ #top-navbar { left: var(--sidebar-collapsed); }
        #main-content { margin-left: var(--sidebar-expanded); margin-top: 60px; transition: margin-left 0.3s; padding: 1.25rem; }
        #sidebar.collapsed ~ #main-content { margin-left: var(--sidebar-collapsed); }
        /* Toggle button */
        #sidebarToggle { border: none; background: none; color: #374151; font-size: 1.3rem; margin-left: 1px; }
        /* Scrollbar */
        #sidebar::-webkit-scrollbar { width:5px; }
        #sidebar::-webkit-scrollbar-thumb { background-color: #4b5563; border-radius: 10px; }
        /* Top navbar small tweaks */
        #top-navbar .form-control[type="search"] { max-width: 250px; transition: max-width 0.2s ease; }
        #top-navbar .form-control.form-control-sm { padding: .25rem .5rem; font-size: .85rem; height: calc(1.5em + .5rem); }
        #top-navbar .nav-link .badge { font-size: 0.65rem; padding: 0.2em 0.35em; }
        /* Fixed area for notifications and language selector */
        /* Ensure main content adjusts for fixed navbar */
        #main-content.fixed {
            margin-top: 50px; /* Height of the fixed navbar */
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div id="sidebar">
        <div class="sidebar-header d-flex flex-column align-items-center" style="position: sticky; top: 0; background: #0664e6ff; z-index: 1001;">
                <div class="sidebar-logo text-center p-0">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Organization Logo" style="max-width: 100px; align:left">
        </a>
        </div>
        <span class="text-white">EMIS</span>
        <hr class="w-100 text-white mt-1 mb-0">
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <div><i class="fa-solid fa-gauge"></i><span class="sidebar-text"> Dashboard</span></div>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link d-flex align-items-center justify-content-between">
                    <div><i class="fa-solid fa-envelope"></i><span class="sidebar-text"> Correspondence</span></div>
                    <i class="fa-solid fa-chevron-right menu-arrow"></i>
                </a>
                <div class="submenu">
                    <a href="#" class="nav-link has-submenu">
                        <i class="fa-solid fa-inbox me-2"></i>Inbox
                    </a>
                    <div class="submenu-inner">
                        <a href="{{ url('CorrespondenceManagement/inbox/index') }}" class="nav-link submenu-link">
                            <i class="fa-solid fa-arrow-down-tray me-2"></i>Incommming Letters
                        </a>
                        <a href="#" class="nav-link submenu-link">
                            <i class="fa-solid fa-star me-2"></i>Starred
                        </a>
                        <a href="#" class="nav-link submenu-link">
                            <i class="fa-solid fa-circle-exclamation me-2"></i>Important
                        </a>
                    </div>
                 
                    <a href="{{ route('Administrations.User Management') }}" class="nav-link has-submenu">
                        <i class="fa-solid fa-paper-plane me-2"></i>Outbox
                    </a>
                    <div class="submenu-inner">
                        <a href="#" class="nav-link submenu-link">
                            <i class="fa-solid fa-paper-plane me-2"></i>Sent
                        </a>
                        <a href="#" class="nav-link submenu-link">
                            <i class="fa-solid fa-clock me-2"></i>Pending
                        </a>
                        <a href="#" class="nav-link submenu-link">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>Failed
                        </a>
                    </div>
                    <a href="{{ route('Administrations.create') }}" class="nav-link has-submenu">
                        <i class="fa-solid fa-file-pen me-2"></i>Drafts
                    </a>
                    <div class="submenu-inner">
                        <a href="#" class="nav-link submenu-link">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Saved
                        </a>
                        <a href="#" class="nav-link submenu-link">
                            <i class="fa-solid fa-calendar-check me-2"></i>Scheduled
                        </a>
                        <a href="{{ route('Main') }}" class="nav-link submenu-link">
                            <i class="fa-solid fa-file-lines me-2"></i>Main
                        </a>
                    </div>
                    
                </div>
                <style>
                /* Show submenu-inner on hover */
                .submenu .has-submenu + .submenu-inner {
                    display: none;
                    background: #1e40af;
                    padding-left: 1.5rem;
                }
                .submenu .has-submenu:hover + .submenu-inner,
                .submenu .submenu-inner:hover {
                    display: flex;
                    flex-direction: column;
                }
                .submenu .submenu-inner .nav-link {
                    font-size: 0.95rem;
                    padding-left: 2.5rem;
                    background: #2563eb;
                    color: #fff;
                }
                </style>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link d-flex align-items-center justify-content-between">
                    <div><i class="fa-solid fa-list-check"></i><span class="sidebar-text"> Tasks</span></div>
                    <i class="fa-solid fa-chevron-right menu-arrow"></i>
                </a>
                <div class="submenu">
                    <a href="{{ route('Task Management.index') }}" class="nav-link">Index Page</a>
                    <a href="#" class="nav-link">Completed</a>
                    <a href="#" class="nav-link">Completed</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link d-flex align-items-center justify-content-between">
                    <div><i class="fa-solid fa-folder-open"></i><span class="sidebar-text"> Documents</span></div>
                    <i class="fa-solid fa-chevron-right menu-arrow"></i>
                </a>
                <div class="submenu">
                    <a href="#" class="nav-link">Archives</a>
                    <a href="#" class="nav-link">Upload</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link d-flex align-items-center justify-content-between">
                    <div><i class="fa-solid fa-gear"></i><span class="sidebar-text"> Settings</span></div>
                    <i class="fa-solid fa-chevron-right menu-arrow"></i>
                </a>
                <div class="submenu">
                    <a href="{{route('new')}}" class="nav-link">Users</a>
                    <a href="#" class="nav-link">Roles</a>
                </div>
            </li>
        </ul>
    </div>
    <!-- Top Navbar -->
    <nav id="top-navbar" class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top px-3 py-2">
        <div class="container-fluid">
            <!-- Brand / Logo -->
            <button id="sidebarToggle" class="btn btn-outline-primary btn-sm me-2 d-flex align-items-center" type="button" aria-label="Toggle sidebar" aria-expanded="true">
                <i class="fa-solid fa-bars"></i>
            </button>
            <!-- Toggle button (for mobile view) -->
            <!-- Navbar content -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <!-- Search Bar -->
                <form class="d-flex ms-lg-3 my-2 my-lg-0 flex-grow-1" action="#" method="GET">
                    <div class="input-group">
                        <input class="form-control" type="search" name="query" placeholder="Search..." aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Right Side -->
                <ul class="navbar-nav ms-auto align-items-center mt-2 mt-lg-0">

                    <!-- Notifications (new) -->
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link position-relative text-secondary" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bell fa-lg text-primary"></i>
                            <span id="notifBadge" class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle">4</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown" style="min-width:320px;">
                            <li class="dropdown-header">Notifications</li>
                            <li><a class="dropdown-item small" href="#">New message from John <span class="text-muted d-block small">2m ago</span></a></li>
                            <li><a class="dropdown-item small" href="#">Task assigned: Review report <span class="text-muted d-block small">1h ago</span></a></li>
                            <li><a class="dropdown-item small" href="#">System update available <span class="text-muted d-block small">Yesterday</span></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="{{ url('/notifications') }}">View all notifications</a></li>
                        </ul>
                    </li>
                    <!-- Language Selector -->
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link dropdown-toggle text-secondary d-flex align-items-center" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-globe me-1 text-primary"></i>
                            <span>Language</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                            <li><a class="dropdown-item" href="">English</a></li>
                            <li><a class="dropdown-item" href="">پښتو</a></li>
                            <li><a class="dropdown-item" href="">دری</a></li>
                        </ul>
                    </li>

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-secondary d-flex align-items-center"
                           href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fa-solid fa-circle-user fa-lg me-2 text-primary"></i>
                            <span>{{ Auth::user()->name ?? 'Guest' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href=""><i class="fa-solid fa-id-badge me-2"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="#" method="POST" class="m-0">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-right-to-bracket me-2"></i> Login</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main Content (yield area for child views) -->
    <main id="main-content">


        @yield('content')
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // shrink existing search input
        const searchInput = document.querySelector('#top-navbar input[type="search"]');
        if (searchInput) {
            searchInput.classList.add('form-control-sm');
            searchInput.addEventListener('focus', () => searchInput.style.maxWidth = '460px');
            searchInput.addEventListener('blur', () => searchInput.style.maxWidth = '260px');
        }

        // sidebar behavior
        (function () {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('collapsed');
                    window.dispatchEvent(new Event('resize'));
                });
            }

            const sidebarLinks = document.querySelectorAll('#sidebar .nav-item > .nav-link');
            if (sidebarLinks) {
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', e => {
                        const parent = link.parentElement;
                        if (parent && parent.querySelector('.submenu')) {
                            e.preventDefault();
                            parent.classList.toggle('open');
                        }
                    });
                });
            }
        })();

        // Make navbar and main content align with sidebar width
        (function () {
            const sidebar = document.getElementById('sidebar');
            const nav = document.getElementById('top-navbar');
            const main = document.getElementById('main-content');

            const EXPANDED_WIDTH = 250;
            const COLLAPSED_WIDTH = 80;

            function syncPositions() {
                // Determine left offset from the sidebar's state (collapsed or expanded)
                const isMobile = window.innerWidth <= 768;
                let leftValue;
                if (isMobile || !sidebar) {
                    leftValue = 0;
                } else {
                    leftValue = sidebar.classList.contains('collapsed') ? COLLAPSED_WIDTH : EXPANDED_WIDTH;
                }

                if (nav) nav.style.left = leftValue + 'px';
                if (main) main.style.marginLeft = leftValue + 'px';
            }

            syncPositions();
            window.addEventListener('resize', syncPositions);
            if (sidebar) {
                // Observe class changes and debounce a tiny bit so CSS class toggles take effect before measuring
                const observer = new MutationObserver(() => setTimeout(syncPositions, 10));
                observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
            }
        })();

        // Optional: dynamic notification badge update (placeholder for your ajax)
        // Example: fetch('/api/notifications/count').then(r=>r.json()).then(j=>{ document.getElementById('notifBadge').textContent = j.count; });
    });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function () {

    // SUCCESS TOAST
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    // ERROR TOAST
    @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    // VALIDATION ERROR LIST TOAST
    @if ($errors->any())
        let errorMessages = `
            <ul style='text-align: left; margin:0; padding-left:18px;'>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        `;

        Swal.fire({
            icon: 'error',
            title: 'Please fix the following errors:',
            html: errorMessages,
            confirmButtonText: 'OK',
            confirmButtonColor: '#d33'
        });
    @endif

});
</script>
    <script>
        // Optional: Add any additional JavaScript functionality here
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
