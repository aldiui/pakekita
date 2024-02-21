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
                            <h6 class="user-dropdown-name">John Ducky</h6>
                            <p class="user-dropdown-status text-sm text-muted">Member</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                        <li><a class="dropdown-item" href="#">My Account</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="auth-login.html">Logout</a></li>
                    </ul>
                </div>
                <!-- Burger button responsive -->
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </div>
        </div>
    </div>
    <nav class="main-navbar">
        <div class="container">
            <ul>
                <li class="menu-item  ">
                    <a href="/admin" class='menu-link'>
                        <span><i class="bi bi-grid-fill"></i> Dashboard</span>
                    </a>
                </li>
                <li class="menu-item  ">
                    <a href="/admin/user" class='menu-link'>
                        <span><i class="bi bi-people-fill"></i> Manajemen User</span>
                    </a>
                </li>
                <li class="menu-item  has-sub">
                    <a href="#" class='menu-link'>
                        <span><i class="bi bi-box-fill"></i> Manajemen Barang</span>
                    </a>
                    <div class="submenu mt-lg-3">
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                <li class="submenu-item">
                                    <a href="/admin/kategori" class='submenu-link'>Kategori</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="/admin/unit" class='submenu-link'>Unit</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="/admin/barang" class='submenu-link'>Barang</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="/admin/stok" class='submenu-link'>Stok</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="menu-item  has-sub">
                    <a href="#" class='menu-link'>
                        <span><i class="bi bi-cash"></i> Manajemen Kasir</span>
                    </a>
                    <div class="submenu mt-lg-3">
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                <li class="submenu-item">
                                    <a href="/admin/menu" class='submenu-link'>Menu</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="/admin/meja" class='submenu-link'>Meja</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="/admin/pembayaran" class='submenu-link'>Pembayaran</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="/admin/pesan-meja" class='submenu-link'>Pesan Meja</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="/admin/transaksi" class='submenu-link'>Transaksi</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
