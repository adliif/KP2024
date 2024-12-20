<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" style="background-color: rgba(174, 178, 182, 0.1);">
    <div class="container-fluid">
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        @if (Auth::user()->jenis_kelamin == "Laki-Laki")
                            <img src="../assets/img/kaiadmin/man.png" alt="..." class="avatar-img rounded-circle" />
                        @else
                            <img src="../assets/img/kaiadmin/women.png" alt="..." class="avatar-img rounded-circle" />
                        @endif
                    </div>
                    <span class="profile-username">
                        <span class="op-7">Hi,</span>
                        <span class="fw-bold">{{ Auth::user()->nama }}</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    @if (Auth::user()->jenis_kelamin == "Laki-Laki")
                                        <img src="../assets/img/kaiadmin/man.png" alt="..." class="avatar-img rounded-circle" />
                                    @else
                                        <img src="../assets/img/kaiadmin/women.png" alt="..." class="avatar-img rounded-circle" />
                                    @endif
                                </div>
                                <div class="u-text">
                                    <h4>{{ Auth::user()->nama }}</h4>
                                    <p class="text-muted">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="profile">My Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="logout"
                                    onclick="event.preventDefault(); this.closest('form').submit();">Keluar</a>
                            </form>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>