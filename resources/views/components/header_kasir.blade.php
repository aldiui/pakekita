<header class="mb-5">
    <div class="header-top">
        <div class="container">
            <div class="logo">
                <a href="index.html"><img src="{{ asset('compiled/svg/logo.svg') }}" alt="Logo"></a>
            </div>
            <div class="header-top-right">
                <div class="dropdown">
                    <a href="#" id="topbarUserDropdown"
                        class="user-dropdown d-flex align-items-center dropend dropdown-toggle "
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar avatar-md2">
                            <img src="{{ asset('compiled/jpg/1.jpg') }}" alt="Avatar">
                        </div>
                        <div class="text">
                            <h6 class="user-dropdown-name">{{ Auth::user()->nama ?? '' }}</h6>
                            <p class="user-dropdown-status text-sm text-muted">{{ Auth::user()->email ?? '' }}</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                        <li><a class="dropdown-item" href="{{ route('kasir.profil') }}">Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </div>
        </div>
    </div>
    <nav class="main-navbar">
        <div class="container">
            <ul>
                <li class="menu-item">
                    <a href="/kasir" class='menu-link'>
                        <span><i class="bi bi-grid-fill"></i> Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/kasir/menu" class='menu-link'>
                        <span><i class="bi bi-archive-fill"></i> Menu</span>
                    </a>
                </li>
                <li class="menu-item  ">
                    <a href="/kasir/transaksi" class='menu-link'>
                        <span><i class="bi bi-cash"></i> Transaksi</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
