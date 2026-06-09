<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu {{ request()->routeIs('dashboard.superadmin') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.superadmin') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
                </li>
                <li class="{{ request()->routeIs('ppdb.index') ? 'active' : '' }}">
                    <a href="{{ route('ppdb.index') }}"><i class="fas fa-clipboard-list"></i> <span>PPDB</span></a>
                </li>
                {{-- <li>
                    <a href="{{ route('daftar-ulang.index') }}"><i class="fas fa-file-signature"></i> <span>Pendaftaran Ulang</span></a>
                </li> --}}
                <li class="submenu {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-graduation-cap"></i> <span>Siswa</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li>
                            <a href="{{ route('siswa.index') }}" class="{{ request()->routeIs('siswa.index') ? 'active' : '' }}">
                                Data Siswa
                            </a>
                        </li>
                        <li>
                            @php
                                $currentSiswaId = Auth::check() && Auth::user()->siswa ? Auth::user()->siswa->id : null;
                            @endphp
                            <a href="{{ $currentSiswaId ? route('siswa.show', ['siswa' => $currentSiswaId]) : '#' }}"
                            class="{{ request()->routeIs('siswa.show') ? 'active' : '' }}">
                                Detail Siswa
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="submenu {{ request()->routeIs('guru.*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-chalkboard-teacher"></i> <span>Guru</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li>
                            <a href="{{ route('guru.index') }}" class="{{ request()->routeIs('guru.index') ? 'active' : '' }}">
                                Data Guru
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('guru.create') }}" class="{{ request()->routeIs('guru.create') ? 'active' : '' }}">
                                Tambah Guru
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Tambah menu lain sesuai kebutuhan -->
            </ul>
        </div>
    </div>
</div>
