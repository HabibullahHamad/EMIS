@include('Welcome')
@section('content')
<style>

.sidebar {
    width: 260px;
    height: 100vh;
    background: #0d6efd;
    color: #fff;
    position: fixed;
    overflow-y: auto;
}

.sidebar-header {
    padding: 15px;
    font-size: 18px;
    font-weight: bold;
    background: #084298;
    text-align: center;
}

.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-menu li {
    position: relative;
}

.sidebar-menu li a {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    transition: 0.3s;
}

.sidebar-menu li a i {
    width: 22px;
    margin-right: 10px;
    text-align: center;
}

.sidebar-menu li a:hover {
    background: #084298;
}

.arrow {
    margin-left: auto;
}

.submenu {
    display: none;
    background: #0b5ed7;
}

.submenu li a {
    padding-left: 40px;
    font-size: 13px;
}

.submenu.level-2 {
    background: #094db1;
}

.submenu.level-2 li a {
    padding-left: 60px;
}

/* Show submenu on hover */
.has-submenu:hover > .submenu {
    display: block;
}


</style>


<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <h5>EMIS</h5>
    </div>

    <ul class="sidebar-menu">

        <!-- Dashboard -->
        <li>
            <a href="#">
                <i class="fa fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Administration -->
        <li class="has-submenu">
            <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Administration</span>
                <i class="fa fa-angle-down arrow"></i>
            </a>

            <ul class="submenu">
                <li>
                    <a href="#">
                        <i class="fa fa-users"></i>
                        Users
                    </a>
                </li>

                <li class="has-submenu">
                    <a href="#">
                        <i class="fa fa-shield-alt"></i>
                        Roles & Permissions
                        <i class="fa fa-angle-right arrow"></i>
                    </a>

                    <ul class="submenu level-2">
                        <li>
                            <a href="#">
                                <i class="fa fa-user-tag"></i>
                                Roles
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-key"></i>
                                Permissions
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <!-- Letters / Inbox -->
        <li class="has-submenu">
            <a href="#">
                <i class="fa fa-envelope"></i>
                <span>Letters</span>
                <i class="fa fa-angle-down arrow"></i>
            </a>

            <ul class="submenu">
                <li>
                    <a href="#"><i class="fa fa-inbox"></i> Inbox</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-paper-plane"></i> Sent</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-archive"></i> Archive</a>
                </li>
            </ul>
        </li>

        <!-- Reports -->
        <li>
            <a href="#">
                <i class="fa fa-chart-bar"></i>
                <span>Reports</span>
            </a>
        </li>

    </ul>
</div>
@endesection 