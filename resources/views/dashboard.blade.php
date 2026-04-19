<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['ps', 'fa', 'ar']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMIS</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --sidebar-width: 270px;
            --sidebar-collapsed-width: 78px;
            --topbar-height: 52px;
            --primary: #0b3563;
            --primary-dark: #082847;
            --accent: #f6a609;
            --body-bg: #eef2f7;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-soft: #64748b;
            --border: #e2e8f0;
        }

        *{ margin:0; padding:0; box-sizing:border-box; }

        body{
            font-family: 'Noto Sans Arabic', sans-serif;
            background: var(--body-bg);
            color: var(--text-main);
            overflow-x: hidden;
        }

        a{ text-decoration:none; }

        .sidebar{
            position: fixed;
            top: 0;
            {{ in_array(app()->getLocale(), ['ps','fa','ar']) ? 'right' : 'left' }}: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            z-index: 1050;
            transition: all .25s ease;
            display: flex;
            flex-direction: column;
            box-shadow: 0 18px 35px rgba(0,0,0,.18);
        }

        .sidebar.collapsed{ width: var(--sidebar-collapsed-width); }

        .sidebar-header{
            height: 74px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding: 0 14px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .brand-wrap{
            display:flex;
            align-items:center;
            gap:10px;
            overflow:hidden;
        }

        .brand-logo{
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255,255,255,.12);
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
            flex-shrink: 0;
        }

        .brand-logo img{
            width: 24px;
            height: 24px;
            object-fit: contain;
        }

        .brand-text{
            transition: .2s ease;
            white-space: nowrap;
        }

        .brand-title{
            font-size: 17px;
            font-weight: 700;
            margin: 0;
            line-height: 1.1;
        }

        .brand-subtitle{
            font-size: 10px;
            opacity: .8;
            margin-top: 2px;
        }

        .sidebar.collapsed .brand-text{ display:none; }

        .toggle-btn{
            border:none;
            background:transparent;
            color:#fff;
            font-size:16px;
            cursor:pointer;
            width:34px;
            height:34px;
            border-radius:10px;
            transition:.2s ease;
        }

        .toggle-btn:hover{ background: rgba(255,255,255,.12); }

        .sidebar-menu{
            flex:1;
            overflow-y:auto;
            padding: 12px 10px 16px;
        }

        .sidebar-menu::-webkit-scrollbar{ width: 6px; }
        .sidebar-menu::-webkit-scrollbar-thumb{
            background: rgba(255,255,255,.2);
            border-radius: 10px;
        }

        .menu-section-label{
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: rgba(255,255,255,.65);
            padding: 10px 12px 8px;
        }

        .sidebar-nav{ list-style:none; margin:0; padding:0; }
        .sidebar-item{ margin-bottom: 6px; position: relative; }

        .sidebar-link{
            display:flex;
            align-items:center;
            justify-content:space-between;
            color:#e6edf7;
            padding: 10px 12px;
            border-radius: 14px;
            transition: .2s ease;
            position: relative;
            cursor:pointer;
        }

        .sidebar-link:hover,
        .sidebar-item.open > .sidebar-link,
        .sidebar-link.active{
            background: rgba(255,255,255,.12);
            color:#fff;
        }

        .sidebar-link-main{
            display:flex;
            align-items:center;
            gap:12px;
            min-width:0;
        }

        .sidebar-icon{
            width: 22px;
            text-align:center;
            font-size:15px;
            flex-shrink:0;
        }

        .sidebar-text{
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: .2s ease;
        }

        .sidebar-arrow{
            font-size: 12px;
            transition: transform .2s ease;
        }

        .sidebar-item.open > .sidebar-link .sidebar-arrow{
            transform: rotate(180deg);
        }

        .submenu{
            list-style:none;
            margin: 6px 0 0;
            padding: 0;
            display:none;
        }

        .sidebar-item.open > .submenu{ display:block; }

        .submenu .submenu-link{
            display:flex;
            align-items:center;
            gap:10px;
            color:#d7e3f1;
            padding: 9px 14px 9px 44px;
            border-radius: 12px;
            margin-bottom: 4px;
            transition: .2s ease;
            font-size: 13px;
        }

        html[dir="rtl"] .submenu .submenu-link{
            padding: 9px 44px 9px 14px;
        }

        .submenu .submenu-link:hover,
        .submenu .submenu-link.active{
            background: rgba(255,255,255,.10);
            color:#fff;
        }

        .sidebar-footer{
            border-top: 1px solid rgba(255,255,255,.08);
            padding: 12px;
        }

        .user-mini{
            display:flex;
            align-items:center;
            gap:10px;
            color:#fff;
        }

        .user-mini-avatar{
            width:38px;
            height:38px;
            border-radius:50%;
            background: rgba(255,255,255,.12);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:16px;
            flex-shrink:0;
        }

        .user-mini-info{ overflow:hidden; }
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

        .main-wrapper{
            min-height: 100vh;
            transition: all .25s ease;
            margin-{{ in_array(app()->getLocale(), ['ps','fa','ar']) ? 'right' : 'left' }}: var(--sidebar-width);
        }

        .main-wrapper.expanded{
            margin-{{ in_array(app()->getLocale(), ['ps','fa','ar']) ? 'right' : 'left' }}: var(--sidebar-collapsed-width);
        }

        .topbar{
            position: sticky;
            top: 0;
            z-index: 1040;
            height: var(--topbar-height);
            background: rgba(255,255,255,.93);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding: 0 16px;
        }

        .topbar-left{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .topbar-title{
            font-size: 17px;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
            line-height: 1.1;
        }

        .topbar-subtitle{
            font-size: 11px;
            color: var(--text-soft);
            margin-top: 1px;
            line-height: 1.1;
        }

        .topbar-right{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .smart-search{
            position:relative;
        }

        .smart-search input{
            width: 210px;
            height: 36px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background:#fff;
            padding: 0 38px;
            outline:none;
            font-size:13px;
        }

        .smart-search i{
            position:absolute;
            top:50%;
            transform:translateY(-50%);
            color:#94a3b8;
            {{ in_array(app()->getLocale(), ['ps','fa','ar']) ? 'right' : 'left' }}: 12px;
        }

        .top-icon-btn{
            width: 36px;
            height: 36px;
            border:none;
            background:#fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,.05);
            color: var(--primary);
            position:relative;
            font-size: 14px;
        }

        .notif-badge{
            position:absolute;
            top: -3px;
            {{ in_array(app()->getLocale(), ['ps','fa','ar']) ? 'left' : 'right' }}: -3px;
            background:#ef4444;
            color:#fff;
            min-width:16px;
            height:16px;
            border-radius:50%;
            font-size:9px;
            display:flex;
            align-items:center;
            justify-content:center;
            padding: 0 4px;
        }

        .user-dropdown-btn{
            display:flex;
            align-items:center;
            gap:8px;
            border:none;
            background:#fff;
            border-radius: 12px;
            padding: 5px 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,.05);
        }

        .user-dropdown-avatar{
            width:30px;
            height:30px;
            border-radius:50%;
            background: var(--primary);
            color:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:13px;
        }

        .user-dropdown-info{ text-align:start; }
        .user-dropdown-name{
            font-size:12px;
            font-weight:700;
            color:var(--text-main);
            line-height:1.05;
        }

        .user-dropdown-role{
            font-size:10px;
            color:var(--text-soft);
        }

        .content-area{ padding: 18px; }

        .sidebar-tooltip{
            position: fixed;
            z-index: 2000;
            background: #ffffff;
            color: #0b3563;
            border: 1px solid #dbe4ef;
            box-shadow: 0 8px 20px rgba(0,0,0,.12);
            border-radius: 10px;
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transform: translateY(-50%);
            transition: opacity .15s ease;
        }

        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .user-mini-info,
        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .sidebar-arrow,
        .sidebar.collapsed .submenu{
            display: none !important;
        }

        @media (max-width: 991px){
            .sidebar{
                transform: translateX({{ in_array(app()->getLocale(), ['ps','fa','ar']) ? '100%' : '-100%' }});
            }

            .sidebar.mobile-open{ transform: translateX(0); }

            .main-wrapper,
            .main-wrapper.expanded{
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .smart-search input{ width: 160px; }
            .user-dropdown-info{ display:none; }
            .sidebar-tooltip{ display:none !important; }
        }

        @media (max-width: 576px){
            .topbar{ padding: 0 10px; }
            .content-area{ padding: 12px; }
            .smart-search{ display:none; }
            .topbar-title{ font-size:15px; }
            .topbar-subtitle{ display:none; }
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="brand-wrap">
            <div class="brand-logo">
                <img src="{{ asset('images/logo.png') }}" alt="EMIS">
            </div>
            <div class="brand-text">
                <div class="brand-title">EMIS</div>
                <div class="brand-subtitle">Executive Management Information System</div>
            </div>
        </div>

        <button class="toggle-btn" type="button" id="sidebarToggle">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <div class="sidebar-menu">
        <div class="menu-section-label">{{ __('emis.dashboard') }}</div>
        <ul class="sidebar-nav">

            <li class="sidebar-item">
                <a href="{{ route('dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   data-tooltip="{{ __('emis.dashboard') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-house"></i></span>
                        <span class="sidebar-text">{{ __('emis.dashboard') }}</span>
                    </span>
                </a>
            </li>

            <li class="sidebar-item has-submenu">
                <div class="sidebar-link" data-tooltip="{{ __('emis.user_management') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-users"></i></span>
                        <span class="sidebar-text">{{ __('emis.user_management') }}</span>
                    </span>
                    <span class="sidebar-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <ul class="submenu">
                    <li><a class="submenu-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="fa-solid fa-list"></i><span>{{ __('emis.view') }}</span></a></li>
                    <li><a class="submenu-link {{ request()->routeIs('users.create') ? 'active' : '' }}" href="{{ route('users.create') }}"><i class="fa-solid fa-plus"></i><span>{{ __('emis.create') }}</span></a></li>
                    <li><a class="submenu-link {{ request()->routeIs('roles.index') ? 'active' : '' }}" href="{{ route('roles.index') }}"><i class="fa-solid fa-user-shield"></i><span>{{ __('emis.roles') }}</span></a></li>
                </ul>
            </li>

            <li class="sidebar-item has-submenu">
                <div class="sidebar-link" data-tooltip="{{ __('emis.employees') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-id-badge"></i></span>
                        <span class="sidebar-text">{{ __('emis.employees') }}</span>
                    </span>
                    <span class="sidebar-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <ul class="submenu">
                    <li><a class="submenu-link {{ request()->routeIs('employees.index') ? 'active' : '' }}" href="{{ route('employees.index') }}"><i class="fa-solid fa-list"></i><span>{{ __('emis.view') }}</span></a></li>
                    <li><a class="submenu-link {{ request()->routeIs('employees.create') ? 'active' : '' }}" href="{{ route('employees.create') }}"><i class="fa-solid fa-plus"></i><span>{{ __('emis.create') }}</span></a></li>
                </ul>
            </li>

            <div class="menu-section-label">{{ __('emis.documents') }}</div>

            <li class="sidebar-item has-submenu">
                <div class="sidebar-link" data-tooltip="{{ __('emis.incoming_documents') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-inbox"></i></span>
                        <span class="sidebar-text">{{ __('emis.incoming_documents') }}</span>
                    </span>
                    <span class="sidebar-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <ul class="submenu">
                    <li><a class="submenu-link" href="{{ route('main') }}"><i class="fa-solid fa-list"></i><span>{{ __('emis.view') }}</span></a></li>
                    <li><a class="submenu-link" href="{{ route('inbox.form') }}"><i class="fa-solid fa-plus"></i><span>{{ __('emis.create') }}</span></a></li>
                </ul>
            </li>

            <li class="sidebar-item has-submenu">
                <div class="sidebar-link" data-tooltip="{{ __('emis.outgoing_documents') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-file-export"></i></span>
                        <span class="sidebar-text">{{ __('emis.outgoing_documents') }}</span>
                    </span>
                    <span class="sidebar-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <ul class="submenu">
                    <li><a class="submenu-link {{ request()->routeIs('CorrespondenceManagement.outbox.index') ? 'active' : '' }}" href="{{ route('CorrespondenceManagement.outbox.index') }}"><i class="fa-solid fa-list"></i><span>{{ __('emis.view') }}</span></a></li>
                    <li><a class="submenu-link {{ request()->routeIs('CorrespondenceManagement.outbox.create') ? 'active' : '' }}" href="{{ route('CorrespondenceManagement.outbox.create') }}"><i class="fa-solid fa-plus"></i><span>{{ __('emis.create') }}</span></a></li>
                </ul>
            </li>

            <li class="sidebar-item has-submenu">
                <div class="sidebar-link" data-tooltip="{{ __('emis.tasks_management') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-list-check"></i></span>
                        <span class="sidebar-text">{{ __('emis.tasks_management') }}</span>
                    </span>
                    <span class="sidebar-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <ul class="submenu">
                    <li><a class="submenu-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}" href="{{ route('tasks.index') }}"><i class="fa-solid fa-list"></i><span>{{ __('emis.view') }}</span></a></li>
                    <li><a class="submenu-link {{ request()->routeIs('tasks.create') ? 'active' : '' }}" href="{{ route('tasks.create') }}"><i class="fa-solid fa-plus"></i><span>{{ __('emis.create') }}</span></a></li>
                </ul>
            </li>

            <li class="sidebar-item has-submenu">
                <div class="sidebar-link" data-tooltip="{{ __('emis.documents') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-folder-open"></i></span>
                        <span class="sidebar-text">{{ __('emis.documents') }}</span>
                    </span>
                    <span class="sidebar-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <ul class="submenu">
                    <li><a class="submenu-link {{ request()->routeIs('documents.index') ? 'active' : '' }}" href="{{ route('documents.index') }}"><i class="fa-solid fa-file-lines"></i><span>{{ __('emis.view') }}</span></a></li>
                </ul>
            </li>

            <div class="menu-section-label">{{ __('emis.settings') }}</div>

            <li class="sidebar-item">
                <a href="{{ route('admin.settings') }}" class="sidebar-link" data-tooltip="{{ __('emis.settings') }}">
                    <span class="sidebar-link-main">
                        <span class="sidebar-icon"><i class="fa-solid fa-gear"></i></span>
                        <span class="sidebar-text">{{ __('emis.settings') }}</span>
                    </span>
                </a>
            </li>
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

            <div class="dropdown">
                <button class="top-icon-btn" type="button" data-bs-toggle="dropdown" title="{{ __('emis.language') }}">
                    <i class="fa-solid fa-language"></i>
                </button>
                <ul class="dropdown-menu shadow border-0 rounded-3">
                    <li>
                        <button type="button" class="dropdown-item lang-option" data-lang="en">
                            English
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item lang-option" data-lang="ps">
                            پښتو
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item lang-option" data-lang="fa">
                            دری
                        </button>
                    </li>
                </ul>
            </div>

            <div class="dropdown">
                <button class="top-icon-btn" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-bell"></i>
                    <span class="notif-badge">3</span>
                </button>
                <ul class="dropdown-menu shadow border-0 rounded-3">
                    <li><h6 class="dropdown-header">{{ __('emis.notifications') }}</h6></li>
                    <li><a class="dropdown-item" href="#">{{ __('emis.incoming_documents') }}</a></li>
                    <li><a class="dropdown-item" href="#">{{ __('emis.tasks_management') }}</a></li>
                    <li><a class="dropdown-item" href="#">{{ __('emis.outgoing_documents') }}</a></li>
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
                    <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="fa-solid fa-gear me-2"></i> {{ __('emis.settings') }}</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fa-solid fa-right-from-bracket me-2"></i> {{ __('emis.logout') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <main class="content-area">
        @yield('content')
    </main>
</div>

<form id="language-switch-form" method="POST" action="{{ route('language.switch') }}" style="display:none;">
    @csrf
    <input type="hidden" name="locale" id="language-switch-locale">
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const sidebar = document.getElementById('sidebar');
    const mainWrapper = document.getElementById('mainWrapper');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
    const tooltip = document.getElementById('sidebarTooltip');

    sidebarToggle?.addEventListener('click', function () {
        if (window.innerWidth > 991) {
            sidebar.classList.toggle('collapsed');
            mainWrapper.classList.toggle('expanded');
        } else {
            sidebar.classList.toggle('mobile-open');
        }
    });

    mobileSidebarToggle?.addEventListener('click', function () {
        sidebar.classList.toggle('mobile-open');
    });

    document.querySelectorAll('.has-submenu > .sidebar-link').forEach(link => {
        link.addEventListener('click', function () {
            if (sidebar.classList.contains('collapsed') && window.innerWidth > 991) {
                return;
            }
            this.parentElement.classList.toggle('open');
        });
    });

    document.addEventListener('click', function (e) {
        if (window.innerWidth <= 991) {
            if (!sidebar.contains(e.target) && !mobileSidebarToggle?.contains(e.target)) {
                sidebar.classList.remove('mobile-open');
            }
        }
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

    document.querySelectorAll('.lang-option').forEach(button => {
        button.addEventListener('click', function () {
            const locale = this.dataset.lang;
            document.getElementById('language-switch-locale').value = locale;
            document.getElementById('language-switch-form').submit();
        });
    });
</script>

</body>
</html>