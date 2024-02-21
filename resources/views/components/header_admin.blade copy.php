<div class="header-wrapper">
    <!--start header -->
    <header>
        <div class="topbar d-flex align-items-center">
            <nav class="navbar navbar-expand">
                <div class="topbar-logo-header">
                    <div class="">
                        <img src="{{ asset('images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                    </div>
                    <div class="">
                        <h4 class="logo-text">Rocker</h4>
                    </div>
                </div>
                <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
                <div class="search-bar flex-grow-1">
                    <div class="position-relative search-bar-box">
                        <input type="text" class="form-control search-control" placeholder="Type to search..."> <span
                            class="position-absolute top-50 search-show translate-middle-y"><i
                                class='bx bx-search'></i></span>
                        <span class="position-absolute top-50 search-close translate-middle-y"><i
                                class='bx bx-x'></i></span>
                    </div>
                </div>
                <div class="top-menu ms-auto">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item mobile-search-icon">
                            <a class="nav-link" href="#"> <i class='bx bx-search'></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="user-box dropdown">
                    <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('images/avatars/avatar-2.png') }}" class="user-img" alt="user avatar">
                        <div class="user-info ps-3">
                            <p class="user-name mb-0">Pauline Seitz</p>
                            <p class="designattion mb-0">Web Designer</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="javascript:;"><i
                                    class="bx bx-user"></i><span>Profile</span></a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:;"><i
                                    class="bx bx-cog"></i><span>Settings</span></a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:;"><i
                                    class='bx bx-home-circle'></i><span>Dashboard</span></a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:;"><i
                                    class='bx bx-dollar-circle'></i><span>Earnings</span></a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:;"><i
                                    class='bx bx-download'></i><span>Downloads</span></a>
                        </li>
                        <li>
                            <div class="dropdown-divider mb-0"></div>
                        </li>
                        <li><a class="dropdown-item" href="javascript:;"><i
                                    class='bx bx-log-out-circle'></i><span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!--end header -->
    <!--navigation-->
    <div class="nav-container primary-menu">
        <div class="mobile-topbar-header">
            <div>
                <img src="{{ asset('images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
            </div>
            <div>
                <h4 class="logo-text">Rukada</h4>
            </div>
            <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
            </div>
        </div>
        <nav class="navbar navbar-expand-xl w-100">
            <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
                <li class="nav-item dropdown">
                    <a href="/" class="nav-link">
                        <div class="parent-icon">
                            <i class='bx bx-home-circle'></i>
                        </div>
                        <div class="menu-title">Beranda</div>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="/" class="nav-link">
                        <div class="parent-icon">
                            <i class='bx bx-user'></i>
                        </div>
                        <div class="menu-title">Manajemen User</div>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="javascript:;"
                        class="nav-link {{ Request::is('admin/kategori') || Request::is('admin/unit') || Request::is('admin/barang') ? 'active text-white' : '' }} dropdown-toggle dropdown-toggle-nocaret"
                        data-bs-toggle="dropdown">
                        <div class="parent-icon"><i class='bx bx-cart'></i>
                        </div>
                        <div class="menu-title">Manajemen Barang</div>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ Request::is('admin/kategori') ? 'active' : '' }}"
                                href="/admin/kategori">
                                <i class="bx bx-right-arrow-alt"></i>Kategori
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('admin/unit') ? 'active' : '' }}" href="/admin/unit">
                                <i class="bx bx-right-arrow-alt"></i>Unit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('admin/barang') ? 'active' : '' }}"
                                href="/admin/barang">
                                <i class="bx bx-right-arrow-alt"></i>Barang
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/">
                                <i class="bx bx-right-arrow-alt"></i>Stok
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="javascript:;"
                        class="nav-link {{ Request::is('admin/meja') || Request::is('admin/menu') || Request::is('admin/pembayaran') ? 'active text-white' : '' }} dropdown-toggle dropdown-toggle-nocaret"
                        data-bs-toggle="dropdown">
                        <div class="parent-icon">
                            <i class='bx bx-wallet'></i>
                        </div>
                        <div class="menu-title">Manajemen Kasir</div>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ Request::is('admin/menu') ? 'active' : '' }}"
                                href="/admin/menu">
                                <i class="bx bx-right-arrow-alt"></i>Menu
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('admin/meja') ? 'active' : '' }} "
                                href="/admin/meja">
                                <i class="bx bx-right-arrow-alt"></i>Meja
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('admin/pembayaran') ? 'active' : '' }} "
                                href="/admin/pembayaran">
                                <i class="bx bx-right-arrow-alt"></i>Pembayaran
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/">
                                <i class="bx bx-right-arrow-alt"></i>Pesan Meja
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/">
                                <i class="bx bx-right-arrow-alt"></i>Transaksi
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <!--end navigation-->
</div>
