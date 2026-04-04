
@extends('new')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'EMIS') }}</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fb;
            font-size: 14px;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: #1f2937;
            color: #fff;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 20px;
            z-index: 1000;
        }

        .sidebar .brand {
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            padding: 10px 20px 25px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 10px;
        }

        .sidebar .nav-link {
            color: #d1d5db;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #374151;
            color: #fff;
        }

        .content-area {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
        }

        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 15px 25px;
        }

        .page-content {
            padding: 25px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .navbar-user {
            font-weight: 500;
        }

        .sidebar-section-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #9ca3af;
            padding: 15px 20px 5px;
            letter-spacing: 0.5px;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .content-area {
                margin-left: 0;
                width: 100%;
            }

            .main-wrapper {
                flex-direction: column;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="main-wrapper">

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="brand">
            <i class="bi bi-diagram-3-fill"></i> EMIS
        </div>

        <div class="sidebar-section-title">Main</div>

        <nav class="nav flex-column px-2">
            <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <a href="#" class="nav-link {{ request()->is('employees*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Employees</span>
            </a>

            <a href="#" class="nav-link {{ request()->is('departments*') ? 'active' : '' }}">
                <i class="bi bi-diagram-2-fill"></i>
                <span>Departments</span>
            </a>

            <a href="#" class="nav-link {{ request()->is('positions*') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill"></i>
                <span>Positions</span>
            </a>
        </nav>

        <div class="sidebar-section-title">Operations</div>

        <nav class="nav flex-column px-2">
            <a href="#" class="nav-link {{ request()->is('correspondences*') ? 'active' : '' }}">
                <i class="bi bi-envelope-paper-fill"></i>
                <span>Correspondence</span>
            </a>

            <a href="#" class="nav-link {{ request()->is('tasks*') ? 'active' : '' }}">
                <i class="bi bi-list-check"></i>
                <span>Tasks</span>
            </a>

            <a href="#" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-fill"></i>
                <span>Reports</span>
            </a>
        </nav>

        <div class="sidebar-section-title">Settings</div>

        <nav class="nav flex-column px-2">
            <a href="#" class="nav-link">
                <i class="bi bi-gear-fill"></i>
                <span>System Settings</span>
            </a>
        </nav>
    </aside>

    {{-- Content Area --}}
    <div class="content-area">

        {{-- Topbar --}}
        <header class="topbar d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">@yield('page_title', 'Executive Management Information System')</h5>
                <small class="text-muted">@yield('page_subtitle', 'National Budget Directorate')</small>
            </div>

            <div class="dropdown">
                <a class="btn btn-light dropdown-toggle navbar-user" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                    {{ auth()->user()->name ?? 'User' }}
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-key"></i> Change Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        {{-- Main Page Content --}}
        <main class="page-content">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Error Message --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
@endsection