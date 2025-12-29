<!DOCTYPE html>
<html lang="ps" dir="rtl">
<head>

<!-- ================== CSS & JS (SAME AS YOUR PAGE) ================== -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<meta charset="UTF-8">
<title>EMIS | ډشبورډ</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- ================== RTL FIXES ================== -->
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

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    body {
        background: #f4f6f9;
        direction: rtl;
        text-align: right;
    }

    /* Sidebar */
    .sidebar {
        width: 200px;
        height: 100%;
        background: #081e51ff;
        color: #fff;
        position: fixed;
        display: flex;
        flex-direction: column;
        top: 0;
        right: 0;          /* RTL */
        bottom: 0;
        z-index: 1000;
        overflow: auto;
        box-shadow: -2px 0 5px rgba(255, 252, 252, 0.98); /* RTL shadow */
    }

    .sidebar.collapsed {
        width: 70px;
        border-radius: 10px;
    }

    /* Header */
    .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0px;
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
        font-size: 14px;
        cursor: pointer;
    }

    /* Menu */
    .menu {
        list-style: none;
        padding: 8px;
        flex-grow: 3;
        overflow-y: auto;
        max-height: calc(100vh - 130px);
    }

    .menu li {
        margin-bottom: 8px;
    }

    .menu a {
        display: flex;
        align-items: center;
        gap: 14px;
        color: #fbfdffff;
        padding: 5px 15px;
        font-size: 14px;
        text-decoration: none;
        border-radius: 2px;
        position: relative;
        transition: 0.3s;

        /* RTL border */
        border-right: 5px solid transparent;
    }

    .menu a:hover {
        background: #c76c05ff;
        color: #fbfdffff;
        border-right: 4px solid #0b8bf4ff; /* RTL */
    }

    .menu span {
        white-space: nowrap;
    }

    .sidebar.collapsed .menu span,
    .sidebar.collapsed .arrow {
        display: none;
    }

    /* Tooltip when collapsed */
    .sidebar.collapsed .menu a::after {
        content: attr(data-title);
        position: absolute;
        right: 90px; /* RTL */
        background: #1e293b;
        color: #fff;
        padding: 5px;
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
        padding-right: 22px; /* RTL */
        display: none;
        flex-direction: column;
    }

    .has-sub.active .sub-menu {
        display: block;
        padding-right: 5px;
        background: #02121f86;
        border-radius: 4px;
        margin: 1px 0;
    }

    .sub-menu a {
        font-size: 12px;
        font-weight: bold;
        padding: 8px 12px;
        color: #cbd5e1;
    }

    /* Footer */
    .sidebar-footer {
        border-top: 1px solid #1e293b;
        background: #131314ff;
        height: 20px;
        display: flex;
        align-items: center;
        padding-bottom: 1px;
        transition: 0.3s;
    }

    .user-info {
        height: 20px;
        display: flex;
        align-items: center;
        padding-right: 5px; /* RTL */
    }

    .user-info img {
        border-radius: 50%;
        width: 40px;
        height: 40px;
    }

    .sidebar.collapsed .user-info div {
        display: none;
    }

    /* Page Content */
    .content {
        margin-right: 200px; /* RTL */
        padding: 15px;
        transition: 0.3s;
    }

    .sidebar.collapsed ~ .content {
        margin-right: 70px;
    }
</style>



</head>
<body>

<!-- ================== SIDEBAR ================== -->
<div class="sidebar" id="sidebar">

<button class="toggle-btn" onclick="toggleSidebar()">
<i class="fa-solid fa-bars"></i>
</button>

<div class="sidebar-header text-center">
<img src="/images/45.png" width="36">
<span class="logo-text">EMIS</span>
</div>

<ul class="menu">

<li>
<i class="fa-solid fa-house"></i>
<span>ډشبورډ</span>
</a>
</li>

