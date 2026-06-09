<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
                </li>

                @if(in_array(Auth::user()->role, ['staf_administrasi', 'wakasek_kurikulum']))
                    <li class="menu-title">
                        <span>Data Master</span>
                    </li>
                    <li class="{{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                        <a href="{{ route('siswa.index') }}"><i class="fas fa-user-graduate"></i> <span>Data Siswa</span></a>
                    </li>
                    <li class="{{ request()->routeIs('tahun-ajaran.*') ? 'active' : '' }}">
                        <a href="{{ route('tahun-ajaran.index') }}"><i class="fas fa-calendar-alt"></i> <span>Tahun Ajaran</span></a>
                    </li>
                    <li class="{{ request()->routeIs('guru.*') ? 'active' : '' }}">
                        <a href="{{ route('guru.index') }}"><i class="fas fa-chalkboard-teacher"></i> <span>Data Guru</span></a>
                    </li>
                    <li class="{{ request()->routeIs('mata-pelajaran.*') ? 'active' : '' }}">
                        <a href="{{ route('mata-pelajaran.index') }}"><i class="fas fa-book-reader"></i> <span>Mata Pelajaran</span></a>
                    </li>
                    <li class="{{ request()->routeIs('ekstrakurikuler.*') ? 'active' : '' }}">
                        <a href="{{ route('ekstrakurikuler.index') }}"><i class="fas fa-running"></i> <span>Ekstrakurikuler</span></a>
                    </li>
                @endif
                
                {{-- == STAFF ADMINISTRASI --}}
                @if(Auth::user()->role == 'staf_administrasi')
                    <li class="menu-title">
                        <span>Penerimaan Siswa</span>
                    </li>
                    <li class="{{ request()->routeIs('admin.ppdb.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.ppdb.index') }}"><i class="fas fa-clipboard-list"></i> <span>Manajemen PPDB</span></a>
                    </li>    
                    <li class="menu-title">
                        <span>Pengaturan</span>
                    </li>
                    <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}"><i class="fas fa-users-cog"></i> <span>Manajemen Pengguna</span></a>
                    </li>
                @endif

                {{-- Bendahara --}}
                @if(in_array(Auth::user()->role, ['bendahara']))
                    <li class="menu-title">
                        <span>Keuangan</span>
                    </li>
                    <li class="{{ request()->routeIs('keuangan.ppdb.*') ? 'active' : '' }}">
                        <a href="{{ route('keuangan.ppdb.index') }}"><i class="fas fa-dollar-sign"></i> <span>Pembayaran PPDB</span></a>
                    </li>
                    <li class="{{ request()->routeIs('keuangan.jenis-pembayaran.*') ? 'active' : '' }}">
                        <a href="{{ route('keuangan.jenis-pembayaran.index') }}"><i class="fas fa-list-alt"></i> <span>Jenis Pembayaran</span></a>
                    </li>
                    <li class="{{ request()->routeIs('keuangan.tagihan.*') ? 'active' : '' }}">
                        <a href="{{ route('keuangan.tagihan.index') }}"><i class="fas fa-file-invoice-dollar"></i> <span>Tagihan Siswa</span></a>
                    </li>
                @endif
                
                {{-- WAKASEK & WALI KELAS --}}
                @if(in_array(Auth::user()->role, ['wali_kelas', 'wakasek_kurikulum']))
                     <li class="menu-title">
                        <span>Akademik</span>
                    </li>
                    <li class="{{ request()->routeIs('screening.*') ? 'active' : '' }}">
                        <a href="{{ route('screening.index') }}"><i class="fas fa-user-check"></i> <span>Screening Siswa</span></a>
                    </li>
                @endif

                {{-- WAKASEK KURIKULUM --}}
                @if(in_array(Auth::user()->role, ['wakasek_kurikulum']))
                     <li class="menu-title">
                        <span>Manajemen Akademik</span>
                    </li>
                    <li class="{{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                        <a href="{{ route('kelas.index') }}"><i class="fas fa-chalkboard"></i> <span>Manajemen Kelas</span></a>
                    </li>
                    <li class="{{ request()->routeIs('guru-mapel.*') ? 'active' : '' }}">
                        <a href="{{ route('guru-mapel.index') }}"><i class="fas fa-user-tie"></i> <span>Penugasan Guru</span></a>
                    </li>
                    <li class="{{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                        <a href="{{ route('jadwal.index') }}"><i class="fas fa-calendar-day"></i> <span>Jadwal Pelajaran</span></a>
                    </li>
                @endif

                {{-- Wali Kelas --}}
                @if(in_array(Auth::user()->role, ['wali_kelas']))
                     <li class="menu-title">
                        <span>Menu Wali Kelas</span>
                    </li>
                    <li class="{{ request()->routeIs('wali-kelas.siswa.*') ? 'active' : '' }}">
                        <a href="{{ route('wali-kelas.siswa.index') }}"><i class="fas fa-users"></i> <span>Data Siswa</span></a>
                    </li>
                    <li class="{{ request()->routeIs('absensi.*') ? 'active' : '' }}">
                        <a href="{{ route('absensi.index') }}"><i class="fas fa-calendar-check"></i> <span>Absensi Kelas</span></a>
                    </li>
                    <li class="{{ request()->routeIs('rekap-nilai.*') ? 'active' : '' }}">
                        <a href="{{ route('rekap-nilai.index') }}"><i class="fas fa-file-invoice"></i> <span>Rekap Nilai Siswa</span></a>
                    </li>
                    <li class="{{ request()->routeIs('rapor.index') ? 'active' : '' }}">
                        <a href="{{ route('rapor.index') }}"><i class="fas fa-book-open"></i> <span>Manajemen Rapor</span></a>
                    </li>
                @endif

                {{-- Wali Kelas & Guru Mapel --}}
                @if(in_array(Auth::user()->role, ['guru_mapel', 'wali_kelas']))
                     <li class="menu-title">
                        <span>Menu Guru</span>
                    </li>
                    <li class="{{ request()->routeIs('jadwal-guru.*') ? 'active' : '' }}">
                        <a href="{{ route('jadwal-guru.index') }}"><i class="fas fa-calendar-week"></i> <span>Jadwal Mengajar</span></a>
                    </li>
                    <li class="{{ request()->routeIs('nilai.*') ? 'active' : '' }}">
                        <a href="{{ route('nilai.index') }}"><i class="fas fa-edit"></i> <span>Pengelolaan Nilai</span></a>
                    </li>
                @endif

                {{-- Kepala Sekolah --}}
                @if(in_array(Auth::user()->role, ['kepala_sekolah']))
                     <li class="menu-title">
                        <span>Menu Kepala Sekolah</span>
                    </li>
                    <li class="{{ request()->routeIs('rapor.kepsek.*') ? 'active' : '' }}">
                        <a href="{{ route('rapor.kepsek.index') }}"><i class="fas fa-check-double"></i> <span>Persetujuan Rapor</span></a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>