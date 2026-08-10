<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ in_array(app()->getLocale(), ['ps', 'fa', 'ar'], true) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">

    <title>
        {{ function_exists('setting') ? setting('system_name', 'EMIS') : 'EMIS' }}
        @hasSection('page_title')
            - @yield('page_title')
        @else
            @hasSection('title')
                - @yield('title')
            @endif
        @endif
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/persian-datepicker.min.css') }}">

    <style>
        @font-face {
            font-family: 'NotoArabic';
            src: url('{{ asset("fonts/NotoSansArabic-Regular.ttf") }}') format('truetype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        :root {
            --sidebar-width: 300px;
            --sidebar-collapsed-width: 72px;
            --topbar-height: 60px;

            --primary: #0b3563;
            --primary-dark: #071f3b;
            --primary-soft: #154c82;

            --body-bg: #edf2f7;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-soft: #64748b;
            --border: #e2e8f0;

            --sidebar-text: #e8f0fa;
            --sidebar-text-soft: #bdd0e5;
            --sidebar-hover: rgba(255, 255, 255, .11);
            --sidebar-active: rgba(255, 255, 255, .17);
            --nested-bg: rgba(0, 0, 0, .12);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            overflow: hidden;
            font-family: 'NotoArabic', Tahoma, Arial, sans-serif;
            background: var(--body-bg);
            color: var(--text-main);
        }

        a {
            text-decoration: none;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }

        /* ================================================================
           SHARED EMIS COMPONENTS
           ================================================================ */

        .emis-card {
            background: var(--card-bg);
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(15, 23, 42, .06);
            padding: 16px;
            margin-bottom: 16px;
        }

        .emis-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }

        .emis-card-header h5 {
            margin: 0;
            font-weight: 800;
            color: var(--primary);
        }

        .emis-filter {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .emis-filter .form-control,
        .emis-filter .form-select {
            width: 220px;
            max-width: 100%;
            min-height: 38px;
            font-size: 13px;
            border-radius: 10px;
        }

        .emis-btn {
            min-height: 38px;
            padding: 6px 13px;
            border: 0;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
        }

        .emis-btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .emis-btn-primary:hover {
            background: var(--primary-dark);
            color: #fff;
        }

        .emis-btn-success {
            background: #198754;
            color: #fff;
        }

        .emis-btn-danger {
            background: #dc3545;
            color: #fff;
        }

        .emis-btn-warning {
            background: #ffc107;
            color: #111;
        }

        .emis-btn-info {
            background: #0dcaf0;
            color: #111;
        }

        .emis-btn-light {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
        }

        .emis-table {
            width: 100%;
            margin-bottom: 0;
        }

        .emis-table th,
        .emis-table td {
            padding: 10px 8px;
            white-space: nowrap;
            text-align: center;
            vertical-align: middle;
        }

        .emis-table thead th {
            background: #f8fafc;
            color: #0f172a;
            font-size: 13px;
            font-weight: 800;
        }

        .emis-table tbody td {
            font-size: 13px;
        }

        .emis-table .actions-cell {
            min-width: 230px;
        }

        .emis-table .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            flex-wrap: nowrap;
        }

        .emis-table .action-buttons form {
            display: inline-block;
            margin: 0;
        }

        .emis-form-label {
            display: block;
            margin-bottom: 6px;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
        }

        .emis-form-control {
            border: 1px solid #d1d5db;
            border-radius: 10px;
        }

        .emis-form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(11, 53, 99, .12);
        }

        .emis-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 5px 10px;
            font-size: 11px;
            font-weight: 700;
        }

        .emis-alert {
            margin-bottom: 12px;
            padding: 10px 14px;
            border-radius: 12px;
        }

        /* ================================================================
           SIDEBAR
           ================================================================ */

        .sidebar {
            position: fixed;
            inset-block: 0;
            inset-inline-start: 0;
            z-index: 1100;

            width: var(--sidebar-width);
            display: flex;
            flex-direction: column;

            color: #fff;
            background:
                radial-gradient(circle at top, rgba(38, 103, 165, .35), transparent 33%),
                linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);

            box-shadow: 0 20px 40px rgba(0, 0, 0, .18);
            transition: width .25s ease, transform .25s ease;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            min-height: 86px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 0 14px;
            border-bottom: 1px solid rgba(255, 255, 255, .09);
        }

        .brand-wrap {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            overflow: hidden;
        }

        .brand-logo {
            width: 48px;
            height: 48px;
            flex: 0 0 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;

            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 14px;
            background: rgba(255, 255, 255, .10);
        }

        .brand-logo img {
            width: 46px;
            height: 46px;
            object-fit: contain;
        }

        .brand-text {
            min-width: 0;
            white-space: nowrap;
        }

        .brand-title {
            font-size: 18px;
            font-weight: 800;
            line-height: 1.1;
        }

        .brand-subtitle {
            margin-top: 4px;
            color: var(--sidebar-text-soft);
            font-size: 10px;
            line-height: 1.3;
        }

        .toggle-btn {
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            border: 0;
            border-radius: 10px;
            color: #fff;
            background: transparent;
            cursor: pointer;
            transition: background .2s ease;
        }

        .toggle-btn:hover {
            background: var(--sidebar-hover);
        }

        .sidebar-menu {
            flex: 1;
            min-height: 0;
            padding: 10px 8px 12px;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, .18) transparent;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            border-radius: 999px;
            background: rgba(255, 255, 255, .18);
        }

        .sidebar-nav,
        .submenu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-item {
            position: relative;
            margin-bottom: 4px;
        }

        .sidebar-link,
        .submenu-link {
            width: 100%;
            border: 0;
            color: var(--sidebar-text);
            background: transparent;
            text-align: start;
            cursor: pointer;
        }

        .sidebar-link {
            min-height: 42px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;

            padding: 7px 11px;
            border: 1px solid transparent;
            border-radius: 12px;

            transition: background .2s ease, border-color .2s ease, color .2s ease;
        }

        .menu-level-1 > .sidebar-link {
            background: rgba(255, 255, 255, .035);
            border-color: rgba(255, 255, 255, .045);
        }

        .sidebar-link:hover,
        .sidebar-link.active,
        .menu-level-1.open > .sidebar-link {
            color: #fff;
            background: var(--sidebar-active);
            border-color: rgba(255, 255, 255, .11);
        }

        .menu-level-1.open > .sidebar-link {
            box-shadow: inset 3px 0 0 rgba(255, 255, 255, .80);
        }

        html[dir="rtl"] .menu-level-1.open > .sidebar-link {
            box-shadow: inset -3px 0 0 rgba(255, 255, 255, .80);
        }

        .sidebar-link-main,
        .submenu-main {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .sidebar-icon {
            width: 19px;
            min-width: 19px;
            text-align: center;
            font-size: 14px;
        }

        .sidebar-text,
        .submenu-main span,
        .submenu-link > span {
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sidebar-arrow,
        .submenu-arrow {
            flex: 0 0 auto;
            font-size: 10px;
            transition: transform .2s ease;
        }

        .menu-level-1.open > .sidebar-link .sidebar-arrow,
        .menu-level-2.open > .submenu-toggle .submenu-arrow {
            transform: rotate(180deg);
        }

        .submenu {
            display: none;
            margin-top: 3px;
            animation: submenuFade .18s ease;
        }

        .sidebar-item.open > .submenu {
            display: block;
        }

        @keyframes submenuFade {
            from {
                opacity: 0;
                transform: translateY(-4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .menu-level-1 > .submenu {
            padding: 2px 3px 1px;
        }

        .submenu-link {
            min-height: 32px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 5px 9px;
            margin-bottom: 2px;
            border-radius: 9px;
            color: #d3dfed;
            font-size: 13px;
            transition: background .2s ease, color .2s ease;
        }

        .submenu-link:hover,
        .submenu-link.active,
        .menu-level-2.open > .submenu-toggle {
            color: #fff;
            background: rgba(255, 255, 255, .10);
        }

        .submenu-toggle {
            justify-content: space-between;
        }

        .nested-submenu {
            margin: 2px 9px 5px;
            padding: 3px 5px;
            border-inline-start: 1px solid rgba(255, 255, 255, .16);
            border-radius: 9px;
            background: var(--nested-bg);
        }

        .nested-submenu .submenu-link {
            min-height: 29px;
            padding: 4px 8px;
            font-size: 11.5px;
        }

        .nested-submenu .submenu-link i,
        .submenu-main i {
            width: 17px;
            min-width: 17px;
            text-align: center;
        }

        .sidebar-footer {
            min-height: 72px;
            display: flex;
            align-items: center;
            padding: 9px 12px;
            border-top: 1px solid rgba(255, 255, 255, .09);
        }

        .user-mini {
            width: 100%;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
        }

        .user-mini-avatar {
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;
            background: rgba(255, 255, 255, .12);
        }

        .user-mini-info {
            min-width: 0;
        }

        .user-mini-name {
            overflow: hidden;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-mini-role {
            margin-top: 2px;
            color: var(--sidebar-text-soft);
            font-size: 11px;
        }

        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .sidebar-arrow,
        .sidebar.collapsed .user-mini-info,
        .sidebar.collapsed .submenu {
            display: none !important;
        }

        .sidebar.collapsed .sidebar-header {
            justify-content: center;
            padding: 0 8px;
        }

        .sidebar.collapsed .brand-wrap {
            display: none;
        }

        .sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding-inline: 8px;
        }

        .sidebar.collapsed .sidebar-link-main {
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-footer {
            justify-content: center;
        }

        .sidebar.collapsed .user-mini {
            justify-content: center;
        }

        .sidebar-tooltip {
            position: fixed;
            z-index: 3000;
            opacity: 0;
            pointer-events: none;

            padding: 7px 11px;
            border: 1px solid #dbe4ef;
            border-radius: 10px;

            color: var(--primary);
            background: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .12);

            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            transform: translateY(-50%);
            transition: opacity .15s ease;
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            z-index: 1050;
            display: none;
            background: rgba(2, 8, 23, .45);
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* ================================================================
           MAIN WRAPPER AND TOPBAR
           ================================================================ */

        .main-wrapper {
            height: 100vh;
            margin-inline-start: var(--sidebar-width);
            overflow-y: auto;
            overflow-x: hidden;
            transition: margin .25s ease;
        }

        .main-wrapper.expanded {
            margin-inline-start: var(--sidebar-collapsed-width);
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 1000;

            min-height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;

            padding: 8px 16px;
            border-bottom: 1px solid var(--border);

            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(12px);
        }

        .topbar-left,
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-right {
            justify-content: flex-end;
        }

        .topbar-heading {
            min-width: 0;
        }

        .topbar-title {
            margin: 0;
            color: #172033;
            font-size: 17px;
            font-weight: 800;
            line-height: 1.2;
        }

        .topbar-subtitle {
            margin-top: 2px;
            color: var(--text-soft);
            font-size: 11px;
        }

        .smart-search {
            position: relative;
            width: 190px;
            transition: width .28s ease;
        }

        .smart-search input {
            width: 100%;
            height: 38px;
            padding-inline: 38px 12px;
            border: 1px solid var(--border);
            border-radius: 12px;
            outline: none;
            background: #fff;
            font-size: 13px;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .smart-search i {
            position: absolute;
            top: 50%;
            inset-inline-start: 13px;
            color: #94a3b8;
            transform: translateY(-50%);
        }

        .smart-search:focus-within {
            width: 300px;
        }

        .smart-search:focus-within input {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(11, 53, 99, .08);
        }

        .top-icon-btn {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #edf0f4;
            border-radius: 11px;
            color: var(--primary);
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .04);
        }

        .notification-link {
            position: relative;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            inset-inline-end: -6px;
            min-width: 17px;
            height: 17px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            border-radius: 999px;
            color: #fff;
            background: #ef4444;
            font-size: 9px;
            line-height: 1;
        }

        .top-dropdown-btn {
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 10px;
            border: 1px solid #edf0f4;
            border-radius: 11px;
            color: #334155;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .04);
            font-size: 12px;
        }

        .content-area {
            padding: 18px;
        }

        /* ================================================================
           DATEPICKER
           ================================================================ */

        .pwt-datepicker-container {
            overflow: hidden;
            border-radius: 12px !important;
            font-family: 'NotoArabic', Arial, sans-serif;
        }

        .pwt-datepicker-header,
        .pwt-btn-selected,
        .pwt-btn-submit {
            color: #fff !important;
            background: #0a7a94 !important;
        }

        .pwt-btn-selected {
            border-radius: 50% !important;
        }

        /* ================================================================
           COMPACT FOUR-SECTION MENU
           ================================================================ */

        .menu-level-1 > .sidebar-link {
            min-height: 44px;
            padding-block: 7px;
            font-size: 15px;
            font-weight: 700;
        }

        .menu-level-1 + .menu-level-1 {
            margin-top: 4px;
        }

        .menu-level-2 > .submenu-toggle,
        .menu-level-1 > .submenu > li > .submenu-link {
            min-height: 32px;
        }

        .sidebar.collapsed .menu-level-1 > .sidebar-link {
            min-height: 42px;
        }

        /* ================================================================
           RESPONSIVE
           ================================================================ */

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-105%);
            }

            html[dir="rtl"] .sidebar {
                transform: translateX(105%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-wrapper,
            .main-wrapper.expanded {
                margin-inline-start: 0;
            }

            .smart-search {
                width: 150px;
            }

            .smart-search:focus-within {
                width: 210px;
            }

            .sidebar-tooltip {
                display: none !important;
            }
        }

        @media (max-width: 767.98px) {
            .topbar {
                align-items: flex-start;
            }

            .topbar-right {
                gap: 6px;
            }

            .smart-search {
                display: none;
            }

            .topbar-user-name {
                display: none;
            }

            .content-area {
                padding: 13px;
            }
        }

        @media (max-width: 575.98px) {
            .topbar-title {
                max-width: 150px;
                overflow: hidden;
                font-size: 15px;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .topbar-subtitle {
                display: none;
            }

            .language-label {
                display: none;
            }

            .emis-filter .form-control,
            .emis-filter .form-select {
                width: 100%;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

@php
    $user = auth()->user();
    $locale = app()->getLocale();

    /*
    |--------------------------------------------------------------------------
    | Self-contained sidebar translations
    |--------------------------------------------------------------------------
    | These labels work even before the new keys are added to the language files.
    */

    $labels = [
        'en' => [
            'admin' => 'Admin',
            'management' => 'Management',
            'audit' => 'Audit',
            'settings' => 'Settings',
            'dashboard' => 'Dashboard',

            'users_access' => 'Users & Access',
            'users' => 'Users',
            'create_user' => 'Create User',
            'roles' => 'Roles',
            'create_role' => 'Create Role',

            'organization' => 'Organization Structure',
            'departments' => 'Departments',
            'create_department' => 'Create Department',
            'employees' => 'Employees',
            'create_employee' => 'Create Employee',

            'correspondence' => 'Correspondence',
            'incoming' => 'Incoming Documents',
            'create_incoming' => 'Register Incoming',
            'outgoing' => 'Outgoing Documents',
            'create_outgoing' => 'Register Outgoing',
            'documents' => 'Document Archive',

            'tasks' => 'Task Management',
            'all_tasks' => 'All Tasks',
            'create_task' => 'Create Task',
            'charts' => 'Charts',

            'workflow' => 'Workflow',
            'all_workflows' => 'All Workflows',
            'pending' => 'My Pending',
            'sent' => 'Sent Workflows',
            'create_workflow' => 'Create Workflow',

            'tracking' => 'Tracking Center',
            'budget_coordination' => 'Budget Coordination',
            'budget_entities' => 'Budget Entities',
            'focal_points' => 'Focal Points',
            'introduction_letters' => 'Introduction Letters',
            'card_issuance' => 'Card Issuance',
            'issued_cards' => 'Issued Cards',
            'card_verification' => 'Card Verification',
            'focal_point_reports' => 'Focal Point Reports',
            'focal_point_cards' => 'Focal Point Cards',

            'audit_logs' => 'Audit Logs',
            'notifications' => 'Notifications',
            'audit_reports' => 'Audit Reports',

            'system_settings' => 'System Settings',
            'profile' => 'Profile',
            'logout' => 'Logout',
            'language' => 'Language',
            'search' => 'Search',
            'logged_in' => 'Logged in',
            'system_subtitle' => 'Electronic Management Information System',

            'success' => 'Success',
            'error' => 'Error',
            'warning' => 'Warning',
            'validation_error' => 'Validation Error',
            'are_you_sure' => 'Are you sure?',
            'cannot_undo' => 'This action cannot be undone.',
            'yes_delete' => 'Yes, delete',
            'cancel' => 'Cancel',
        ],

        'ps' => [
            'admin' => 'اداري برخه',
            'management' => 'مدیریت',
            'audit' => 'پلټنه او څارنه',
            'settings' => 'تنظیمات',
            'dashboard' => 'مخپاڼه',

            'users_access' => 'کاروونکي او لاسرسی',
            'users' => 'کاروونکي',
            'create_user' => 'نوی کاروونکی',
            'roles' => 'رولونه',
            'create_role' => 'نوی رول',

            'organization' => 'تشکیلاتي جوړښت',
            'departments' => 'څانګې',
            'create_department' => 'نوې څانګه',
            'employees' => 'کارکوونکي',
            'create_employee' => 'نوی کارکوونکی',

            'correspondence' => 'د اسنادو مراسلات',
            'incoming' => 'وارده اسناد',
            'create_incoming' => 'وارده سند ثبتول',
            'outgoing' => 'صادره اسناد',
            'create_outgoing' => 'صادره سند ثبتول',
            'documents' => 'د اسنادو آرشیف',

            'tasks' => 'د دندو مدیریت',
            'all_tasks' => 'ټولې دندې',
            'create_task' => 'نوې دنده',
            'charts' => 'چارټونه',

            'workflow' => 'کاري بهیر',
            'all_workflows' => 'ټول کاري بهیرونه',
            'pending' => 'زما پاتې چارې',
            'sent' => 'لېږل شوي بهیرونه',
            'create_workflow' => 'نوی کاري بهیر',

            'tracking' => 'د تعقیب مرکز',
            'budget_coordination' => 'بودجوي همغږي',
            'budget_entities' => 'بودجوي واحدونه',
            'focal_points' => 'فوکل پاینټونه',
            'introduction_letters' => 'معرفي لیکونه',
            'card_issuance' => 'د کارت صادرول',
            'issued_cards' => 'صادر شوي کارتونه',
            'card_verification' => 'د کارت تایید',
            'focal_point_reports' => 'د فوکل پاینټ راپورونه',
            'focal_point_cards' => 'د فوکل پاینټ کارتونه',

            'audit_logs' => 'د پلټنې ثبتونه',
            'notifications' => 'خبرتیاوې',
            'audit_reports' => 'د پلټنې راپورونه',

            'system_settings' => 'د سیسټم تنظیمات',
            'profile' => 'پروفایل',
            'logout' => 'وتل',
            'language' => 'ژبه',
            'search' => 'لټون',
            'logged_in' => 'سیسټم ته داخل',
            'system_subtitle' => 'د الکترونیکي مدیریت معلوماتي سیسټم',

            'success' => 'بریالی',
            'error' => 'تېروتنه',
            'warning' => 'خبرتیا',
            'validation_error' => 'د معلوماتو تېروتنه',
            'are_you_sure' => 'ایا ډاډه یاست؟',
            'cannot_undo' => 'دا عمل بېرته نه شي راګرځېدلی.',
            'yes_delete' => 'هو، حذف یې کړه',
            'cancel' => 'لغوه',
        ],

        'fa' => [
            'admin' => 'بخش اداری',
            'management' => 'مدیریت',
            'audit' => 'تفتیش و نظارت',
            'settings' => 'تنظیمات',
            'dashboard' => 'صفحه اصلی',

            'users_access' => 'کاربران و دسترسی',
            'users' => 'کاربران',
            'create_user' => 'ایجاد کاربر',
            'roles' => 'نقش‌ها',
            'create_role' => 'ایجاد نقش',

            'organization' => 'ساختار تشکیلاتی',
            'departments' => 'ریاست‌ها و بخش‌ها',
            'create_department' => 'ایجاد بخش',
            'employees' => 'کارمندان',
            'create_employee' => 'ایجاد کارمند',

            'correspondence' => 'مدیریت مکاتیب',
            'incoming' => 'اسناد وارده',
            'create_incoming' => 'ثبت سند وارده',
            'outgoing' => 'اسناد صادره',
            'create_outgoing' => 'ثبت سند صادره',
            'documents' => 'آرشیف اسناد',

            'tasks' => 'مدیریت وظایف',
            'all_tasks' => 'تمام وظایف',
            'create_task' => 'ایجاد وظیفه',
            'charts' => 'چارت‌ها',

            'workflow' => 'جریان کاری',
            'all_workflows' => 'تمام جریان‌ها',
            'pending' => 'کارهای معطل من',
            'sent' => 'جریان‌های ارسال‌شده',
            'create_workflow' => 'ایجاد جریان کاری',

            'tracking' => 'مرکز پیگیری',
            'budget_coordination' => 'هماهنگی بودجوی',
            'budget_entities' => 'واحدهای بودجوی',
            'focal_points' => 'فوکل پاینټ‌ها',
            'introduction_letters' => 'مکتوب‌های معرفی',
            'card_issuance' => 'صدور کارت',
            'issued_cards' => 'کارت‌های صادرشده',
            'card_verification' => 'تأیید کارت',
            'focal_point_reports' => 'گزارش‌های فوکل پاینټ',
            'focal_point_cards' => 'کارت‌های فوکل پاینټ',

            'audit_logs' => 'ثبت‌های تفتیش',
            'notifications' => 'اطلاعیه‌ها',
            'audit_reports' => 'گزارش‌های تفتیش',

            'system_settings' => 'تنظیمات سیستم',
            'profile' => 'پروفایل',
            'logout' => 'خروج',
            'language' => 'زبان',
            'search' => 'جستجو',
            'logged_in' => 'وارد سیستم',
            'system_subtitle' => 'سیستم معلوماتی مدیریت الکترونیکی',

            'success' => 'موفق',
            'error' => 'خطا',
            'warning' => 'هشدار',
            'validation_error' => 'خطای معلومات',
            'are_you_sure' => 'آیا مطمئن هستید؟',
            'cannot_undo' => 'این عمل قابل بازگشت نیست.',
            'yes_delete' => 'بلی، حذف شود',
            'cancel' => 'لغو',
        ],
    ];

    $m = $labels[$locale] ?? $labels['en'];

    /*
    |--------------------------------------------------------------------------
    | Permission helper
    |--------------------------------------------------------------------------
    */

    $can = static function (string $permission) use ($user): bool {
        if (!$user) {
            return false;
        }

        if (method_exists($user, 'canAccess')) {
            return (bool) $user->canAccess($permission);
        }

        if (method_exists($user, 'can')) {
            return (bool) $user->can($permission);
        }

        return false;
    };

    /*
    |--------------------------------------------------------------------------
    | Permission flags
    |--------------------------------------------------------------------------
    */

    $canDashboard = $can('dashboard.view');

    $canUsersView = $can('users.view');
    $canUsersCreate = $can('users.create');
    $canRolesView = $can('roles.view');
    $canRolesCreate = $can('roles.create');

    $canDepartmentsView = $can('departments.view');
    $canDepartmentsCreate = $can('departments.create');
    $canEmployeesView = $can('employees.view');
    $canEmployeesCreate = $can('employees.create');

    $canInboxView = $can('inbox.view');
    $canInboxCreate = $can('inbox.create');
    $canOutboxView = $can('outbox.view');
    $canOutboxCreate = $can('outbox.create');
    $canDocumentsView = $can('documents.view') || $can('documents.index');

    $canTasksView = $can('tasks.view');
    $canTasksCreate = $can('tasks.create');
    $canTasksCharts = $can('tasks.charts');

    $canSettingsView = $can('settings.view') || $can('admin.settings');

    /*
    |--------------------------------------------------------------------------
    | Menu visibility
    |--------------------------------------------------------------------------
    */

    $showUsersAccess = $canUsersView
        || $canUsersCreate
        || $canRolesView
        || $canRolesCreate;

    $showOrganization = $canDepartmentsView
        || $canDepartmentsCreate
        || $canEmployeesView
        || $canEmployeesCreate;

    $showCorrespondence = $canInboxView
        || $canInboxCreate
        || $canOutboxView
        || $canOutboxCreate
        || $canDocumentsView;

    $showTasks = $canTasksView
        || $canTasksCreate
        || $canTasksCharts;

    $showWorkflow = Route::has('workflows.index')
        || Route::has('workflows.pending')
        || Route::has('workflows.sent')
        || Route::has('workflows.create');

    $showBudgetCoordination = Route::has('budget-entities.index')
        || Route::has('focal-points.index')
        || Route::has('focal-point-introductions.index')
        || Route::has('focal-point-cards.index')
        || Route::has('focal-point-cards.issue.index')
        || Route::has('focal-point-card-verification.index')
        || Route::has('focal-point-cards.verification.index')
        || Route::has('focal-point-reports.index');

    $cardVerificationRoute = null;

    if (Route::has('focal-point-card-verification.index')) {
        $cardVerificationRoute = route('focal-point-card-verification.index');
    } elseif (Route::has('focal-point-cards.verification.index')) {
        $cardVerificationRoute = route('focal-point-cards.verification.index');
    }

    /*
    |--------------------------------------------------------------------------
    | Active/open section state
    |--------------------------------------------------------------------------
    */

    $adminOpen = request()->routeIs(
        'dashboard',
        'users.*',
        'roles.*',
        'departments.*',
        'employees.*'
    );

    $managementOpen = request()->routeIs(
        'main',
        'inbox.*',
        'CorrespondenceManagement.outbox.*',
        'documents.*',
        'tasks.*',
        'workflows.*',
        'tracking.*',
        'budget-entities.*',
        'focal-points.*',
        'focal-point-introductions.*',
        'focal-point-cards.*',
        'focal-point-card-verification.*',
        'focal-point-reports.*'
    );

    $auditOpen = request()->routeIs(
        'audit.*',
        'audit-logs.*',
        'notifications',
        'notifications.*'
    );

    $settingsOpen = request()->routeIs(
        'admin.settings',
        'settings.*',
        'profile.*'
    );

    /*
    |--------------------------------------------------------------------------
    | Notification count
    |--------------------------------------------------------------------------
    */

    $unreadNotifications = 0;

    try {
        if (auth()->check() && class_exists(\App\Models\Notification::class)) {
            $unreadNotifications = \App\Models\Notification::query()
                ->where('user_id', auth()->id())
                ->where('is_read', false)
                ->count();
        }
    } catch (\Throwable $exception) {
        $unreadNotifications = 0;
    }
@endphp

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar" aria-label="EMIS navigation">

    {{-- Brand --}}
    <div class="sidebar-header">
        <div class="brand-wrap">
            <div class="brand-logo">
                <img src="{{ asset('images/logo.png') }}" alt="EMIS">
            </div>

            <div class="brand-text">
                <div class="brand-title">EMIS</div>
                <div class="brand-subtitle">{{ $m['system_subtitle'] }}</div>
            </div>
        </div>

        <button class="toggle-btn"
                type="button"
                id="sidebarToggle"
                aria-label="Toggle sidebar">
            <i class="fa-solid fa-angles-left" id="sidebarToggleIcon"></i>
        </button>
    </div>

    <nav class="sidebar-menu">
        <ul class="sidebar-nav">

            {{-- ========================================================= --}}
            {{-- 1. ADMIN --}}
            {{-- ========================================================= --}}
            <li class="sidebar-item has-submenu menu-level-1 {{ $adminOpen ? 'open' : '' }}"
                data-menu-key="admin">

                <button type="button"
                        class="sidebar-link js-main-menu-toggle"
                        data-tooltip="{{ $m['admin'] }}"
                        aria-expanded="{{ $adminOpen ? 'true' : 'false' }}">

                    <span class="sidebar-link-main">
                        <span class="sidebar-icon">
                            <i class="fa-solid fa-user-gear"></i>
                        </span>

                        <span class="sidebar-text">{{ $m['admin'] }}</span>
                    </span>

                    <span class="sidebar-arrow">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </button>

                <ul class="submenu">

                    @if($canDashboard && Route::has('dashboard'))
                        <li>
                            <a href="{{ route('dashboard') }}"
                               class="submenu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                                <i class="fa-solid fa-house"></i>
                                <span>{{ $m['dashboard'] }}</span>
                            </a>
                        </li>
                    @endif

                    @if($showUsersAccess)
                        <li class="sidebar-item has-submenu menu-level-2
                            {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'open' : '' }}"
                            data-menu-key="admin-users-access">

                            <button type="button"
                                    class="submenu-link submenu-toggle js-submenu-toggle"
                                    aria-expanded="{{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'true' : 'false' }}">

                                <span class="submenu-main">
                                    <i class="fa-solid fa-users-gear"></i>
                                    <span>{{ $m['users_access'] }}</span>
                                </span>

                                <i class="fa-solid fa-chevron-down submenu-arrow"></i>
                            </button>

                            <ul class="submenu nested-submenu">

                                @if($canUsersView && Route::has('users.index'))
                                    <li>
                                        <a href="{{ route('users.index') }}"
                                           class="submenu-link {{ request()->routeIs('users.index') ? 'active' : '' }}">

                                            <i class="fa-solid fa-users"></i>
                                            <span>{{ $m['users'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($canUsersCreate && Route::has('users.create'))
                                    <li>
                                        <a href="{{ route('users.create') }}"
                                           class="submenu-link {{ request()->routeIs('users.create') ? 'active' : '' }}">

                                            <i class="fa-solid fa-user-plus"></i>
                                            <span>{{ $m['create_user'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($canRolesView && Route::has('roles.index'))
                                    <li>
                                        <a href="{{ route('roles.index') }}"
                                           class="submenu-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">

                                            <i class="fa-solid fa-user-shield"></i>
                                            <span>{{ $m['roles'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($canRolesCreate && Route::has('roles.create'))
                                    <li>
                                        <a href="{{ route('roles.create') }}"
                                           class="submenu-link {{ request()->routeIs('roles.create') ? 'active' : '' }}">

                                            <i class="fa-solid fa-shield-halved"></i>
                                            <span>{{ $m['create_role'] }}</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif

                    @if($showOrganization)
                        <li class="sidebar-item has-submenu menu-level-2
                            {{ request()->routeIs('departments.*') || request()->routeIs('employees.*') ? 'open' : '' }}"
                            data-menu-key="admin-organization">

                            <button type="button"
                                    class="submenu-link submenu-toggle js-submenu-toggle"
                                    aria-expanded="{{ request()->routeIs('departments.*') || request()->routeIs('employees.*') ? 'true' : 'false' }}">

                                <span class="submenu-main">
                                    <i class="fa-solid fa-sitemap"></i>
                                    <span>{{ $m['organization'] }}</span>
                                </span>

                                <i class="fa-solid fa-chevron-down submenu-arrow"></i>
                            </button>

                            <ul class="submenu nested-submenu">

                                @if($canDepartmentsView && Route::has('departments.index'))
                                    <li>
                                        <a href="{{ route('departments.index') }}"
                                           class="submenu-link {{ request()->routeIs('departments.index') ? 'active' : '' }}">

                                            <i class="fa-solid fa-building"></i>
                                            <span>{{ $m['departments'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($canDepartmentsCreate && Route::has('departments.create'))
                                    <li>
                                        <a href="{{ route('departments.create') }}"
                                           class="submenu-link {{ request()->routeIs('departments.create') ? 'active' : '' }}">

                                            <i class="fa-solid fa-building-circle-check"></i>
                                            <span>{{ $m['create_department'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($canEmployeesView && Route::has('employees.index'))
                                    <li>
                                        <a href="{{ route('employees.index') }}"
                                           class="submenu-link {{ request()->routeIs('employees.index') ? 'active' : '' }}">

                                            <i class="fa-solid fa-id-badge"></i>
                                            <span>{{ $m['employees'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($canEmployeesCreate && Route::has('employees.create'))
                                    <li>
                                        <a href="{{ route('employees.create') }}"
                                           class="submenu-link {{ request()->routeIs('employees.create') ? 'active' : '' }}">

                                            <i class="fa-solid fa-user-tie"></i>
                                            <span>{{ $m['create_employee'] }}</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif

                </ul>
            </li>

            {{-- ========================================================= --}}
            {{-- 2. MANAGEMENT --}}
            {{-- ========================================================= --}}
            <li class="sidebar-item has-submenu menu-level-1 {{ $managementOpen ? 'open' : '' }}"
                data-menu-key="management">

                <button type="button"
                        class="sidebar-link js-main-menu-toggle"
                        data-tooltip="{{ $m['management'] }}"
                        aria-expanded="{{ $managementOpen ? 'true' : 'false' }}">

                    <span class="sidebar-link-main">
                        <span class="sidebar-icon">
                            <i class="fa-solid fa-briefcase"></i>
                        </span>

                        <span class="sidebar-text">{{ $m['management'] }}</span>
                    </span>

                    <span class="sidebar-arrow">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </button>

                <ul class="submenu">

                    @if($showCorrespondence)
                        <li class="sidebar-item has-submenu menu-level-2
                            {{ request()->routeIs('main')
                                || request()->routeIs('inbox.*')
                                || request()->routeIs('CorrespondenceManagement.outbox.*')
                                || request()->routeIs('documents.*') ? 'open' : '' }}"
                            data-menu-key="management-correspondence">

                            <button type="button"
                                    class="submenu-link submenu-toggle js-submenu-toggle"
                                    aria-expanded="{{ request()->routeIs('main')
                                        || request()->routeIs('inbox.*')
                                        || request()->routeIs('CorrespondenceManagement.outbox.*')
                                        || request()->routeIs('documents.*') ? 'true' : 'false' }}">

                                <span class="submenu-main">
                                    <i class="fa-solid fa-envelopes-bulk"></i>
                                    <span>{{ $m['correspondence'] }}</span>
                                </span>

                                <i class="fa-solid fa-chevron-down submenu-arrow"></i>
                            </button>

                            <ul class="submenu nested-submenu">

                                @if($canInboxView && Route::has('inbox.index'))
                                    <li>
                                        <a href="{{ route('inbox.index') }}"
                                           class="submenu-link {{ request()->routeIs('inbox.index') || request()->routeIs('inbox.show') || request()->routeIs('inbox.edit') ? 'active' : '' }}">

                                            <i class="fa-solid fa-inbox"></i>
                                            <span>{{ $m['incoming'] }}</span>
                                        </a>
                                    </li>
                                @elseif($canInboxView && Route::has('main'))
                                    <li>
                                        <a href="{{ route('main') }}"
                                           class="submenu-link {{ request()->routeIs('main') ? 'active' : '' }}">

                                            <i class="fa-solid fa-inbox"></i>
                                            <span>{{ $m['incoming'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($canInboxCreate && Route::has('inbox.create'))
                                    <li>
                                        <a href="{{ route('inbox.create') }}"
                                           class="submenu-link {{ request()->routeIs('inbox.create') ? 'active' : '' }}">

                                            <i class="fa-solid fa-file-circle-plus"></i>
                                            <span>{{ $m['create_incoming'] }}</span>
                                        </a>
                                    </li>
                                @elseif($canInboxCreate && Route::has('inbox.form'))
                                    <li>
                                        <a href="{{ route('inbox.form') }}"
                                           class="submenu-link {{ request()->routeIs('inbox.form') ? 'active' : '' }}">

                                            <i class="fa-solid fa-file-circle-plus"></i>
                                            <span>{{ $m['create_incoming'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($canOutboxView && Route::has('CorrespondenceManagement.outbox.index'))
                                    <li>
                                        <a href="{{ route('CorrespondenceManagement.outbox.index') }}"
                                           class="submenu-link {{ request()->routeIs('CorrespondenceManagement.outbox.index')
                                               || request()->routeIs('CorrespondenceManagement.outbox.show')
                                               || request()->routeIs('CorrespondenceManagement.outbox.edit') ? 'active' : '' }}">

                                            <i class="fa-solid fa-file-export"></i>
                                            <span>{{ $m['outgoing'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($canOutboxCreate && Route::has('CorrespondenceManagement.outbox.create'))
                                    <li>
                                        <a href="{{ route('CorrespondenceManagement.outbox.create') }}"
                                           class="submenu-link {{ request()->routeIs('CorrespondenceManagement.outbox.create') ? 'active' : '' }}">

                                            <i class="fa-solid fa-paper-plane"></i>
                                            <span>{{ $m['create_outgoing'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($canDocumentsView && Route::has('documents.index'))
                                    <li>
                                        <a href="{{ route('documents.index') }}"
                                           class="submenu-link {{ request()->routeIs('documents.*') ? 'active' : '' }}">

                                            <i class="fa-solid fa-folder-open"></i>
                                            <span>{{ $m['documents'] }}</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif

                    @if($showTasks)
                        <li class="sidebar-item has-submenu menu-level-2
                            {{ request()->routeIs('tasks.*') ? 'open' : '' }}"
                            data-menu-key="management-tasks">

                            <button type="button"
                                    class="submenu-link submenu-toggle js-submenu-toggle"
                                    aria-expanded="{{ request()->routeIs('tasks.*') ? 'true' : 'false' }}">

                                <span class="submenu-main">
                                    <i class="fa-solid fa-list-check"></i>
                                    <span>{{ $m['tasks'] }}</span>
                                </span>

                                <i class="fa-solid fa-chevron-down submenu-arrow"></i>
                            </button>

                            <ul class="submenu nested-submenu">

                                @if($canTasksView && Route::has('tasks.index'))
                                    <li>
                                        <a href="{{ route('tasks.index') }}"
                                           class="submenu-link {{ request()->routeIs('tasks.index') || request()->routeIs('tasks.show') || request()->routeIs('tasks.edit') ? 'active' : '' }}">

                                            <i class="fa-solid fa-list"></i>
                                            <span>{{ $m['all_tasks'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($canTasksCreate && Route::has('tasks.create'))
                                    <li>
                                        <a href="{{ route('tasks.create') }}"
                                           class="submenu-link {{ request()->routeIs('tasks.create') ? 'active' : '' }}">

                                            <i class="fa-solid fa-square-plus"></i>
                                            <span>{{ $m['create_task'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($canTasksCharts && Route::has('tasks.charts'))
                                    <li>
                                        <a href="{{ route('tasks.charts') }}"
                                           class="submenu-link {{ request()->routeIs('tasks.charts') ? 'active' : '' }}">

                                            <i class="fa-solid fa-chart-pie"></i>
                                            <span>{{ $m['charts'] }}</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif

                    @if($showWorkflow)
                        <li class="sidebar-item has-submenu menu-level-2
                            {{ request()->routeIs('workflows.*') ? 'open' : '' }}"
                            data-menu-key="management-workflow">

                            <button type="button"
                                    class="submenu-link submenu-toggle js-submenu-toggle"
                                    aria-expanded="{{ request()->routeIs('workflows.*') ? 'true' : 'false' }}">

                                <span class="submenu-main">
                                    <i class="fa-solid fa-diagram-project"></i>
                                    <span>{{ $m['workflow'] }}</span>
                                </span>

                                <i class="fa-solid fa-chevron-down submenu-arrow"></i>
                            </button>

                            <ul class="submenu nested-submenu">

                                @if(Route::has('workflows.index'))
                                    <li>
                                        <a href="{{ route('workflows.index') }}"
                                           class="submenu-link {{ request()->routeIs('workflows.index') ? 'active' : '' }}">

                                            <i class="fa-solid fa-list-ul"></i>
                                            <span>{{ $m['all_workflows'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if(Route::has('workflows.pending'))
                                    <li>
                                        <a href="{{ route('workflows.pending') }}"
                                           class="submenu-link {{ request()->routeIs('workflows.pending') ? 'active' : '' }}">

                                            <i class="fa-solid fa-hourglass-half"></i>
                                            <span>{{ $m['pending'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if(Route::has('workflows.sent'))
                                    <li>
                                        <a href="{{ route('workflows.sent') }}"
                                           class="submenu-link {{ request()->routeIs('workflows.sent') ? 'active' : '' }}">

                                            <i class="fa-solid fa-share-from-square"></i>
                                            <span>{{ $m['sent'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if(Route::has('workflows.create'))
                                    <li>
                                        <a href="{{ route('workflows.create') }}"
                                           class="submenu-link {{ request()->routeIs('workflows.create') ? 'active' : '' }}">

                                            <i class="fa-solid fa-circle-plus"></i>
                                            <span>{{ $m['create_workflow'] }}</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif

                    @if(Route::has('tracking.index'))
                        <li>
                            <a href="{{ route('tracking.index') }}"
                               class="submenu-link {{ request()->routeIs('tracking.*') ? 'active' : '' }}">

                                <i class="fa-solid fa-location-crosshairs"></i>
                                <span>{{ $m['tracking'] }}</span>
                            </a>
                        </li>
                    @endif

                    @if($showBudgetCoordination)
                        @php
                            $budgetCoordinationOpen = request()->routeIs(
                                'budget-entities.*',
                                'focal-points.*',
                                'focal-point-introductions.*',
                                'focal-point-cards.*',
                                'focal-point-card-verification.*',
                                'focal-point-reports.*'
                            );
                        @endphp

                        <li class="sidebar-item has-submenu menu-level-2
                            {{ $budgetCoordinationOpen ? 'open' : '' }}"
                            data-menu-key="management-budget-coordination">

                            <button type="button"
                                    class="submenu-link submenu-toggle js-submenu-toggle"
                                    aria-expanded="{{ $budgetCoordinationOpen ? 'true' : 'false' }}">

                                <span class="submenu-main">
                                    <i class="fa-solid fa-address-card"></i>
                                    <span>{{ $m['budget_coordination'] }}</span>
                                </span>

                                <i class="fa-solid fa-chevron-down submenu-arrow"></i>
                            </button>

                            <ul class="submenu nested-submenu">

                                @if(Route::has('budget-entities.index'))
                                    <li>
                                        <a href="{{ route('budget-entities.index') }}"
                                           class="submenu-link {{ request()->routeIs('budget-entities.*') ? 'active' : '' }}">
                                            <i class="fa-solid fa-landmark"></i>
                                            <span>{{ $m['budget_entities'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if(Route::has('focal-points.index'))
                                    <li>
                                        <a href="{{ route('focal-points.index') }}"
                                           class="submenu-link {{ request()->routeIs('focal-points.*') ? 'active' : '' }}">
                                            <i class="fa-solid fa-user-check"></i>
                                            <span>{{ $m['focal_points'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if(Route::has('focal-point-introductions.index'))
                                    <li>
                                        <a href="{{ route('focal-point-introductions.index') }}"
                                           class="submenu-link {{ request()->routeIs('focal-point-introductions.*') ? 'active' : '' }}">
                                            <i class="fa-solid fa-envelope-open-text"></i>
                                            <span>{{ $m['introduction_letters'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if(Route::has('focal-point-cards.issue.index') || Route::has('focal-point-cards.index'))
                                    <li>
                                        <a href="{{ Route::has('focal-point-cards.issue.index')
                                                ? route('focal-point-cards.issue.index')
                                                : route('focal-point-cards.index', ['status' => 'approved']) }}"
                                           class="submenu-link {{ request()->routeIs('focal-point-cards.issue.*')
                                                || (request()->routeIs('focal-point-cards.index') && request('status') === 'approved')
                                                    ? 'active'
                                                    : '' }}">
                                            <i class="fa-solid fa-print"></i>
                                            <span>{{ $m['card_issuance'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if(Route::has('focal-point-cards.index'))
                                    <li>
                                        <a href="{{ route('focal-point-cards.index', ['status' => 'issued']) }}"
                                           class="submenu-link {{ request()->routeIs('focal-point-cards.index')
                                                && request('status') === 'issued' ? 'active' : '' }}">
                                            <i class="fa-solid fa-id-card-clip"></i>
                                            <span>{{ $m['issued_cards'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($cardVerificationRoute)
                                    <li>
                                        <a href="{{ $cardVerificationRoute }}"
                                           class="submenu-link {{ request()->routeIs('focal-point-card-verification.*')
                                                || request()->routeIs('focal-point-cards.verification.*') ? 'active' : '' }}">
                                            <i class="fa-solid fa-qrcode"></i>
                                            <span>{{ $m['card_verification'] }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if(Route::has('focal-point-reports.index'))
                                    <li>
                                        <a href="{{ route('focal-point-reports.index') }}"
                                           class="submenu-link {{ request()->routeIs('focal-point-reports.*') ? 'active' : '' }}">
                                            <i class="fa-solid fa-chart-column"></i>
                                            <span>{{ $m['focal_point_reports'] }}</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif

                </ul>
            </li>

            {{-- ========================================================= --}}
            {{-- 3. AUDIT --}}
            {{-- ========================================================= --}}
            <li class="sidebar-item has-submenu menu-level-1 {{ $auditOpen ? 'open' : '' }}"
                data-menu-key="audit">

                <button type="button"
                        class="sidebar-link js-main-menu-toggle"
                        data-tooltip="{{ $m['audit'] }}"
                        aria-expanded="{{ $auditOpen ? 'true' : 'false' }}">

                    <span class="sidebar-link-main">
                        <span class="sidebar-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </span>

                        <span class="sidebar-text">{{ $m['audit'] }}</span>
                    </span>

                    <span class="sidebar-arrow">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </button>

                <ul class="submenu">

                    @if(Route::has('audit.index'))
                        <li>
                            <a href="{{ route('audit.index') }}"
                               class="submenu-link {{ request()->routeIs('audit.*') || request()->routeIs('audit-logs.*') ? 'active' : '' }}">

                                <i class="fa-solid fa-clipboard-list"></i>
                                <span>{{ $m['audit_logs'] }}</span>
                            </a>
                        </li>
                    @endif

                    @if(Route::has('notifications'))
                        <li>
                            <a href="{{ route('notifications') }}"
                               class="submenu-link {{ request()->routeIs('notifications') ? 'active' : '' }}">

                                <i class="fa-solid fa-bell"></i>
                                <span>{{ $m['notifications'] }}</span>
                            </a>
                        </li>
                    @elseif(Route::has('notifications.index'))
                        <li>
                            <a href="{{ route('notifications.index') }}"
                               class="submenu-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">

                                <i class="fa-solid fa-bell"></i>
                                <span>{{ $m['notifications'] }}</span>
                            </a>
                        </li>
                    @endif

                    @if(Route::has('audit.reports'))
                        <li>
                            <a href="{{ route('audit.reports') }}"
                               class="submenu-link {{ request()->routeIs('audit.reports') ? 'active' : '' }}">

                                <i class="fa-solid fa-chart-column"></i>
                                <span>{{ $m['audit_reports'] }}</span>
                            </a>
                        </li>
                    @endif

                </ul>
            </li>

            {{-- ========================================================= --}}
            {{-- 4. SETTINGS --}}
            {{-- ========================================================= --}}
            <li class="sidebar-item has-submenu menu-level-1 {{ $settingsOpen ? 'open' : '' }}"
                data-menu-key="settings">

                <button type="button"
                        class="sidebar-link js-main-menu-toggle"
                        data-tooltip="{{ $m['settings'] }}"
                        aria-expanded="{{ $settingsOpen ? 'true' : 'false' }}">

                    <span class="sidebar-link-main">
                        <span class="sidebar-icon">
                            <i class="fa-solid fa-gears"></i>
                        </span>

                        <span class="sidebar-text">{{ $m['settings'] }}</span>
                    </span>

                    <span class="sidebar-arrow">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </button>

                <ul class="submenu">

                    @if($canSettingsView && Route::has('admin.settings'))
                        <li>
                            <a href="{{ route('admin.settings') }}"
                               class="submenu-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">

                                <i class="fa-solid fa-sliders"></i>
                                <span>{{ $m['system_settings'] }}</span>
                            </a>
                        </li>
                    @endif

                    @if(Route::has('profile.edit'))
                        <li>
                            <a href="{{ route('profile.edit') }}"
                               class="submenu-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">

                                <i class="fa-solid fa-user-pen"></i>
                                <span>{{ $m['profile'] }}</span>
                            </a>
                        </li>
                    @endif

                </ul>
            </li>

        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="user-mini">
            <div class="user-mini-avatar">
                <i class="fa-solid fa-user"></i>
            </div>

            <div class="user-mini-info">
                <div class="user-mini-name">
                    {{ auth()->user()->name ?? 'User' }}
                </div>

                <div class="user-mini-role">
                    {{ $m['logged_in'] }}
                </div>
            </div>
        </div>
    </div>
</aside>

<div class="sidebar-tooltip" id="sidebarTooltip"></div>

<div class="main-wrapper" id="mainWrapper">

    <header class="topbar">

        <div class="topbar-left">
            <button class="top-icon-btn d-lg-none"
                    type="button"
                    id="mobileSidebarToggle"
                    aria-label="Open navigation">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="topbar-heading">
                <h4 class="topbar-title">
                    @hasSection('page_title')
                        @yield('page_title')
                    @else
                        @hasSection('title')
                            @yield('title')
                        @else
                            {{ $m['dashboard'] }}
                        @endif
                    @endif
                </h4>

                <div class="topbar-subtitle">
                    {{ now()->format('Y-m-d') }}
                </div>
            </div>
        </div>

        <div class="topbar-right">

            <div class="smart-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search"
                       id="globalSidebarSearch"
                       autocomplete="off"
                       placeholder="{{ $m['search'] }}">
            </div>

            {{-- Language --}}
            @if(Route::has('language.switch'))
                <div class="dropdown">
                    <button class="top-dropdown-btn dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                        <i class="fa-solid fa-language"></i>
                        <span class="language-label">{{ strtoupper($locale) }}</span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <button type="button"
                                    class="dropdown-item lang-option"
                                    data-lang="en">
                                English
                            </button>
                        </li>

                        <li>
                            <button type="button"
                                    class="dropdown-item lang-option"
                                    data-lang="ps">
                                پښتو
                            </button>
                        </li>

                        <li>
                            <button type="button"
                                    class="dropdown-item lang-option"
                                    data-lang="fa">
                                دری
                            </button>
                        </li>
                    </ul>
                </div>
            @endif

            {{-- Notifications --}}
            @if(Route::has('notifications'))
                <a href="{{ route('notifications') }}"
                   class="top-icon-btn notification-link"
                   title="{{ $m['notifications'] }}">

                    <i class="fa-solid fa-bell"></i>

                    @if($unreadNotifications > 0)
                        <span class="notification-badge">
                            {{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}
                        </span>
                    @endif
                </a>
            @elseif(Route::has('notifications.index'))
                <a href="{{ route('notifications.index') }}"
                   class="top-icon-btn notification-link"
                   title="{{ $m['notifications'] }}">

                    <i class="fa-solid fa-bell"></i>

                    @if($unreadNotifications > 0)
                        <span class="notification-badge">
                            {{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}
                        </span>
                    @endif
                </a>
            @endif

            {{-- User --}}
            <div class="dropdown">
                <button class="top-dropdown-btn dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                    <i class="fa-solid fa-circle-user"></i>

                    <span class="topbar-user-name">
                        {{ auth()->user()->name ?? 'User' }}
                    </span>
                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    @if(Route::has('profile.edit'))
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fa-solid fa-user-pen me-2"></i>
                                {{ $m['profile'] }}
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @endif

                    @if(Route::has('logout'))
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i>
                                    {{ $m['logout'] }}
                                </button>
                            </form>
                        </li>
                    @endif

                </ul>
            </div>

        </div>
    </header>

    <main class="content-area">
        @yield('content')
    </main>
</div>

@if(Route::has('language.switch'))
    <form id="language-switch-form"
          method="POST"
          action="{{ route('language.switch') }}"
          style="display: none;">

        @csrf

        <input type="hidden"
               name="locale"
               id="language-switch-locale">

        <input type="hidden"
               name="redirect_to"
               id="language-switch-redirect"
               value="{{ url()->full() }}">
    </form>
@endif

{{-- Local JavaScript files: loaded once --}}
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/chart.umd.min.js') }}"></script>
<script src="{{ asset('js/persian-date.min.js') }}"></script>
<script src="{{ asset('js/persian-datepicker.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const sidebar = document.getElementById('sidebar');
    const mainWrapper = document.getElementById('mainWrapper');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarToggleIcon = document.getElementById('sidebarToggleIcon');
    const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const tooltip = document.getElementById('sidebarTooltip');
    const sidebarSearch = document.getElementById('globalSidebarSearch');

    const SIDEBAR_STATE_KEY = 'emis_sidebar_collapsed';
    const SIDEBAR_OPEN_KEY = 'emis_sidebar_open_keys';

    function isRtl() {
        return document.documentElement.dir === 'rtl';
    }

    function updateToggleIcon() {
        if (!sidebarToggleIcon || !sidebar) {
            return;
        }

        const collapsed = sidebar.classList.contains('collapsed');

        if (isRtl()) {
            sidebarToggleIcon.className = collapsed
                ? 'fa-solid fa-angles-left'
                : 'fa-solid fa-angles-right';
        } else {
            sidebarToggleIcon.className = collapsed
                ? 'fa-solid fa-angles-right'
                : 'fa-solid fa-angles-left';
        }
    }

    function setSidebarCollapsed(collapsed) {
        if (!sidebar || !mainWrapper) {
            return;
        }

        sidebar.classList.toggle('collapsed', collapsed);
        mainWrapper.classList.toggle('expanded', collapsed);

        localStorage.setItem(
            SIDEBAR_STATE_KEY,
            collapsed ? '1' : '0'
        );

        updateToggleIcon();
    }

    function applySavedSidebarState() {
        if (window.innerWidth <= 991 || !sidebar) {
            return;
        }

        const collapsed = localStorage.getItem(SIDEBAR_STATE_KEY) === '1';
        setSidebarCollapsed(collapsed);
    }

    function getOpenMenuKeys() {
        try {
            return JSON.parse(
                localStorage.getItem(SIDEBAR_OPEN_KEY)
            ) || [];
        } catch (error) {
            return [];
        }
    }

    function saveOpenMenuKeys() {
        const keys = [];

        document.querySelectorAll(
            '.sidebar-item[data-menu-key].open'
        ).forEach(function (item) {
            keys.push(item.dataset.menuKey);
        });

        localStorage.setItem(
            SIDEBAR_OPEN_KEY,
            JSON.stringify(keys)
        );
    }

    function syncAriaExpanded(item) {
        if (!item) {
            return;
        }

        const directToggle = item.querySelector(
            ':scope > .js-main-menu-toggle, :scope > .js-submenu-toggle'
        );

        if (directToggle) {
            directToggle.setAttribute(
                'aria-expanded',
                item.classList.contains('open') ? 'true' : 'false'
            );
        }
    }

    function closeMainSectionsExcept(currentItem) {
        document.querySelectorAll('.menu-level-1.open').forEach(function (item) {
            if (item !== currentItem) {
                item.classList.remove('open');
                syncAriaExpanded(item);
            }
        });
    }

    function restoreOpenMenuState() {
        const storedKeys = getOpenMenuKeys();
        const serverOpenMain = document.querySelector('.menu-level-1.open');

        if (!serverOpenMain) {
            const storedMainKey = storedKeys.find(function (key) {
                const candidate = document.querySelector(
                    '.menu-level-1[data-menu-key="' + CSS.escape(key) + '"]'
                );

                return Boolean(candidate);
            });

            if (storedMainKey) {
                const mainItem = document.querySelector(
                    '.menu-level-1[data-menu-key="' + CSS.escape(storedMainKey) + '"]'
                );

                if (mainItem) {
                    mainItem.classList.add('open');
                    syncAriaExpanded(mainItem);
                }
            }
        }

        storedKeys.forEach(function (key) {
            const nestedItem = document.querySelector(
                '.menu-level-2[data-menu-key="' + CSS.escape(key) + '"]'
            );

            if (nestedItem) {
                nestedItem.classList.add('open');
                syncAriaExpanded(nestedItem);
            }
        });
    }

    function openMobileSidebar() {
        if (!sidebar || !sidebarOverlay) {
            return;
        }

        sidebar.classList.add('mobile-open');
        sidebarOverlay.classList.add('show');
        document.body.classList.add('sidebar-mobile-active');
    }

    function closeMobileSidebar() {
        if (!sidebar || !sidebarOverlay) {
            return;
        }

        sidebar.classList.remove('mobile-open');
        sidebarOverlay.classList.remove('show');
        document.body.classList.remove('sidebar-mobile-active');
    }

    sidebarToggle?.addEventListener('click', function () {
        if (window.innerWidth <= 991) {
            if (sidebar.classList.contains('mobile-open')) {
                closeMobileSidebar();
            } else {
                openMobileSidebar();
            }

            return;
        }

        setSidebarCollapsed(
            !sidebar.classList.contains('collapsed')
        );
    });

    mobileSidebarToggle?.addEventListener('click', openMobileSidebar);
    sidebarOverlay?.addEventListener('click', closeMobileSidebar);

    document.querySelectorAll('.js-main-menu-toggle').forEach(function (toggle) {
        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            if (sidebar?.classList.contains('collapsed') && window.innerWidth > 991) {
                setSidebarCollapsed(false);
            }

            const item = toggle.closest('.menu-level-1');

            if (!item) {
                return;
            }

            const shouldOpen = !item.classList.contains('open');

            closeMainSectionsExcept(item);
            item.classList.toggle('open', shouldOpen);
            syncAriaExpanded(item);
            saveOpenMenuKeys();
        });
    });

    document.querySelectorAll('.js-submenu-toggle').forEach(function (toggle) {
        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            const item = toggle.closest('.menu-level-2');

            if (!item) {
                return;
            }

            item.classList.toggle('open');
            syncAriaExpanded(item);
            saveOpenMenuKeys();
        });
    });

    document.querySelectorAll('.sidebar a[href]').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 991) {
                closeMobileSidebar();
            }
        });
    });

    function showTooltip(text, rect) {
        if (
            !tooltip ||
            !sidebar ||
            !sidebar.classList.contains('collapsed') ||
            window.innerWidth <= 991 ||
            !text
        ) {
            if (tooltip) {
                tooltip.style.opacity = '0';
            }

            return;
        }

        tooltip.textContent = text;
        tooltip.style.top = (rect.top + rect.height / 2) + 'px';
        tooltip.style.left = '';
        tooltip.style.right = '';

        if (isRtl()) {
            tooltip.style.right = (window.innerWidth - rect.left + 12) + 'px';
        } else {
            tooltip.style.left = (rect.right + 12) + 'px';
        }

        tooltip.style.opacity = '1';
    }

    function hideTooltip() {
        if (tooltip) {
            tooltip.style.opacity = '0';
        }
    }

    document.querySelectorAll('.sidebar-link[data-tooltip]').forEach(function (link) {
        link.addEventListener('mouseenter', function () {
            showTooltip(
                link.dataset.tooltip,
                link.getBoundingClientRect()
            );
        });

        link.addEventListener('mouseleave', hideTooltip);
    });

    sidebar?.addEventListener('mouseleave', hideTooltip);

    /*
    |--------------------------------------------------------------------------
    | Sidebar search
    |--------------------------------------------------------------------------
    | Filters visible menu links. It does not perform a database search.
    */

    sidebarSearch?.addEventListener('input', function () {
        const query = sidebarSearch.value.trim().toLocaleLowerCase();

        document.querySelectorAll('.sidebar-item').forEach(function (item) {
            item.style.display = '';
        });

        if (!query) {
            return;
        }

        if (sidebar?.classList.contains('collapsed') && window.innerWidth > 991) {
            setSidebarCollapsed(false);
        }

        document.querySelectorAll('.menu-level-2').forEach(function (item) {
            const text = item.textContent.toLocaleLowerCase();
            const matches = text.includes(query);

            item.style.display = matches ? '' : 'none';

            if (matches) {
                item.classList.add('open');

                const parentMain = item.closest('.menu-level-1');

                if (parentMain) {
                    parentMain.classList.add('open');
                    syncAriaExpanded(parentMain);
                }

                syncAriaExpanded(item);
            }
        });

        document.querySelectorAll(
            '.menu-level-1 > .submenu > li:not(.menu-level-2)'
        ).forEach(function (item) {
            const text = item.textContent.toLocaleLowerCase();
            item.style.display = text.includes(query) ? '' : 'none';
        });

        document.querySelectorAll('.menu-level-1').forEach(function (mainItem) {
            const visibleChild = Array.from(
                mainItem.querySelectorAll(':scope > .submenu > li')
            ).some(function (child) {
                return child.style.display !== 'none';
            });

            mainItem.style.display = visibleChild ? '' : 'none';
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Language switching
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.lang-option').forEach(function (button) {
        button.addEventListener('click', function () {
            const form = document.getElementById('language-switch-form');
            const localeInput = document.getElementById('language-switch-locale');
            const redirectInput = document.getElementById('language-switch-redirect');

            if (!form || !localeInput || !redirectInput) {
                return;
            }

            localeInput.value = button.dataset.lang;
            redirectInput.value = window.location.href;
            form.submit();
        });
    });

    /*
    |--------------------------------------------------------------------------
    | SweetAlert messages
    |--------------------------------------------------------------------------
    */

    @if(session('success'))
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: @json($m['success']),
                text: @json(session('success')),
                timer: 2500,
                showConfirmButton: false
            });
        }
    @endif

    @if(session('error'))
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: @json($m['error']),
                text: @json(session('error'))
            });
        }
    @endif

    @if(session('warning'))
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: @json($m['warning']),
                text: @json(session('warning'))
            });
        }
    @endif

    @if($errors->any())
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: @json($m['validation_error']),
                html: @json(implode('<br>', $errors->all()))
            });
        }
    @endif

    window.confirmDelete = function (formId) {
        const form = document.getElementById(formId);

        if (!form) {
            return false;
        }

        if (typeof Swal === 'undefined') {
            if (window.confirm(@json($m['are_you_sure']))) {
                form.submit();
            }

            return false;
        }

        Swal.fire({
            title: @json($m['are_you_sure']),
            text: @json($m['cannot_undo']),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: @json($m['yes_delete']),
            cancelButtonText: @json($m['cancel'])
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });

        return false;
    };

    /*
    |--------------------------------------------------------------------------
    | Initial state and resize
    |--------------------------------------------------------------------------
    */

    applySavedSidebarState();
    restoreOpenMenuState();
    updateToggleIcon();

    window.addEventListener('resize', function () {
        hideTooltip();

        if (window.innerWidth > 991) {
            closeMobileSidebar();
            applySavedSidebarState();
        } else {
            sidebar?.classList.remove('collapsed');
            mainWrapper?.classList.remove('expanded');
        }
    });
});
</script>

@stack('scripts')

</body>
</html>