<li class="has-sub">
<a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="مدیریت">
<i class="fa-solid fa-folder"></i>
<span>مدیریت</span>
<i class="fa-solid fa-chevron-down arrow"></i>
</a>
<ul class="sub-menu">
<li><a href="{{ route('Administrations.create') }}"><i class="fa-solid fa-users"></i> د کاروونکو جوړول</a></li>
<li><a href="{{ route('Administrations.Roles') }}"><i class="fa-solid fa-user-tag"></i> رولونه</a></li>
<li><a href="{{ route('Administrations.login') }}"><i class="fa-solid fa-right-to-bracket"></i> ننوتل</a></li>
<li><a href="{{ route('Administrations.Role Management') }}"><i class="fa-solid fa-user-check"></i> د رول مدیریت</a></li>
<li><a href="{{ route('Administrations.User Management') }}"><i class="fa-solid fa-user-friends"></i> د کاروونکو مدیریت</a></li>
<li><a href="#"><i class="fa-solid fa-user-shield"></i> صلاحیتونه</a></li>
</ul>
</li>

<li class="has-sub">
<a href="javascript:void(0)" onclick="toggleSubMenu(this)" data-title="دندو مدیریت">
<i class="fa-solid fa-tasks"></i>
<span>دندو مدیریت</span>
<i class="fa-solid fa-chevron-down arrow"></i>
</a>
<ul class="sub-menu">
<li><a href="{{ route('inbox.index') }}"><i class="fa-solid fa-inbox"></i> انباکس</a></li>
</ul>
</li>

<li>
<a href="#" data-title="تحلیل">
<i class="fa-solid fa-chart-line"></i>
<span>تحلیلات</span>
</a>
</li>

<li>
<a href="#" data-title="راپورونه">
<i class="fa-solid fa-chart-bar"></i>
<span>راپورونه</span>
</a>
</li>

<li>
<a href="{{ route('admin.settings') }}" data-title="تنظیمات">
<i class="fa-solid fa-gear"></i>
<span>تنظیمات</span>
</a>
</li>

</ul>

<!-- USER -->
<a href="#" data-bs-toggle="modal" data-bs-target="#settingsModal"
   style="text-decoration:none;color:#fff">
<div class="user-info">
<img src="/images/logo.png">
<div>
<strong>{{ Auth::user()->name ?? 'کارن' }}</strong>
<small>ننوتلی کارن</small>
</div>
</div>
</a>

</div>

<!-- ================== TOP NAVBAR ================== -->
<div class="top-navbar">

<div class="nav-right">

<div class="nav-search">
<i class="fa-solid fa-magnifying-glass"></i>
<input type="text" placeholder="په EMIS کې لټون...">
</div>

<div class="nav-item dropdown">
<i class="fa-solid fa-globe"></i>
<div class="dropdown-menu">
<a href="#">English</a>
<a href="{{ route('lang.ps') }}">پښتو</a>
<a href="{{ route('lang.fa') }}">دری</a>
</div>
</div>

<div class="nav-item dropdown">
<i class="fa-solid fa-bell"></i>
<span class="badge">4</span>
<div class="dropdown-menu">
<p class="dropdown-title">خبرتیاوې</p>
<a href="#">📊 نوی راپور جوړ شو</a>
<a href="#">👤 نوی کارن اضافه شو</a>
<a href="#">⚠ د بودیجې خبرتیا</a>
</div>
</div>

</div>
</div>

<!-- ================== CONTENT ================== -->
<main class="content mt-5">
@yield('content')
</main>

<!-- ================== SETTINGS MODAL ================== -->
<div class="modal fade" id="settingsModal">
<div class="modal-dialog modal-dialog-bottom-left">
<div class="modal-content p-4 text-center">

<h5>تنظیمات</h5>

<a href="{{ route('admin.settings') }}" class="btn btn-outline-dark w-100 mb-2">
<i class="fa-solid fa-gear"></i> تنظیمات
</a>

<form method="POST" action="#">
@csrf
<button class="btn btn-outline-danger w-100">
<i class="fa-solid fa-right-from-bracket"></i> وتل
</button>
</form>

</div>
</div>
</div>

<!-- ================== JS ================== -->
<script>
function toggleSidebar(){
document.getElementById('sidebar').classList.toggle('collapsed')
}
function toggleSubMenu(el){
el.parentElement.classList.toggle('active')
}
</script>

</body>
</html>
