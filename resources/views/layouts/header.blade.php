<div class="header">
    <div class="header-left">
        {{-- <a href="{{ route('dashboard.superadmin') }}" class="logo">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
        </a>
        <a href="{{ route('dashboard.superadmin') }}" class="logo logo-small">
            <img src="{{ asset('assets/img/logo-small.png') }}" alt="Logo" width="30" height="30">
        </a> --}}
        @auth
            @if(Auth::user()->hasRole('superadmin'))
                <a href="{{ route('dashboard.superadmin') }}" class="logo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                </a>
                <a href="{{ route('dashboard.superadmin') }}" class="logo logo-small">
                    <img src="{{ asset('assets/img/logo-small.png') }}" alt="Logo" width="30" height="30">
                </a>
            @elseif(Auth::user()->hasRole('guru'))
                <!-- Asumsi ada route('dashboard.guru') -->
                <a href="{{ route('dashboard.guru') }}">Dashboard Guru</a>
            @else
                <!-- Default dashboard jika tidak ada peran spesifik -->
                <a href="/some-default-dashboard">Dashboard</a>
            @endif
        @endauth
    </div>

    <div class="menu-toggle">
        <a href="javascript:void(0);" id="toggle_btn"><i class="fas fa-bars"></i></a>
    </div>

    <ul class="nav user-menu">
        <li class="nav-item zoom-screen me-2">
            <a href="#" class="nav-link header-nav-list win-maximize">
                <img src="assets/img/icons/header-icon-04.svg" alt="" />
            </a>
        </li>
        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" src="{{ asset('assets/img/profiles/avatar-01.jpg') }}" width="31" alt="User">
                    <div class="user-text">
                        <h6>{{ Auth::user()->name }}</h6>
                        <p class="text-muted mb-0">
                            @if(Auth::user()->getRoleNames()->isNotEmpty())
                                {{ Auth::user()->getRoleNames()->implode(', ') }}
                            @else
                                Belum ada Peran
                            @endif
                        </p>
                    </div>
                </span>
            </a>
            <div class="dropdown-menu">
                {{-- <a class="dropdown-item" href="{{ route('profile') }}">Profil Saya</a> --}}
                <a class="dropdown-item" href="#">Profil Saya (Dummy)</a>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> &nbsp; Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</div>
