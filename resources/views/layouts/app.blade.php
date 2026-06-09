<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
        <title>@yield('title', 'Dashboard') - SIAKAD Al Khodijah</title>

        <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" />
        {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}" /> --}}
        {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/icons/flags/flags.css') }}" /> --}}
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
        @stack('styles') {{-- Untuk CSS tambahan per halaman --}}
    </head>

    <body>
        <div class="main-wrapper">
            {{-- Header --}}
            <div class="header">
                <div class="header-left">
                    <a href="{{ route('dashboard') }}" class="logo">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" />
                    </a>
                    <a href="{{ route('dashboard') }}" class="logo logo-small">
                        <img src="{{ asset('assets/img/logo-small.png') }}" alt="Logo" width="30" height="30" />
                    </a>
                </div>
                <div class="menu-toggle">
                    <a href="javascript:void(0);" id="toggle_btn">
                        <i class="fas fa-bars"></i>
                    </a>
                    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                        <i class="fas fa-bars"></i>
                    </a>
                </div>
                <ul class="nav user-menu">
                    <li class="nav-item zoom-screen me-2">
                        <a href="#" class="nav-link header-nav-list win-maximize">
                            <img src="{{ asset('assets/img/icons/header-icon-04.svg') }}" alt="" />
                        </a>
                    </li>
                    <li class="nav-item dropdown has-arrow new-user-menus">
                        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                            <span class="user-img">
                                <img src="{{ asset('assets/img/profiles/avatar-01.jpg') }}" class="rounded-circle" width="31" alt="{{ Auth::user()->name }}" />
                                {{-- <img src="{{ $guru->foto ? Storage::url($guru->foto) : asset('assets/img/profiles/avatar-01.jpg') }}" class="rounded-circle" width="31"alt="Foto"> --}}
                                <div class="user-text">
                                    <h6>{{ Auth::user()->name }}</h6>
                                    <p class="text-muted mb-0">{{ Str::ucfirst(str_replace('_', ' ', Auth::user()->role))  }}</p>
                                </div>
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="user-header">
                                <div class="avatar avatar-sm">
                                    <img src="{{ asset('assets/img/profiles/avatar-01.jpg') }}" alt="User Image" class="avatar-img rounded-circle" />
                                </div>
                                <div class="user-text">
                                    <h6>{{ Auth::user()->name }}</h6>
                                    <p class="text-muted mb-0">{{ Str::ucfirst(str_replace('_', ' ', Auth::user()->role))  }}</p>
                                </div>
                            </div>
                            <a class="dropdown-item" href="{{ route('profile.show') }}">Profil Saya</a>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
            {{-- /Header --}}

            {{-- Sidebar --}}
            @include('layouts.sidebar')
            {{-- /Sidebar --}}

            {{-- Page Wrapper --}}
            <div class="page-wrapper">
                <div class="content container-fluid">
                    
                    @yield('content')

                </div>
                 {{-- Footer --}}
                <footer>
                    <p>Copyright © 2025 Al Khodijah Elementary School.</p>
                </footer>
                {{-- /Footer --}}
            </div>
            {{-- /Page Wrapper --}}

        </div>

        <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        {{-- <script src="{{ asset('assets/js/feather.min.js') }}"></script> --}}
        <script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>
        @stack('scripts') {{-- Untuk JS tambahan per halaman --}}
    </body>
</html>