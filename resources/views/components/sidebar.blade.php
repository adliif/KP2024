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
                <li class="{{request()->is('dashboard') ? 'nav-item active' : 'nav-item'}}">
                    <a href="/dashboard">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>
                <li class="{{request()->is('tanggungan') ? 'nav-item active' : 'nav-item'}}">
                    <a href="/tanggungan">
                        <i class="fas fa-hand-holding-usd"></i>
                        <p>Tanggungan</p>
                    </a>
                </li>
                <li class="{{request()->is('history') ? 'nav-item active' : 'nav-item'}}">
                    <a href="/history">
                        <i class="fas fa-history"></i>
                        <p>History</p>
                    </a>
                </li>
                <li class="{{request()->is('profile') ? 'nav-item active' : 'nav-item'}}">
                    <a href="/profile">
                        <i class="fas fa-user-tie"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="{{request()->is('helpdesk') ? 'nav-item active' : 'nav-item'}}">
                    <a href="/helpdesk">
                        <i class="fas fa-address-book"></i>
                        <p>Helpdesk</p>
                    </a>
                </li>
                <li class="{{request()->is('logout') ? 'nav-item active' : 'nav-item'}}">
                    <a href="/logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>