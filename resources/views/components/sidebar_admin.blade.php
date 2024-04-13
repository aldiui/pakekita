<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="container text-center mt-4">
            <a href="/admin">
                <img src="{{ asset('static/images/logo/logo.png') }}" alt="Logo" width="120px">
            </a>
        </div>
        <div class="sidebar-menu">
            <ul class="menu mb-5">
                <li class="sidebar-item {{ request()->is('admin') ? 'active' : '' }}">
                    <a href="{{ url('/admin') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/user') ? 'active' : '' }}">
                    <a href="{{ url('/admin/user') }}" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>User</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/pendapatan') ? 'active' : '' }}">
                    <a href="{{ url('/admin/pendapatan') }}" class='sidebar-link'>
                        <i class="bi bi-cash"></i>
                        <span>Pendapatan</span>
                    </a>
                </li>
                <li class="sidebar-title">Manajemen Barang</li>
                <li class="sidebar-item {{ request()->is('admin/kategori') ? 'active' : '' }}">
                    <a href="{{ url('/admin/kategori') }}" class='sidebar-link'>
                        <i class="bi bi-bookmark-fill"></i>
                        <span>Kategori</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/unit') ? 'active' : '' }}">
                    <a href="{{ url('/admin/unit') }}" class='sidebar-link'>
                        <i class="bi bi-tag-fill"></i>
                        <span>Unit</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/barang') ? 'active' : '' }}">
                    <a href="{{ url('/admin/barang') }}" class='sidebar-link'>
                        <i class="bi bi-bag-fill"></i>
                        <span>Barang</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/stok') ? 'active' : '' }}">
                    <a href="{{ url('/admin/stok') }}" class='sidebar-link'>
                        <i class="bi bi-archive-fill"></i>
                        <span>Stok</span>
                    </a>
                </li>
                <li class="sidebar-title">Manajemen Kasir</li>
                <li class="sidebar-item {{ request()->is('admin/menu') ? 'active' : '' }}">
                    <a href="{{ url('/admin/menu') }}" class='sidebar-link'>
                        <i class="bi bi-menu-up"></i>
                        <span>Menu</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/meja') ? 'active' : '' }}">
                    <a href="{{ url('/admin/meja') }}" class='sidebar-link'>
                        <i class="bi bi-tablet-landscape-fill"></i>
                        <span>Meja</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/transaksi') ? 'active' : '' }}">
                    <a href="{{ url('/admin/transaksi') }}" class='sidebar-link'>
                        <i class="bi bi-cash"></i>
                        <span>Transaksi</span>
                    </a>
                </li>
                <li class="sidebar-title">Pengaturan</li>
                <li class="sidebar-item {{ request()->is('admin/profil') ? 'active' : '' }}">
                    <a href="{{ url('/admin/profil') }}" class='sidebar-link'>
                        <i class="bi bi-person-fill"></i>
                        <span>Profil</span>
                    </a>
                </li>
                <li class="sidebar-item mb-5">
                    <a href="{{ url('/logout') }}" class='sidebar-link text-danger'>
                        <i class="bi bi-arrow-right-circle-fill text-danger"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
