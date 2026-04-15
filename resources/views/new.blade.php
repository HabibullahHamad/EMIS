<!DOCTYPE html>
<html lang="{{ htmlLang() }}" dir="{{ htmlDir() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMIS | {{ __('emis.dashboard') }}</title>

    @if(isRtl())
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
/* new for rtl */
html[dir="rtl"] body {
    direction: rtl;
    text-align: right;
}

html[dir="ltr"] body {
    direction: ltr;
    text-align: left;
}

html[dir="rtl"] .sidebar {
    right: 0;
    left: auto;
}

html[dir="ltr"] .sidebar {
    left: 0;
    right: auto;
}

html[dir="rtl"] .top-navbar {
    right: var(--sidebar-width);
    left: 0;
}

html[dir="ltr"] .top-navbar {
    left: var(--sidebar-width);
    right: 0;
}

html[dir="rtl"] .content {
    margin-right: var(--sidebar-width);
    margin-left: 4px;
}

html[dir="ltr"] .content {
    margin-left: var(--sidebar-width);
    margin-right: 4px;
}

html[dir="rtl"] .sidebar.collapsed ~ .top-navbar {
    right: var(--sidebar-collapsed-width);
    left: 0;
}

html[dir="ltr"] .sidebar.collapsed ~ .top-navbar {
    left: var(--sidebar-collapsed-width);
    right: 0;
}

html[dir="rtl"] .sidebar.collapsed ~ .content {
    margin-right: var(--sidebar-collapsed-width);
    margin-left: 4px;
}

html[dir="ltr"] .sidebar.collapsed ~ .content {
    margin-left: var(--sidebar-collapsed-width);
    margin-right: 4px;
}

html[dir="rtl"] .dropdown-menu {
    right: 0;
    left: auto;
}

html[dir="ltr"] .dropdown-menu {
    left: 0;
    right: auto;
}

html[dir="rtl"] .arrow {
    margin-right: auto;
    margin-left: 0;
}

