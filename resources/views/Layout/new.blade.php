





<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top px-3 py-2">
    <div class="container-fluid">

        <!-- Brand / Logo -->
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ url('/') }}">
            <i class="fa-solid fa-layer-group me-2 fs-5"></i> EOMIS
        </a>

        <!-- Toggle button (for mobile view) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarMain" aria-controls="navbarMain" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbarMain">

            <!-- Search Bar -->
            <form class="d-flex ms-lg-3 my-2 my-lg-0 flex-grow-1" 
                  action="#" method="GET">
                <div class="input-group">
                    <input class="form-control" type="search" name="query" placeholder="Search..." aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto align-items-center mt-2 mt-lg-0">

                <!-- Language Selector -->
                <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle text-secondary d-flex align-items-center" href="#" 
                       id="langDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                        @auth
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fa-solid fa-id-badge me-2"></i> Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="" method="POST" class="m-0">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @else
                            <li>
                                <a class="dropdown-item" href="">
                                    <i class="fa-solid fa-right-to-bracket me-2"></i> Login
                                </a>
                            </li>
                        @endauth
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

@endsection