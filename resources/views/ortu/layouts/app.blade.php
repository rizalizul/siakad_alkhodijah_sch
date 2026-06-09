<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <title>@yield('title', 'Portal Orang Tua') - SIAKAD Al Khodijah</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
</head>
<body>
    <div class="main-wrapper">
        <div class="header header-one">
            <div class="header-left header-left-one">
                <a href="{{ route('ortu.dashboard') }}" class="logo"><img src="{{ asset('assets/img/logo.png') }}" alt="Logo" /></a>
            </div>
            <ul class="nav user-menu">
                <li class="nav-item dropdown has-arrow new-user-menus">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle" src="{{ Storage::url($siswa->foto) }}" width="31" alt="{{ $siswa->nama }}">
                            <div class="user-text">
                                <h6>Orang Tua/Wali dari</h6>
                                <p class="text-muted mb-0">{{ $siswa->nama }}</p>
                            </div>
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                        <form id="logout-form" action="{{ route('ortu.logout') }}" method="POST" style="display: none;">@csrf</form>
                    </div>
                </li>
            </ul>
        </div>
        <div class="page-wrapper" style="margin-left: 0;">
            <div class="content container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>