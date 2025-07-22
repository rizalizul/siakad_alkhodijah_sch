<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                {{-- Dashboard --}}
                <li class="{{ request()->routeIs('dashboard.superadmin') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.superadmin') }}">
                        <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                    </a>
                </li>

                {{-- PPDB --}}
                {{-- Gunakan wildcard untuk mengaktifkan parent menu jika ada rute 'ppdb.*' yang aktif --}}
                <li class="submenu {{ request()->routeIs('ppdb.*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-clipboard-list"></i> <span>PPDB</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            {{-- Asumsi Anda memiliki rute 'ppdb.formulir' untuk form pendaftaran --}}
                            <a href="{{ route('ppdb.formulir') }}" class="{{ request()->routeIs('ppdb.formulir') ? 'active' : '' }}">
                                Pendaftaran Siswa Baru
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('ppdb.index') }}" class="{{ request()->routeIs('ppdb.index') || request()->routeIs('ppdb.verifikasi') ? 'active' : '' }}">
                                Data Calon Siswa
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Siswa --}}
                <li class="submenu {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-graduation-cap"></i> <span>Siswa</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('siswa.index') }}" class="{{ request()->routeIs('siswa.index') ? 'active' : '' }}">
                                Data Siswa
                            </a>
                        </li>
                        {{-- Detail Siswa: Biasanya link ini mengarah ke detail siswa yang spesifik.
                             Jika tidak ada ID siswa yang jelas dari konteks sidebar global,
                             lebih baik link ini mengarah ke daftar siswa atau dihilangkan.
                             Jika Anda ingin menunjukkan detail siswa yang sedang login (misalnya jika yang login adalah siswa),
                             Anda perlu logika untuk mendapatkan ID tersebut.
                             Untuk saat ini, saya asumsikan ini hanya menjadi aktif ketika di halaman detail siswa. --}}
                        <li>
                            <a href="#" class="{{ request()->routeIs('siswa.show') ? 'active' : '' }}">
                                Detail Siswa
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Guru --}}
                <li class="submenu {{ request()->routeIs('guru.*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-chalkboard-teacher"></i> <span>Guru</span> <span class="menu-arrow"></span>
                    </a>
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
                        {{-- Asumsi ada rute guru.edit untuk 'Ubah Guru' --}}
                        <li>
                            <a href="#" class="{{ request()->routeIs('guru.edit') ? 'active' : '' }}">
                                Ubah Guru
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Data Master --}}
                {{-- Gunakan pola regex untuk mencocokkan semua rute di dalam Data Master --}}
                <li class="submenu {{ request()->routeIs(['tahun-pelajaran.*', 'semester.*', 'mata-pelajaran.*', 'ekstrakurikuler.*']) ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-database"></i> <span>Data Master</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        {{-- Tahun Ajaran --}}
                        <li class="submenu {{ request()->routeIs('tahun-pelajaran.*') ? 'active' : '' }}">
                            <a href="#">Tahun Ajaran <span class="menu-arrow"></span></a>
                            <ul>
                                <li>
                                    <a href="{{ route('tahun-pelajaran.index') }}" class="{{ request()->routeIs('tahun-pelajaran.index') ? 'active' : '' }}">
                                        Data Tahun Ajaran
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('tahun-pelajaran.create') }}" class="{{ request()->routeIs('tahun-pelajaran.create') ? 'active' : '' }}">
                                        Tambah Tahun Ajaran
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="{{ request()->routeIs('tahun-pelajaran.edit') ? 'active' : '' }}">
                                        Ubah Tahun Ajaran
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- Semester --}}
                        <li class="submenu {{ request()->routeIs('semester.*') ? 'active' : '' }}">
                            <a href="#">Semester <span class="menu-arrow"></span></a>
                            <ul>
                                <li>
                                    <a href="{{ route('semester.index') }}" class="{{ request()->routeIs('semester.index') ? 'active' : '' }}">
                                        Data Semester
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('semester.create') }}" class="{{ request()->routeIs('semester.create') ? 'active' : '' }}">
                                        Tambah Semester
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="{{ request()->routeIs('semester.edit') ? 'active' : '' }}">
                                        Ubah Semester
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- Mata Pelajaran --}}
                        <li class="submenu {{ request()->routeIs('mata-pelajaran.*') ? 'active' : '' }}">
                            <a href="#">Mata Pelajaran <span class="menu-arrow"></span></a>
                            <ul>
                                <li>
                                    <a href="{{ route('mata-pelajaran.index') }}" class="{{ request()->routeIs('mata-pelajaran.index') ? 'active' : '' }}">
                                        Data Mata Pelajaran
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('mata-pelajaran.create') }}" class="{{ request()->routeIs('mata-pelajaran.create') ? 'active' : '' }}">
                                        Tambah Mata Pelajaran
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="{{ request()->routeIs('mata-pelajaran.edit') ? 'active' : '' }}">
                                        Ubah Mata Pelajaran
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- Ekstrakurikuler --}}
                        <li class="submenu {{ request()->routeIs('ekstrakurikuler.*') ? 'active' : '' }}">
                            <a href="#">Ekstrakurikuler <span class="menu-arrow"></span></a>
                            <ul>
                                <li>
                                    <a href="{{ route('ekstrakurikuler.index') }}" class="{{ request()->routeIs('ekstrakurikuler.index') ? 'active' : '' }}">
                                        Data Ekstrakurikuler
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('ekstrakurikuler.create') }}" class="{{ request()->routeIs('ekstrakurikuler.create') ? 'active' : '' }}">
                                        Tambah Ekstrakurikuler
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="{{ request()->routeIs('ekstrakurikuler.edit') ? 'active' : '' }}">
                                        Ubah Ekstrakurikuler
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                {{-- Kelas --}}
                <li class="{{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                    <a href="{{ route('kelas.index') }}">
                        <i class="fas fa-chalkboard"></i> <span>Kelas</span>
                    </a>
                </li>

                {{-- Jadwal Pelajaran (Asumsi rute 'jadwal-pelajaran.index' atau sejenisnya) --}}
                <li class="{{ request()->routeIs('jadwal-pelajaran.*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-calendar-alt"></i> <span>Jadwal Pelajaran</span>
                    </a>
                </li>

                {{-- Absensi Harian (Asumsi rute 'absensi.index' atau sejenisnya) --}}
                <li class="{{ request()->routeIs('absensi.*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-user-check"></i> <span>Absensi Harian</span>
                    </a>
                </li>

                {{-- Pengelolaan Nilai (Asumsi rute 'nilai.index' atau sejenisnya) --}}
                <li class="{{ request()->routeIs('nilai.*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-clipboard-check"></i> <span>Pengelolaan Nilai</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>