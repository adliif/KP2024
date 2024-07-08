<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="/" class="logo">
                <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="{{request()->is('adminDashboard') ? 'nav-item active' : 'nav-item'}}">
                    <a href="/adminDashboard">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu</h4>
                </li>
                <li class="{{request()->is('dataAnggota') ? 'nav-item active' : 'nav-item'}}">
                    <a href="/dataAnggota">
                        <i class="fas fa-hand-holding-usd"></i>
                        <p>Data Anggota</p>
                    </a>
                </li>
                <li class="{{request()->is('dataPinjaman') ? 'nav-item active' : 'nav-item'}}">
                    <a href="/dataPinjaman">
                        <i class="fas fa-hand-holding-usd"></i>
                        <p>Data Pinjaman</p>
                    </a>
                </li>
                <li class="{{request()->is('dataAngsuran') ? 'nav-item active' : 'nav-item'}}">
                    <a href="/dataAngsuran">
                        <i class="fas fa-hand-holding-usd"></i>
                        <p>Data Angsuran</p>
                    </a>
                </li>
                <li class="{{request()->is('dataSimpananPokok') ? 'nav-item active' : 'nav-item'}}">
                    <a href="/dataSimpananPokok">
                        <i class="fas fa-hand-holding-usd"></i>
                        <p>Data Simpanan Pokok</p>
                    </a>
                </li>
                <li class="{{request()->is('logout') ? 'nav-item active' : 'nav-item'}}">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="logout" onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>