html[dir="ltr"] .arrow {
    margin-left: auto;
    margin-right: 0;
}
/* end */
        :root{
            --sidebar-width: 230px;
            --sidebar-collapsed-width: 70px;
            --topbar-height: 40px;
            --sidebar-bg: #081e51;
            --sidebar-hover: #b3b2b1;
            --sidebar-submenu: rgba(2, 18, 31, 0.53);
        }

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Noto Sans Arabic', sans-serif;
        }

        html, body{
            direction: rtl !important;
            background: #f4f6f9;
        }

        body{
            min-height: 100vh;
        }

        .text-start { text-align: right !important; }
        .text-end { text-align: left !important; }

        .sidebar{
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: #fff;
            position: fixed;
            top: 0;
            right: 0;
            left: auto;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: width .3s ease;
            box-shadow: 2px 0 5px rgba(0,0,0,.15);
        }

        .sidebar.collapsed{
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header{
            padding: 8px 10px 0 10px;
        }

        .toggle-btn{
            background: none;
            border: none;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            padding: 0 8px;
        }

        .logo{
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 20px;
            font-weight: bold;
        }

        .logo img{
            width: 36px;
            height: 36px;
            transition: width .3s, height .3s;
        }

        .logo-text{
            transition: .3s;
        }

        .sidebar.collapsed .logo img{
            width: 20px;
            height: 20px;
        }

        .sidebar.collapsed .logo-text{
            display: none;
        }

        .menu{
            list-style: none;
            padding: 8px;
            flex-grow: 1;
            overflow-y: auto;
            max-height: calc(100vh - 125px);
            scrollbar-width: thin;
            scrollbar-color: #334155 transparent;
        }

        .menu::-webkit-scrollbar{
            width: 6px;
        }

        .menu::-webkit-scrollbar-thumb{
            background: #1e293b;
            border-radius: 10px;
        }

        .menu::-webkit-scrollbar-track{
            background: transparent;
        }

        .menu li{
            margin-bottom: 5px;
        }

        .menu a{
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fbfdff;
            padding: 10px 12px;
            font-size: 14px;
            text-decoration: none;
            position: relative;
            transition: .3s;
            border-radius: 4px;
        }

        .menu a:hover{
            background: var(--sidebar-hover);
            color: #000;
            border-left: 4px solid #0b8bf4;
            border-radius: 0 10px 10px 0;
        }

        .menu a.active-link{
            background: rgba(255,255,255,0.15);
            border-left: 4px solid #e4b301;
            border-radius: 0 10px 10px 0;
        }

        .menu span{
            white-space: nowrap;
        }

        .arrow{
            margin-right: auto;
            transition: transform .2s ease;
        }

        .has-sub.active > a .arrow{
            transform: rotate(180deg);
        }

        .sidebar.collapsed .menu span,
        .sidebar.collapsed .arrow{
            display: none;
        }

        .sidebar.collapsed .menu a::after{
            content: attr(data-title);
            position: absolute;
            right: 80px;
            background: #1e293b;
            color: #fff;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 13px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: .2s;
        }

        .sidebar.collapsed .menu a:hover::after{
            opacity: 1;
        }

        .sub-menu{
            list-style: none;
            display: none;
            padding-right: 6px;
            margin-top: 2px;
            background: var(--sidebar-submenu);
            border-radius: 4px;
        }

        .has-sub.active .sub-menu{
            display: block;
        }

        .sub-menu a{
            font-size: 12px;
            font-weight: bold;
            color: #cbd5e1;
            padding: 8px 12px;
        }

        .sidebar-footer{
            border-top: 1px solid #343435;
            background: #131314;
            padding: 8px;
        }

        .user-info{
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .user-info img{
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }

        .sidebar.collapsed .user-info div{
            display: none;
        }

        .top-navbar{
            position: fixed;
            top: 0;
            left: 0;
            right: var(--sidebar-width);
            height: var(--topbar-height);
            background: #b7bbbb;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 10px;
            z-index: 999;
            transition: right .25s ease;
        }

        .sidebar.collapsed ~ .top-navbar{
            right: var(--sidebar-collapsed-width);
        }

        .nav-left,
        .nav-right{
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .nav-search{
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f1f5f9;
            padding: 4px 8px;
            border-radius: 8px;
        }

        .nav-search input{
            border: none;
            background: none;
            outline: none;
            font-size: 13px;
            text-align: right;
            width: 120px;
        }

        .nav-item{
            position: relative;
            cursor: pointer;
            color: #334155;
        }

        .nav-item i{
            font-size: 18px;
        }

        .badge{
            position: absolute;
            top: -6px;
            right: -6px;
            background: #dc2626;
            color: #fff;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 50%;
        }

        .dropdown-menu{
            position: absolute;
            top: 120%;
            right: 0;
            left: auto;
            background: #fff;
            min-width: 200px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,.1);
            display: none;
            flex-direction: column;
            padding: 8px 0;
        }

        .dropdown:hover .dropdown-menu{
            display: flex;
        }

        .dropdown-menu a,
        .dropdown-menu p{
            padding: 10px 15px;
            font-size: 13px;
            color: #334155;
            text-decoration: none;
        }

        .dropdown-menu a:hover{
            background: #f1f5f9;
        }

        .dropdown-title{
            font-weight: bold;
            color: #475569;
        }

        .dropdown-menu hr{
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 6px 0;
        }

        .dropdown-menu .danger{
            color: #dc2626;
        }

        .user{
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user img{
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }

        .content{
            margin-top: calc(var(--topbar-height) + 5px);
            margin-right: var(--sidebar-width);
            margin-left: 4px;
            padding: 15px;
            transition: margin-right .25s ease;
        }

        .sidebar.collapsed ~ .content{
            margin-right: var(--sidebar-collapsed-width);
        }

        .modal-dialog-bottom-right{
            position: fixed;
            bottom: 20px;
            right: 20px;
            margin: 0;
            max-width: 500px;
        }

        .modal.fade .modal-dialog-bottom-right{
            transform: translateY(100%);
        }

        .modal.show .modal-dialog-bottom-right{
            transform: translateY(0);
            transition: transform .3s ease-out;
        }
    </style>
</head>
<body class="{{ isRtl() ? 'rtl-layout' : 'ltr-layout' }}">
    

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <i class="fa-sharp fa-solid fa-align-left" style="color:#e4b301;"></i>
        </button>

        <div class="logo">
            <img src="/images/45.png" alt="Logo">
            <span class="logo-text">EMIS</span>
        </div>
    </div>

    @auth
        @php
            $user = auth()->user();
        @endphp

        <ul class="menu">

            @if($user->canAccess('dashboard.view'))
                <li>
                    <a href="{{ route('dashboard') }}" data-title="{{ __('emis.dashboard') }}">
                        <i class="fa-solid fa-house"></i>
                        <span>{{ __('emis.dashboard') }}</span>
                    </a>
                </li>
            @endif

            <li class="has-sub">
                <a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="{{ __('emis.correspondence') }}">
                    <i class="fa-solid fa-folder"></i>
                    <span>{{ __('emis.correspondence') }}</span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('CorrespondenceManagement.outbox.create') }}">
                            <i class="fa-solid fa-file-export"></i> {{ __('emis.outgoing') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inbox.form') }}">
                            <i class="fa-solid fa-file-import"></i> {{ __('emis.incoming') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('main') }}">
                            <i class="fa-solid fa-box-archive"></i> {{ __('emis.inbox') }}
                        </a>
                    </li>
                </ul>
            </li>

            @if($user->canAccess('employees.view') || $user->canAccess('employees.create'))
                <li class="has-sub">
                    <a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="{{ __('emis.employees') }}">
                        <i class="fa-solid fa-folder"></i>
                        <span>{{ __('emis.employees') }}</span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </a>
                    <ul class="sub-menu">
                        @if($user->canAccess('employees.view'))
                            <li>
                                <a href="{{ route('employees.index') }}">
                                    <i class="fa-solid fa-file-export"></i> {{ __('emis.employees_index') }}
                                </a>
                            </li>
                        @endif

                        @if($user->canAccess('employees.create'))
                            <li>
                                <a href="{{ route('employees.create') }}">
                                    <i class="fa-solid fa-file-import"></i> {{ __('emis.new_employee') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if(
                $user->canAccess('users.view') ||
                $user->canAccess('users.create') ||
                $user->canAccess('roles.view') ||
                $user->canAccess('roles.create') ||
                $user->canAccess('roles.edit') ||
                $user->canAccess('users.edit')
            )
                <li class="has-sub">
                    <a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="{{ __('emis.management') }}">
                        <i class="fa-solid fa-folder"></i>
                        <span>{{ __('emis.management') }}</span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </a>
                    <ul class="sub-menu">

                        @if($user->canAccess('users.create'))
                            <li>
                                <a href="{{ route('Administrations.create') }}">
                                    <i class="fa-solid fa-users"></i> {{ __('emis.create_users') }}
                                </a>
                            </li>
                        @endif

                        @if($user->canAccess('roles.view'))
                            <li>
                                <a href="{{ route('Administrations.Roles') }}">
                                    <i class="fa-solid fa-user-tag"></i> {{ __('emis.roles') }}
                                </a>
                            </li>
                        @endif

                        @if($user->canAccess('roles.create') || $user->canAccess('roles.edit'))
                            <li>
                                <a href="{{ route('Administrations.Role Management') }}">
                                    <i class="fa-solid fa-user-check"></i> {{ __('emis.role_management') }}
                                </a>
                            </li>
                        @endif

                        @if($user->canAccess('users.view') || $user->canAccess('users.edit'))
                            <li>
                                <a href="{{ route('Administrations.User Management') }}">
                                    <i class="fa-solid fa-user-friends"></i> {{ __('emis.user_management') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <li class="has-sub">
                <a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="{{ __('emis.documents') }}">
                    <i class="fa-solid fa-file"></i>
                    <span>{{ __('emis.documents') }}</span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('documents.index') }}">
                            <i class="fa-solid fa-sign-in-alt"></i> {{ __('emis.index') }}
                        </a>
                    </li>
                </ul>
            </li>

            <li class="has-sub">
                <a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="{{ __('emis.documents_management') }}">
                    <i class="fa-solid fa-tasks"></i>
                    <span>{{ __('emis.documents_management') }}</span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('inbox.index') }}">
                            <i class="fa-solid fa-box-archive"></i> {{ __('emis.inbox') }}
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa-solid fa-file-import"></i> {{ __('emis.coming') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inbox.index') }}">
                            <i class="fa-solid fa-file-export"></i> {{ __('emis.outgoing') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inbox.index') }}">
                            <i class="fa-solid fa-file-export"></i> {{ __('emis.create') }}
                        </a>
                    </li>
                </ul>
            </li>

            @if($user->canAccess('tasks.view') || $user->canAccess('tasks.create') || $user->canAccess('tasks.charts'))
                <li class="has-sub">
                    <a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="{{ __('emis.tasks_management') }}">
                        <i class="fa-solid fa-tasks"></i>
                        <span>{{ __('emis.tasks_management') }}</span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </a>
                    <ul class="sub-menu">
                        @if($user->canAccess('tasks.create'))
                            <li>
                                <a href="{{ route('tasks.create') }}">
                                    <i class="fa-solid fa-users"></i> {{ __('emis.create_task') }}
                                </a>
                            </li>
                        @endif

                        @if($user->canAccess('tasks.view'))
                            <li>
                                <a href="{{ route('tasks.index') }}">
                                    <i class="fa-solid fa-sign-in-alt"></i> {{ __('emis.all_tasks') }}
                                </a>
                            </li>
                        @endif

                        @if($user->canAccess('tasks.charts'))
                            <li>
                                <a href="{{ route('tasks.charts') }}">
                                    <i class="fa-solid fa-chart-column"></i> {{ __('emis.charts') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if($user->canAccess('users.view') || $user->canAccess('roles.view'))
                <li class="has-sub">
                    <a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="{{ __('emis.users_roles') }}">
                        <i class="fa-solid fa-users"></i>
                        <span>{{ __('emis.users_roles') }}</span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </a>
                    <ul class="sub-menu">
                        @if($user->canAccess('users.view'))
                            <li>
                                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                                    {{ __('emis.create_users') }}
                                </a>
                            </li>
                        @endif

                        @if($user->canAccess('roles.view'))
                            <li>
                                <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                                    {{ __('emis.roles') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <li>
                <a href="{{ route('admin.settings') }}" data-title="{{ __('emis.settings') }}">
                    <i class="fa-solid fa-gear"></i>
                    <span>{{ __('emis.settings') }}</span>
                </a>
            </li>

        </ul>
    @endauth

    <div class="sidebar-footer">
        <a href="#" data-bs-toggle="modal" data-bs-target="#settingsModal" style="text-decoration:none; color:#fff; width:100%;">
            <div class="user-info">
                <img src="/images/logo.png" alt="user">
                <div>
                    <strong>{{ Auth::user()->name ?? 'User' }}</strong>
                    <small style="display:block;">{{ __('emis.logged_in') }}</small>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="top-navbar" id="topNavbar">
    <div class="nav-left"></div>

    <div class="nav-right">
        <div class="nav-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="{{ __('emis.search_emis') }}">
        </div>

        <div class="nav-item dropdown">
            <i class="fa-solid fa-globe"></i>
            <div class="dropdown-menu">
                <a href="{{ route('lang.en') }}">{{ __('emis.english') }}</a>
                <a href="{{ route('lang.ps') }}">{{ __('emis.pashto') }}</a>
                <a href="{{ route('lang.fa') }}">{{ __('emis.dari') }}</a>
            </div>
        </div>

        <div class="nav-item dropdown">
            <i class="fa-solid fa-bell"></i>
            <span class="badge">4</span>
            <div class="dropdown-menu">
                <p class="dropdown-title">{{ __('emis.notifications') }}</p>
                <a href="{{ route('notifications') }}">{{ __('emis.notifications') }}</a>
                <a href="#">{{ __('emis.documents') }}</a>
                <a href="#">{{ __('emis.create_users') }}</a>
                <a href="#">{{ __('emis.warning') }}</a>
            </div>
        </div>

        <a href="{{ route('clock') }}" style="text-decoration:none; color:#334155;">
            <i class="fa-solid fa-clock"></i> {{ __('emis.clock') }}
        </a>

        <div class="nav-item dropdown user">
            <img src="/images/logo.png" alt="user">
            <span>{{ Auth::user()->name ?? '#' }}</span>
            <div class="dropdown-menu">
                <a href="#"><i class="fa-solid fa-user"></i> {{ __('emis.profile') }}</a>
                <a href="{{ route('admin.settings') }}"><i class="fa-solid fa-gear"></i> {{ __('emis.settings') }}</a>
                <hr>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="border:none;background:none;width:100%;text-align:right;padding:10px 15px;color:#dc2626;">
                        <i class="fa-solid fa-right-from-bracket"></i> {{ __('emis.logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<main class="content">
    @yield('content')
</main>

<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom-right" style="width:250px;">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center p-4">
                <div class="mx-auto mb-2"
                     style="width:80px;height:80px;border-radius:50%;background:#0b7c8f;display:flex;align-items:center;justify-content:center;color:#fff;font-size:44px;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>

                <span class="badge rounded-pill border border-info text-info px-3 py-1">
                    {{ __('emis.admin') }}
                </span>

                <h5 class="mt-3 mb-4">{{ Auth::user()->name ?? 'User' }}</h5>

                <hr>

                <a href="{{ route('admin.settings') }}" class="btn btn-outline-dark w-100 mb-2">
                    <i class="fa-solid fa-gear"></i> {{ __('emis.settings') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-box-arrow-right"></i> {{ __('emis.logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- NEW RTL -->
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    }

    function toggleSubMenu(el) {
        el.parentElement.classList.toggle('active');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const top = document.getElementById('topNavbar');
        const html = document.documentElement;

        const adjust = () => {
            if (!sidebar || !top) return;

            const collapsedWidth = getComputedStyle(document.documentElement)
                .getPropertyValue('--sidebar-collapsed-width').trim() || '70px';

            const fullWidth = getComputedStyle(document.documentElement)
                .getPropertyValue('--sidebar-width').trim() || '230px';

            const value = sidebar.classList.contains('collapsed') ? collapsedWidth : fullWidth;

            if (html.getAttribute('dir') === 'rtl') {
                top.style.right = value;
                top.style.left = '0';
            } else {
                top.style.left = value;
                top.style.right = '0';
            }
        };

        adjust();

        new MutationObserver(adjust).observe(sidebar, {
            attributes: true,
            attributeFilter: ['class']
        });
    });
</script>
<!-- new RTL -->
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    }

    function toggleSubMenu(el) {
        const parent = el.parentElement;
        parent.classList.toggle('active');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const top = document.getElementById('topNavbar');

        const adjust = () => {
            if (!sidebar || !top) return;
            if (sidebar.classList.contains('collapsed')) {
                top.style.right = getComputedStyle(document.documentElement).getPropertyValue('--sidebar-collapsed-width').trim() || '70px';
            } else {
                top.style.right = getComputedStyle(document.documentElement).getPropertyValue('--sidebar-width').trim() || '230px';
            }
        };

        adjust();

        new MutationObserver(adjust).observe(sidebar, {
            attributes: true,
            attributeFilter: ['class']
        });

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: "{{ __('emis.success') }}",
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: "{{ __('emis.error') }}",
            text: "{{ session('error') }}"
        });
        @endif

        @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: "{{ __('emis.warning') }}",
            text: "{{ session('warning') }}"
        });
        @endif

        @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: "{{ __('emis.validation_error') }}",
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
        @endif
    });

    function confirmDelete(formId) {
        Swal.fire({
            title: "{{ __('emis.are_you_sure') }}",
            text: "{{ __('emis.cannot_undo') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: "{{ __('emis.yes_delete') }}",
            cancelButtonText: "{{ __('emis.cancel') }}"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>

</body>
</html>