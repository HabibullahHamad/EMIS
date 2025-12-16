<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>EMIS Sidebar</title>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* ===== RESET ===== */
* { margin: 0; padding: 0; box-sizing: border-box; }

/* ===== SIDEBAR ===== */
body {
    display: flex;
    background: #e5e7eb;
    font-family: 'Segoe UI', sans-serif;
}

.sidebar {
    width: 260px;
    height: 100vh;
    background: linear-gradient(180deg, #0f172a, #020617);
    color: #fff;
    position: fixed;
    transition: 0.3s;
}

.sidebar.collapsed {
    width: 70px;
}

/* ===== HEADER ===== */
.sidebar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px;
}

.logo {
    font-size: 20px;
    font-weight: bold;
}

.toggle {
    cursor: pointer;
    font-size: 20px;
}

/* ===== MENU ===== */
.menu {
    list-style: none;
    padding-top: 10px;
}

.menu-title {
    padding: 10px 20px;
    font-size: 11px;
    opacity: 0.5;
    text-transform: uppercase;
}

.sidebar.collapsed .menu-title,
.sidebar.collapsed .logo {
    display: none;
}

.menu li {
    position: relative;
}

.menu a {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 20px;
    color: #cbd5f5;
    text-decoration: none;
    transition: 0.2s;
}

.menu a i {
    font-size: 18px;
    min-width: 20px;
}

.menu a:hover {
    background: rgba(255,255,255,0.08);
    color: #fff;
}

/* ===== ACTIVE ===== */
.menu li.active a {
    background: rgba(99,102,241,0.25);
    border-left: 3px solid #6366f1;
}

/* ===== COLLAPSED ===== */
.sidebar.collapsed .menu a span {
    display: none;
}

/* ===== TOOLTIP ===== */
.tooltip {
    position: absolute;
    left: 75px;
    background: #111827;
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: 0.2s;
}

.sidebar.collapsed li:hover .tooltip {
    opacity: 1;
}

/* ===== CONTENT ===== */
.content {
    margin-left: 260px;
    padding: 20px;
    width: 100%;
    transition: 0.3s;
}

.sidebar.collapsed ~ .content {
    margin-left: 70px;
}
</style>
</head>

<body>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar" id="sidebar">

    <div class="sidebar-header">
        <span class="logo">EMIS</span>
        <i class="bi bi-list toggle" onclick="toggleSidebar()"></i>
    </div>
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
        <img class="avatar" src="https://via.placeholder.com/80" alt="avatar">
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
    <ul class="menu">

        <li class="menu-title">Main</li>

        <li class="active">
            <a href="#">
                <i class="bi bi-house"></i>
                <span>Dashboard</span>
            </a>
            <div class="tooltip">Dashboard</div>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-inbox"></i>
                <span>Inbox</span>
            </a>
            <div class="tooltip">Inbox</div>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-file-earmark-text"></i>
                <span>Documentation</span>
            </a>
            <div class="tooltip">Documentation</div>
        </li>

        <li>
            <a href="{{ route('Task Management.index') }}">
                <i class="bi bi-bar-chart"></i>
                <span>Statistics</span>
            </a>
            <div class="tooltip">Statistics</div>
        </li>

        <li class="menu-title">System</li>

        <li>
            <a href="#">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
            <div class="tooltip">Settings</div>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
            <div class="tooltip">Logout</div>
        </li>

    </ul>
</div>

<!-- ===== CONTENT ===== -->
<div class="content">
    <h2>EMIS Dashboard</h2>
    <p>Sidebar with hover tooltip when collapsed.</p>
</div>

<!-- ===== JS ===== -->
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('collapsed');
}
</script>

</body>
</html>
