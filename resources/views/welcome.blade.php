<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EMIS Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body { background-color: #f8f9fa; overflow-x: hidden; font-family: 'Inter', sans-serif; }

        /* Sidebar base */
        #sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 300px; background: #0a5acaff; color: #0c0c0cff; transition: all 0.3s ease; overflow-y: auto; z-index: 1000; }
        #sidebar.collapsed { width: 80px; }
        #sidebar .sidebar-header { padding: 1rem; text-align: center; font-size: 2.3rem; background: #021744ff; color: #fff; font-weight: 600; }

        /* Nav links */
        #sidebar .nav-link { color: #cbd5e1; display:flex; align-items:center; justify-content:space-between; padding:0.8rem 1rem; transition: all 0.3s ease; border-left:3px solid transparent; }
        #sidebar .nav-link:hover { background:#02112aff; color:#fff; border-left:3px solid #05f121ff; }
        #sidebar .nav-link i { margin-right:10px; transition: transform 0.3s ease; }
        #sidebar .nav-link:hover i { transform: rotate(15deg) scale(1.2); }
        #sidebar .submenu { display:flex; flex-direction:column; background:#1556c6ff; color:#f9f9f9ff; max-height:0; overflow:hidden; transition:max-height 0.28s ease; }
        #sidebar .submenu .nav-link { padding-left:2.5rem; font-size:0.9rem; }
        #sidebar .nav-item.open > .submenu { max-height:480px; }
        .menu-arrow { margin-left:auto; transition: transform 0.3s; }
        .nav-item.open .menu-arrow { transform: rotate(90deg); }

        /* Top Navbar and main content */
        #top-navbar { position: fixed; left: 300px; right: 0; top: 0; background: #fff; border-bottom: 1px solid #ddd; height: 60px; transition: left 0.3s; z-index:1040; }
        #sidebar.collapsed ~ #top-navbar { left: 80px; }
        #main-content { margin-left: 300px; margin-top: 60px; transition: margin-left 0.3s; padding: 20px; }
        #sidebar.collapsed ~ #main-content { margin-left: 80px; }

        /* Toggle button */
        #sidebarToggle { border: none; background: none; color: #374151; font-size: 1.3rem; margin-left: 10px; }

        /* Scrollbar */
        #sidebar::-webkit-scrollbar { width:5px; }
        #sidebar::-webkit-scrollbar-thumb { background-color: #4b5563; border-radius: 10px; }

        /* Top navbar small tweaks */
        #top-navbar .form-control[type="search"] { max-width: 260px; transition: max-width 0.2s ease; }
        #top-navbar .form-control.form-control-sm { padding: .25rem .5rem; font-size: .85rem; height: calc(1.5em + .5rem); }
        #top-navbar .nav-link .badge { font-size: 0.65rem; padding: 0.2em 0.35em; }
        /* Fixed area for notifications and language selector */
        #top-navbar.fixed {
            position: fixed;
            top: 0;
            left: 300px; /* Adjust based on sidebar width */
            right: 0;
            z-index: 1040;
            right: 22px;
            background: #fff;
            border-bottom: 1px solid #ddd;
            height: 60px;
        }



        /* Ensure main content adjusts for fixed navbar */
        #main-content.fixed {
            margin-top: 60px; /* Height of the fixed navbar */
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
            <span class="text-whit">EMIS</span>
            </a></i>
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
                    <a href="{{ url('CorrespondenceManagement/inbox/index') }}" class="nav-link">Inbox</a>
                    <a href="{{ route('Administrations.User Management') }}" class="nav-link">Outbox</a>
                    <a href="{{ route('Administrations.create') }}" class="nav-link">Drafts</a>
                </div>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link d-flex align-items-center justify-content-between">
                    <div><i class="fa-solid fa-list-check"></i><span class="sidebar-text"> Tasks</span></div>
                    <i class="fa-solid fa-chevron-right menu-arrow"></i>
                </a>
                <div class="submenu">
                    <a href="#" class="nav-link">Assigned</a>
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
                    <a href="#" class="nav-link">Users</a>
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

            const EXPANDED_WIDTH = 300;
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
</body>
</html>
