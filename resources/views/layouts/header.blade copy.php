<div class="header">
    <div class="header-left">
        <a href="{{ route('dashboard.superadmin') }}" class="logo">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" />
        </a>
        <a href="{{ route('dashboard.superadmin') }}" class="logo logo-small">
            <img src="{{ asset('assets/img/logo-small.png') }}" alt="Logo" width="30" height="30" />
        </a>
    </div>

    <div class="menu-toggle">
        <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-bars"></i>
        </a>
    </div>

    <ul class="nav user-menu">
        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" src="{{ asset('assets/img/profiles/avatar-01.jpg') }}" width="31" alt="User" />
                    <div class="user-text">
                        <h6>{{ Auth::user()->name ?? 'Superadmin' }}</h6>
                        <p class="text-muted mb-0">Administrator</p>
                    </div>
                </span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Profil Saya</a>
                {{-- <form method="POST" action="{{ route('logout') }}"> --}}
                    <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="dropdown-item">Keluar</button>
                </form>
            </div>
        </li>
    </ul>
</div>
