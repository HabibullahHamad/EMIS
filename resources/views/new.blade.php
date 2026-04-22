<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ in_array(app()->getLocale(), ['ps','fa','ar']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ function_exists('setting') ? setting('system_name', __('emis.system_name')) : __('emis.system_name') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
html[dir="rtl"] .sidebar-link-main{
    gap: 8px !important;
}

html[dir="rtl"] .sidebar-icon{
    margin: 0 !important;
}
        :root{
            --sidebar-width: 270px;
            --sidebar-collapsed-width: 80px;
            --topbar-height: 60px;
            --primary: #0b3563;
            --primary-dark: #082847;
            --body-bg: #edf2f7;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-soft: #64748b;
            --border: #e2e8f0;
            --hover: rgba(255,255,255,.12);
            --submenu-bg: #102b4d;
        }
.sidebar-nav,
.submenu{
    padding-left: 0 !important;
    padding-right: 0 !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
}

.submenu-link{
    display: flex;
    align-items: center;
    gap: 8px;
    color: #d7e3f1;
    padding: 9px 14px !important;
    border-radius: 12px;
    margin-bottom: 4px;
    font-size: 13px;
    transition: .2s ease;
}

html[dir="rtl"] .submenu-link{
    padding: 9px 14px !important;
}

html[dir="rtl"] .sidebar-link-main{
    gap: 8px !important;
}

html[dir="rtl"] .sidebar-icon,
html[dir="rtl"] .submenu-link i{
    margin: 0 !important;
    width: 16px;
    min-width: 16px;
    text-align: center;
}
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        html, body{
            height:100%;
            overflow:hidden;
        }

        body{
            font-family:'Noto Sans Arabic', sans-serif;
            background:var(--body-bg);
            color:var(--text-main);
        }

        a{ text-decoration:none; }

        .sidebar{
            position:fixed;
            top:0;
            bottom:0;
            {{ in_array(app()->getLocale(), ['ps','fa','ar']) ? 'right' : 'left' }}:0;
            width:var(--sidebar-width);
            background:linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            color:#fff;
            z-index:1100;
            transition:width .25s ease, transform .25s ease;
            display:flex;
            flex-direction:column;
            overflow:hidden;
            box-shadow:0 20px 40px rgba(0,0,0,.18);
        }

        .sidebar.collapsed{
            width:var(--sidebar-collapsed-width);
        }

        .sidebar-header{
            min-height:76px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 16px;
            border-bottom:1px solid rgba(255,255,255,.08);
        }

        .brand-wrap{
            display:flex;
            align-items:center;
            gap:10px;
            overflow:hidden;
            min-width:0;
        }

        .brand-logo{
            width: 50px;
            height:50px;
            border-radius: 15px;
            background:rgba(255,255,255,.12);
            display:flex;
            align-items:center;
            justify-content:center;
            flex-shrink:0;
        }

        .brand-logo img{
            width: 50px;
            height:50px;
            object-fit:contain;
        }

        .brand-text{
            white-space:nowrap;
        }

        .brand-title{
            font-size:17px;
            font-weight:700;
            line-height:1.1;
        }

        .brand-subtitle{
            font-size:10px;
            opacity:.8;
            margin-top:2px;
        }

        .sidebar.collapsed .brand-text{
            display:none;
        }

        .sidebar.collapsed .brand-wrap{
            margin:auto;
        }

        .toggle-btn{
            width:36px;
            height:36px;
            border:none;
            background:transparent;
            color:#fff;
            border-radius:10px;
            cursor:pointer;
            transition:.2s ease;
            flex-shrink:0;
        }

        .toggle-btn:hover{
            background:var(--hover);
        }

        .sidebar-menu{
            flex:1;
            height:calc(100vh - 76px - 68px);
            overflow-y:auto;
            overflow-x:hidden;
            padding:12px 10px 16px;
            scrollbar-width:none;
            -ms-overflow-style:none;
        }

        .sidebar-menu::-webkit-scrollbar{
            width:0 !important;
            height:0 !important;
            display:none;
        }

        .menu-section-label{
            font-size:10px;
            text-transform:uppercase;
            letter-spacing:.8px;
            color:rgba(255,255,255,.65);
            padding:10px 12px 8px;
        }

        .sidebar-nav{
            list-style:none;
        }

        .sidebar-item{
            position:relative;
            margin-bottom:6px;
        }

        .sidebar-link{
            display:flex;
            align-items:center;
            justify-content:space-between;
            color:#e6edf7;
            padding:11px 12px;
            border-radius:14px;
            transition:.2s ease;
            cursor:pointer;
        }

        .sidebar-link:hover,
        .sidebar-link.active,
        .sidebar-item.open > .sidebar-link{
            background:var(--hover);
            color:#fff;
        }

        .sidebar-link-main{
            display:flex;
            align-items:center;
            gap:12px;
            min-width:0;
        }

        .sidebar-icon{
            width:22px;
            text-align:center;
            font-size:15px;
            flex-shrink:0;
        }

        .sidebar-text{
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .sidebar-arrow{
            font-size:12px;
            transition:transform .2s ease;
        }

        .sidebar-item.open > .sidebar-link .sidebar-arrow{
            transform:rotate(180deg);
        }

        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .sidebar-arrow,
        .sidebar.collapsed .user-mini-info{
            display:none !important;
        }

        .submenu{
            display:none;
            list-style:none;
            margin:6px 0 0;
            animation:fadeIn .18s ease;
        }

        .sidebar-item.open > .submenu{
            display:block;
        }

        @keyframes fadeIn{
            from{opacity:0; transform:translateY(-4px);}
            to{opacity:1; transform:translateY(0);}
        }

        .submenu-link{
    display:flex;
    align-items:center;
    gap:8px;
    color:#d7e3f1;
    padding:9px 14px;
    border-radius:12px;
    margin-bottom:4px;
    font-size:13px;
    transition:.2s ease;
}

html[dir="rtl"] .submenu-link{
    padding:20px 20px;
}
        html[dir="rtl"] .submenu-link{
            padding:9px 42px 20px 14px;
        }

        .submenu-link:hover,
        .submenu-link.active{
            background:rgba(255,255,255,.10);
            color:#fff;
        }

        .sidebar.collapsed .sidebar-item.has-submenu:hover > .submenu{
            display:block !important;
            position:absolute;
            top:0;
            right:calc(100% + 10px);
            min-width:220px;
            background:var(--submenu-bg);
            border:1px solid rgba(255,255,255,.08);
            border-radius:14px;
            padding:10px;
            box-shadow:0 10px 24px rgba(0,0,0,.18);
            z-index:2000;
        }

        html[dir="ltr"] .sidebar.collapsed .sidebar-item.has-submenu:hover > .submenu{
            right:auto;
            left:calc(100% + 10px);
        }

        .sidebar.collapsed .submenu-link{
            padding:10px 12px !important;
        }

        .sidebar-footer{
            min-height:68px;
            border-top:1px solid rgba(255,255,255,.08);
            padding:12px;
            display:flex;
            align-items:center;
        }

        .user-mini{
            display:flex;
            align-items:center;
            gap:10px;
            color:#fff;
            width:100%;
        }

        .user-mini-avatar{
            width:40px;
            height:40px;
            border-radius:50%;
            background:rgba(255,255,255,.12);
            display:flex;
            align-items:center;
            justify-content:center;
            flex-shrink:0;
        }

        .user-mini-name{
            font-size:13px;
            font-weight:700;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .user-mini-role{
            font-size:11px;
            opacity:.75;
        }

        .sidebar-tooltip{
            position:fixed;
            z-index:3000;
            background:#fff;
            color:#0b3563;
            border:1px solid #dbe4ef;
            box-shadow:0 8px 20px rgba(0,0,0,.12);
            border-radius:10px;
            padding:7px 11px;
            font-size:12px;
            font-weight:600;
            white-space:nowrap;
            opacity:0;
            pointer-events:none;
            transition:opacity .15s ease;
        }

        .main-wrapper{
            height:100vh;
            overflow-y:auto;
            overflow-x:hidden;
            transition:margin .25s ease;
            margin-{{ in_array(app()->getLocale(), ['ps','fa','ar']) ? 'right' : 'left' }}:var(--sidebar-width);
        }

        .main-wrapper.expanded{
            margin-{{ in_array(app()->getLocale(), ['ps','fa','ar']) ? 'right' : 'left' }}:var(--sidebar-collapsed-width);
        }

        .topbar{
            position:sticky;
            top:0;
            z-index:1000;
            height:var(--topbar-height);
            background:rgba(255,255,255,.95);
            backdrop-filter:blur(12px);
            border-bottom:1px solid var(--border);
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 16px;
        }

        .topbar-left,
        .topbar-right{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .topbar-title{
            font-size:17px;
            font-weight:700;
            margin:0;
        }

        .topbar-subtitle{
            font-size:11px;
            color:var(--text-soft);
            margin-top:1px;
        }

        .smart-search{
            position:relative;
            width:190px;
            transition:width .28s ease;
        }

        .smart-search input{
            width:100%;
            height:38px;
            border:1px solid var(--border);
            border-radius:12px;
            background:#fff;
            padding:0 40px;
            outline:none;
            font-size:13px;
            transition:all .28s ease;
        }

        .smart-search i{
            position:absolute;
            top:50%;
            transform:translateY(-50%);
            color:#94a3b8;
            {{ in_array(app()->getLocale(), ['ps','fa','ar']) ? 'right' : 'left' }}:13px;
            transition:color .25s ease;
        }

        .smart-search:focus-within{
            width:320px;
        }

        .smart-search:focus-within input{
            border-color:#0b3563;
            box-shadow:0 0 0 3px rgba(11,53,99,.08);
        }

        .smart-search:focus-within i{
            color:#0b3563;
        }

        .top-icon-btn{
            width:38px;
            height:38px;
            border:none;
            background:#fff;
            border-radius:12px;
            color:var(--primary);
            box-shadow:0 4px 12px rgba(0,0,0,.05);
            position:relative;
        }

        .notif-badge{
            position:absolute;
            top:-3px;
            {{ in_array(app()->getLocale(), ['ps','fa','ar']) ? 'left' : 'right' }}:-3px;
            min-width:16px;
            height:16px;
            border-radius:50%;
            background:#ef4444;
            color:#fff;
            font-size:9px;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:0 4px;
        }

        .user-dropdown-btn{
            display:flex;
            align-items:center;
            gap:8px;
            border:none;
            background:#fff;
            border-radius:12px;
            padding:5px 10px;
            box-shadow:0 4px 12px rgba(0,0,0,.05);
        }

        .user-dropdown-avatar{
            width:30px;
            height:30px;
            border-radius:50%;
            background:var(--primary);
            color:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .user-dropdown-name{
            font-size:12px;
            font-weight:700;
            line-height:1.05;
        }

        .user-dropdown-role{
            font-size:10px;
            color:var(--text-soft);
        }

        .content-area{
            padding:18px;
        }

        @media (max-width:991px){
            .sidebar{
                transform:translateX({{ in_array(app()->getLocale(), ['ps','fa','ar']) ? '100%' : '-100%' }});
            }

            .sidebar.mobile-open{
                transform:translateX(0);
            }

            .main-wrapper,
            .main-wrapper.expanded{
                margin-left:0 !important;
                margin-right:0 !important;
            }

            .smart-search{
                width:150px;
            }

            .smart-search:focus-within{
                width:220px;
            }

            .user-dropdown-info,
            .sidebar-tooltip{
                display:none !important;
            }
        }

        @media (max-width:576px){
            .content-area{
                padding:12px;
            }

            .smart-search{
                display:none;
            }

            .topbar-title{
                font-size:15px;
            }

            .topbar-subtitle{
                display:none;
            }
        }
    </style>
</head>
<body>

@php
    $user = auth()->user();

    $canDashboard = auth()->check() && $user->canAccess('dashboard.view');
    $canUsersView = auth()->check() && $user->canAccess('users.view');
    $canUsersCreate = auth()->check() && $user->canAccess('users.create');
    $canRolesView = auth()->check() && $user->canAccess('roles.view');
    $canRolesCreate = auth()->check() && $user->canAccess('roles.create');
    $canEmployeesView = auth()->check() && $user->canAccess('employees.view');
    $canEmployeesCreate = auth()->check() && $user->canAccess('employees.create');
    $canInboxView = auth()->check() && $user->canAccess('inbox.view');
    $canInboxCreate = auth()->check() && $user->canAccess('inbox.create');
    $canOutboxView = auth()->check() && $user->canAccess('outbox.view');
    $canOutboxCreate = auth()->check() && $user->canAccess('outbox.create');
    $canTasksView = auth()->check() && $user->canAccess('tasks.view');
    $canTasksCreate = auth()->check() && $user->canAccess('tasks.create');
    $canTasksCharts = auth()->check() && $user->canAccess('tasks.charts');
    $canDocumentsView = auth()->check() && ($user->canAccess('documents.view') || $user->canAccess('documents.index'));
    $canSettingsView = auth()->check() && ($user->canAccess('settings.view') || $user->canAccess('admin.settings'));

    $showUsersMenu = $canUsersView || $canUsersCreate || $canRolesView || $canRolesCreate;
    $showEmployeesMenu = $canEmployeesView || $canEmployeesCreate;
    $showInboxMenu = $canInboxView || $canInboxCreate;
    $showOutboxMenu = $canOutboxView || $canOutboxCreate;
    $showTasksMenu = $canTasksView || $canTasksCreate || $canTasksCharts;
    $showDocumentsMenu = $canDocumentsView;
@endphp

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="brand-wrap">
            <div class="brand-logo">
                <img src="{{ asset('images/logo.png') }}" alt="EMIS">
            </div>
            <div class="brand-text">
                <div class="brand-title">EMIS</div>
                <div class="brand-subtitle"></div>
            </div>
        </div>

        <button class="toggle-btn" type="button" id="sidebarToggle">
            <i class="fa-solid fa-angles-left" id="sidebarToggleIcon"></i>
        </button>
    </div>

    <div class="sidebar-menu">
        <div class="menu-section-label"></div>
        <ul class="sidebar-nav">

            @if($canDashboard && Route::has('dashboard'))
            <li class="sidebar-item">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-tooltip="{{ __('emis.dashboard') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-house"></i></span>
                        <span class="sidebar-text">{{ __('emis.dashboard') }}</span>
                    </span>
                </a>
            </li>
            @endif

            @if($showUsersMenu)
            <li class="sidebar-item has-submenu {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'open' : '' }}">
                <div class="sidebar-link" data-tooltip="{{ __('emis.user_management') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-users"></i></span>
                        <span class="sidebar-text">{{ __('emis.user_management') }}</span>
                    </span>
                    <span class="sidebar-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <ul class="submenu">
                    @if($canUsersView && Route::has('users.index'))
                    <li><a class="submenu-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="fa-solid fa-list"></i><span>{{ __('emis.view_users') }}</span></a></li>
                    @endif
                    @if($canUsersCreate && Route::has('users.create'))
                    <li><a class="submenu-link {{ request()->routeIs('users.create') ? 'active' : '' }}" href="{{ route('users.create') }}"><i class="fa-solid fa-plus"></i><span>{{ __('emis.create_users') }}</span></a></li>
                    @endif
                    @if($canRolesView && Route::has('roles.index'))
                    <li><a class="submenu-link {{ request()->routeIs('roles.index') ? 'active' : '' }}" href="{{ route('roles.index') }}"><i class="fa-solid fa-user-shield"></i><span>{{ __('emis.roles') }}</span></a></li>
                    @endif
                    @if($canRolesCreate && Route::has('roles.create'))
                    <li><a class="submenu-link {{ request()->routeIs('roles.create') ? 'active' : '' }}" href="{{ route('roles.create') }}"><i class="fa-solid fa-plus-circle"></i><span>{{ __('emis.create') }} {{ __('emis.roles') }}</span></a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if($showEmployeesMenu)
            <li class="sidebar-item has-submenu {{ request()->routeIs('employees.*') ? 'open' : '' }}">
                <div class="sidebar-link" data-tooltip="{{ __('emis.employees') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-id-badge"></i></span>
                        <span class="sidebar-text">{{ __('emis.employees') }}</span>
                    </span>
                    <span class="sidebar-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <ul class="submenu">
                    @if($canEmployeesView && Route::has('employees.index'))
                    <li><a class="submenu-link {{ request()->routeIs('employees.index') ? 'active' : '' }}" href="{{ route('employees.index') }}"><i class="fa-solid fa-list"></i><span>{{ __('emis.view_employees') }}</span></a></li>
                    @endif
                    @if($canEmployeesCreate && Route::has('employees.create'))
                    <li><a class="submenu-link {{ request()->routeIs('employees.create') ? 'active' : '' }}" href="{{ route('employees.create') }}"><i class="fa-solid fa-plus"></i><span>{{ __('emis.create_employee') }}</span></a></li>
                    @endif
                </ul>
            </li>
            @endif

            <div class="menu-section-label">{{ __('emis.documents') }}</div>

            @if($showInboxMenu)
            <li class="sidebar-item has-submenu {{ request()->routeIs('main') || request()->routeIs('inbox.*') ? 'open' : '' }}">
                <div class="sidebar-link" data-tooltip="{{ __('emis.incoming_documents') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-inbox"></i></span>
                        <span class="sidebar-text">{{ __('emis.incoming_documents') }}</span>
                    </span>
                    <span class="sidebar-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <ul class="submenu">
                    @if($canInboxView && Route::has('main'))
                    <li><a class="submenu-link {{ request()->routeIs('main') ? 'active' : '' }}" href="{{ route('main') }}"><i class="fa-solid fa-list"></i><span>{{ __('emis.view_inbox') }}</span></a></li>
                    @endif
                    @if($canInboxCreate && Route::has('inbox.form'))
                    <li><a class="submenu-link {{ request()->routeIs('inbox.form') ? 'active' : '' }}" href="{{ route('inbox.form') }}"><i class="fa-solid fa-plus"></i><span>{{ __('emis.create_inbox') }}</span></a></li>
                    @endif
                    @if($canInboxView && Route::has('inbox.index'))
                    <li><a class="submenu-link {{ request()->routeIs('inbox.index') ? 'active' : '' }}" href="{{ route('inbox.index') }}"><i class="fa-solid fa-table-list"></i><span>{{ __('emis.inbox') }}</span></a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if($showOutboxMenu)
            <li class="sidebar-item has-submenu {{ request()->routeIs('CorrespondenceManagement.outbox.*') ? 'open' : '' }}">
                <div class="sidebar-link" data-tooltip="{{ __('emis.outgoing_documents') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-file-export"></i></span>
                        <span class="sidebar-text">{{ __('emis.outgoing_documents') }}</span>
                    </span>
                    <span class="sidebar-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <ul class="submenu">
                    @if($canOutboxView && Route::has('CorrespondenceManagement.outbox.index'))
                    <li><a class="submenu-link {{ request()->routeIs('CorrespondenceManagement.outbox.index') ? 'active' : '' }}" href="{{ route('CorrespondenceManagement.outbox.index') }}"><i class="fa-solid fa-list"></i><span>{{ __('emis.view_outbox') }}</span></a></li>
                    @endif
                    @if($canOutboxCreate && Route::has('CorrespondenceManagement.outbox.create'))
                    <li><a class="submenu-link {{ request()->routeIs('CorrespondenceManagement.outbox.create') ? 'active' : '' }}" href="{{ route('CorrespondenceManagement.outbox.create') }}"><i class="fa-solid fa-plus"></i><span>{{ __('emis.create_outbox') }}</span></a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if($showTasksMenu)
            <li class="sidebar-item has-submenu {{ request()->routeIs('tasks.*') ? 'open' : '' }}">
                <div class="sidebar-link" data-tooltip="{{ __('emis.tasks_management') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-list-check"></i></span>
                        <span class="sidebar-text">{{ __('emis.tasks_management') }}</span>
                    </span>
                    <span class="sidebar-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <ul class="submenu">
                    @if($canTasksView && Route::has('tasks.index'))
                    <li><a class="submenu-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}" href="{{ route('tasks.index') }}"><i class="fa-solid fa-list"></i><span>{{ __('emis.view_tasks') }}</span></a></li>
                    @endif
                    @if($canTasksCreate && Route::has('tasks.create'))
                    <li><a class="submenu-link {{ request()->routeIs('tasks.create') ? 'active' : '' }}" href="{{ route('tasks.create') }}"><i class="fa-solid fa-plus"></i><span>{{ __('emis.create_task') }}</span></a></li>
                    @endif
                    @if($canTasksCharts && Route::has('tasks.charts'))
                    <li><a class="submenu-link {{ request()->routeIs('tasks.charts') ? 'active' : '' }}" href="{{ route('tasks.charts') }}"><i class="fa-solid fa-chart-pie"></i><span>{{ __('emis.charts') }}</span></a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if($showDocumentsMenu)
            <li class="sidebar-item has-submenu {{ request()->routeIs('documents.*') ? 'open' : '' }}">
                <div class="sidebar-link" data-tooltip="{{ __('emis.documents') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-folder-open"></i></span>
                        <span class="sidebar-text">{{ __('emis.documents') }}</span>
                    </span>
                    <span class="sidebar-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <ul class="submenu">
                    @if(Route::has('documents.index'))
                    <li><a class="submenu-link {{ request()->routeIs('documents.index') ? 'active' : '' }}" href="{{ route('documents.index') }}"><i class="fa-solid fa-file-lines"></i><span>{{ __('emis.view_documents') }}</span></a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if($canSettingsView && Route::has('admin.settings'))
            <div class="menu-section-label">{{ __('emis.settings') }}</div>
            <li class="sidebar-item">
                <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" data-tooltip="{{ __('emis.settings') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-gear"></i></span>
                        <span class="sidebar-text">{{ __('emis.settings') }}</span>
                    </span>
                </a>
            </li>
            @endif
        </ul>
    </div>

    <div class="sidebar-footer">
        <div class="user-mini">
            <div class="user-mini-avatar"><i class="fa-solid fa-user"></i></div>
            <div class="user-mini-info">
                <div class="user-mini-name">{{ auth()->user()->name ?? 'User' }}</div>
                <div class="user-mini-role">{{ __('emis.logged_in') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="sidebar-tooltip" id="sidebarTooltip"></div>

<div class="main-wrapper" id="mainWrapper">
    <div class="topbar">
        <div class="topbar-left">
            <button class="top-icon-btn d-lg-none" type="button" id="mobileSidebarToggle">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div>
                <h4 class="topbar-title">@yield('page_title', __('emis.dashboard'))</h4>
                <div class="topbar-subtitle">{{ now()->format('Y-m-d') }}</div>
            </div>
        </div>

        <div class="topbar-right">
            <div class="smart-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="{{ __('emis.search') }}">
            </div>

            @if(Route::has('language.switch'))
            <div class="dropdown">
                <button class="top-icon-btn" type="button" data-bs-toggle="dropdown" title="{{ __('emis.language') }}">
                    <i class="fa-solid fa-language"></i>
                </button>
                <ul class="dropdown-menu shadow border-0 rounded-3">
                    <li><button type="button" class="dropdown-item lang-option" data-lang="en">English</button></li>
                    <li><button type="button" class="dropdown-item lang-option" data-lang="ps">پښتو</button></li>
                    <li><button type="button" class="dropdown-item lang-option" data-lang="fa">دری</button></li>
                </ul>
            </div>
            @endif

            <div class="dropdown">
                <button class="top-icon-btn" type="button" data-bs-toggle="dropdown" title="{{ __('emis.notifications') }}">
                    <i class="fa-solid fa-bell"></i>
                    <span class="notif-badge">3</span>
                </button>
                <ul class="dropdown-menu shadow border-0 rounded-3">
                    <li><h6 class="dropdown-header">{{ __('emis.notifications') }}</h6></li>
                    <li><span class="dropdown-item-text text-muted">{{ __('emis.incoming_documents') }}</span></li>
                    <li><span class="dropdown-item-text text-muted">{{ __('emis.tasks_management') }}</span></li>
                    <li><span class="dropdown-item-text text-muted">{{ __('emis.outgoing_documents') }}</span></li>
                </ul>
            </div>

            <div class="dropdown">
                <button class="user-dropdown-btn" type="button" data-bs-toggle="dropdown">
                    <div class="user-dropdown-avatar"><i class="fa-solid fa-user"></i></div>
                    <div class="user-dropdown-info">
                        <div class="user-dropdown-name">{{ auth()->user()->name ?? 'User' }}</div>
                        <div class="user-dropdown-role">{{ __('emis.logged_in') }}</div>
                    </div>
                    <i class="fa-solid fa-chevron-down text-secondary small"></i>
                </button>

                <ul class="dropdown-menu shadow border-0 rounded-3">
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user me-2"></i> {{ __('emis.profile') }}</a></li>
                    @if($canSettingsView && Route::has('admin.settings'))
                    <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="fa-solid fa-gear me-2"></i> {{ __('emis.settings') }}</a></li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    @if(Route::has('logout'))
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fa-solid fa-right-from-bracket me-2"></i> {{ __('emis.logout') }}
                            </button>
                        </form>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <main class="content-area">
        @yield('content')
    </main>
</div>

<div class="sidebar-tooltip" id="sidebarTooltip"></div>

@if(Route::has('language.switch'))
<form id="language-switch-form" method="POST" action="{{ route('language.switch') }}" style="display:none;">
    @csrf
    <input type="hidden" name="locale" id="language-switch-locale">
</form>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
const sidebar = document.getElementById('sidebar');
const mainWrapper = document.getElementById('mainWrapper');
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebarToggleIcon = document.getElementById('sidebarToggleIcon');
const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
const tooltip = document.getElementById('sidebarTooltip');

const SIDEBAR_STATE_KEY = 'emis_sidebar_collapsed';
const SIDEBAR_OPEN_KEY = 'emis_sidebar_open_items';

function getOpenItems() {
    try {
        return JSON.parse(localStorage.getItem(SIDEBAR_OPEN_KEY)) || [];
    } catch (e) {
        return [];
    }
}

function saveOpenItems() {
    const openIndexes = [];
    document.querySelectorAll('.sidebar-item.has-submenu').forEach((item, index) => {
        if (item.classList.contains('open')) openIndexes.push(index);
    });
    localStorage.setItem(SIDEBAR_OPEN_KEY, JSON.stringify(openIndexes));
}

function restoreOpenItems() {
    const openIndexes = getOpenItems();
    document.querySelectorAll('.sidebar-item.has-submenu').forEach((item, index) => {
        if (openIndexes.includes(index)) item.classList.add('open');
    });
}

function updateToggleIcon() {
    if (!sidebarToggleIcon) return;
    const isRtl = document.documentElement.dir === 'rtl';
    const collapsed = sidebar.classList.contains('collapsed');

    if (isRtl) {
        sidebarToggleIcon.className = collapsed ? 'fa-solid fa-angles-left' : 'fa-solid fa-angles-right';
    } else {
        sidebarToggleIcon.className = collapsed ? 'fa-solid fa-angles-right' : 'fa-solid fa-angles-left';
    }
}

function applySavedSidebarState() {
    const collapsed = localStorage.getItem(SIDEBAR_STATE_KEY) === '1';
    if (window.innerWidth > 991 && collapsed) {
        sidebar.classList.add('collapsed');
        mainWrapper.classList.add('expanded');
    }
    updateToggleIcon();
}

sidebarToggle?.addEventListener('click', function () {
    if (window.innerWidth > 991) {
        sidebar.classList.toggle('collapsed');
        mainWrapper.classList.toggle('expanded');
        localStorage.setItem(SIDEBAR_STATE_KEY, sidebar.classList.contains('collapsed') ? '1' : '0');
        updateToggleIcon();
    } else {
        sidebar.classList.toggle('mobile-open');
    }
});

mobileSidebarToggle?.addEventListener('click', function () {
    sidebar.classList.toggle('mobile-open');
});

document.querySelectorAll('.has-submenu > .sidebar-link').forEach(link => {
    link.addEventListener('click', function () {
        const parent = this.parentElement;
        parent.classList.toggle('open');
        saveOpenItems();
    });
});

function showTooltip(text, rect) {
    if (!sidebar.classList.contains('collapsed') || window.innerWidth <= 991) {
        tooltip.style.opacity = '0';
        return;
    }

    tooltip.textContent = text;
    tooltip.style.opacity = '1';

    const isRtl = document.documentElement.dir === 'rtl';
    const top = rect.top + (rect.height / 2);

    tooltip.style.top = top + 'px';
    tooltip.style.left = '';
    tooltip.style.right = '';

    if (isRtl) {
        tooltip.style.right = (window.innerWidth - rect.left + 12) + 'px';
    } else {
        tooltip.style.left = (rect.right + 12) + 'px';
    }
}

function hideTooltip() {
    tooltip.style.opacity = '0';
}

document.querySelectorAll('.sidebar-link').forEach(link => {
    link.addEventListener('mouseenter', function () {
        const text = this.getAttribute('data-tooltip');
        if (!text) return;
        showTooltip(text, this.getBoundingClientRect());
    });

    link.addEventListener('mousemove', function () {
        const text = this.getAttribute('data-tooltip');
        if (!text) return;
        showTooltip(text, this.getBoundingClientRect());
    });

    link.addEventListener('mouseleave', hideTooltip);
});

sidebar.addEventListener('mouseleave', hideTooltip);

document.addEventListener('click', function (e) {
    if (window.innerWidth <= 991) {
        if (!sidebar.contains(e.target) && !mobileSidebarToggle?.contains(e.target)) {
            sidebar.classList.remove('mobile-open');
        }
    }
});

document.querySelectorAll('.lang-option').forEach(button => {
    button.addEventListener('click', function () {
        const form = document.getElementById('language-switch-form');
        const input = document.getElementById('language-switch-locale');
        if (form && input) {
            input.value = this.dataset.lang;
            form.submit();
        }
    });
});

applySavedSidebarState();
restoreOpenItems();

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: "{{ __('emis.success') }}",
    text: @json(session('success')),
    timer: 2500,
    showConfirmButton: false
});
@endif

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: "{{ __('emis.error') }}",
    text: @json(session('error'))
});
@endif

@if(session('warning'))
Swal.fire({
    icon: 'warning',
    title: "{{ __('emis.warning') }}",
    text: @json(session('warning'))
});
@endif

@if($errors->any())
Swal.fire({
    icon: 'error',
    title: "{{ __('emis.validation_error') }}",
    html: `{!! implode('<br>', $errors->all()) !!}`
});
@endif

window.confirmDelete = function(formId) {
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
            document.getElementById(formId)?.submit();
        }
    });
};
</script>

</body>
</html>