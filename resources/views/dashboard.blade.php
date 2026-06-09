@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-sub-header">
                <h3 class="page-title">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ Str::ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- FORM FILTER TAHUN AJARAN --}}
<div class="row">
    <div class="col-12">
        <div class="card bg-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <form action="{{ route('dashboard') }}" method="GET" class="d-flex align-items-center gap-2">
                            <label for="tahun_ajaran_nama" class="form-label mb-0" style="white-space: nowrap;">Tahun Ajaran:</label>
                            <select name="tahun_ajaran_nama" id="tahun_ajaran_nama" class="form-select form-select-sm" onchange="this.form.submit()">
                                @if($semuaTahunAjaranNama->isEmpty())
                                    <option>Belum ada data</option>
                                @else
                                    @foreach($semuaTahunAjaranNama as $nama)
                                        <option value="{{ $nama }}" {{ $selectedTahunAjaranNama == $nama ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </form>
                    </div>
                    <div class="col-md-6 text-md-end mt-2 mt-md-0">
                        @if ($tahunAjaranAktif)
                            <span class="badge bg-success-light">Tahun Ajaran Aktif: {{ $tahunAjaranAktif->nama }} (Semester {{ $tahunAjaranAktif->semester }})</span>
                        @else
                            <span class="badge bg-danger-light">Tahun Ajaran Aktif Belum Diatur</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- STATISTIK UMUM (Tampil untuk semua admin) --}}
<div class="row">
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card bg-comman w-100">
            <div class="card-body">
                <div class="db-widgets d-flex justify-content-between align-items-center">
                    <div class="db-info">
                        <h6>Total Siswa Aktif</h6>
                        <h3>{{ $totalSiswa ?? 0 }}</h3>
                    </div>
                    <div class="db-icon"><img src="{{ asset('assets/img/icons/dash-icon-01.svg') }}" alt="Dashboard Icon" /></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card bg-comman w-100">
            <div class="card-body">
                <div class="db-widgets d-flex justify-content-between align-items-center">
                    <div class="db-info">
                        <h6>Total Guru</h6>
                        <h3>{{ $totalGuru ?? 0 }}</h3>
                    </div>
                    <div class="db-icon"><img src="{{ asset('assets/img/icons/dash-icon-02.svg') }}" alt="Dashboard Icon" /></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card bg-comman w-100">
            <div class="card-body">
                <div class="db-widgets d-flex justify-content-between align-items-center">
                    <div class="db-info">
                        <h6>Total Kelas</h6>
                        <h3>{{ $totalKelas ?? 0 }}</h3>
                    </div>
                    <div class="db-icon"><img src="{{ asset('assets/img/icons/dash-icon-03.svg') }}" alt="Dashboard Icon" /></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card bg-comman w-100">
            <div class="card-body">
                <div class="db-widgets d-flex justify-content-between align-items-center">
                    <div class="db-info">
                        <h6>Data Ditampilkan</h6>
                        <h3>{{ $selectedTahunAjaranNama ?? 'Tidak Ada' }}</h3>
                    </div>
                    <div class="db-icon"><img src="{{ asset('assets/img/icons/dash-icon-04.svg') }}" alt="Dashboard Icon" /></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @if(Auth::user()->role == 'guru_mapel')
        {{-- Tampilan untuk Guru Mapel --}}
        <div class="col-12">
            <div class="card card-table">
                <div class="card-header">
                    <h4 class="card-title">Jadwal Mengajar Minggu Ini (T.A. {{ $tahunAjaranAktif->nama ?? '' }})</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table border-0 star-student table-hover table-center table-borderless table-striped">
                            <thead class="thead-light">
                                <tr>
                                    @foreach($hari as $h)
                                    <th>{{ $h }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($hari as $h)
                                    <td class="p-2" style="vertical-align: top; min-width: 150px;">
                                        @if(!empty($jadwals) && isset($jadwals[$h]))
                                            @forelse($jadwals[$h] as $jadwal)
                                            <div class="card shadow-sm border mb-2">
                                                <div class="card-body p-2">
                                                    <p class="font-weight-bold mb-0">{{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}</p>
                                                    <p class="mb-0">{{ $jadwal->mapel->nama_mapel }}</p>
                                                    <p class="text-muted small mb-0">Kelas: {{ $jadwal->kelas->nama_kelas }}</p>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="text-center text-muted mt-3"><small>Tidak ada jadwal</small></div>
                                            @endforelse
                                        @else
                                            <div class="text-center text-muted mt-3"><small>Tidak ada jadwal</small></div>
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Tampilan untuk Wali Kelas dan role lain (Staf Admin, Bendahara, dll) --}}
        <div class="col-md-12">
            <div class="card card-table">
                <div class="card-header">
                    <h4 class="card-title">Informasi & Pintasan Cepat</h4>
                </div>
                <div class="card-body">
                    @if(Auth::user()->role == 'wali_kelas')
                        @if(isset($kelasWali))
                            <div class="alert alert-info mb-4">
                                Pada T.A. <strong>{{ $tahunAjaranAktif->nama ?? '' }}</strong>, Anda adalah Wali Kelas untuk <strong>{{ $kelasWali->nama_kelas }}</strong> dengan <strong>{{ $kelasWali->kelas_siswa_count }}</strong> siswa.
                            </div>
                        @else
                            <div class="alert alert-warning mb-4">
                                Anda belum ditugaskan sebagai Wali Kelas pada tahun ajaran yang dipilih saat ini.
                            </div>
                        @endif
                    @endif

                    <div class="d-flex flex-wrap gap-2">
                        @if(Auth::user()->role == 'wali_kelas')
                            <a href="{{ route('absensi.index') }}" class="btn btn-primary"><i class="fas fa-calendar-check me-2"></i>Kelola Absensi Kelas</a>
                            <a href="{{ route('rekap-nilai.index') }}" class="btn btn-info"><i class="fas fa-file-invoice me-2"></i>Lihat Rekap Nilai</a>
                            <a href="{{ route('rapor.index') }}" class="btn btn-warning"><i class="fas fa-book-open me-2"></i>Proses Rapor Siswa</a>
                        @elseif(Auth::user()->role == 'staf_administrasi')
                            <a href="{{ route('admin.ppdb.index') }}" class="btn btn-primary"><i class="fas fa-clipboard-list me-2"></i>Manajemen PPDB</a>
                            <a href="{{ route('guru.index') }}" class="btn btn-info"><i class="fas fa-chalkboard-teacher me-2"></i>Kelola Data Guru</a>
                            <a href="{{ route('users.index') }}" class="btn btn-warning"><i class="fas fa-users-cog me-2"></i>Kelola Pengguna</a>
                        @elseif(Auth::user()->role == 'wakasek_kurikulum')
                            <a href="{{ route('kelas.index') }}" class="btn btn-primary"><i class="fas fa-chalkboard me-2"></i>Manajemen Kelas</a>
                            <a href="{{ route('jadwal.index') }}" class="btn btn-info"><i class="fas fa-calendar-day me-2"></i>Kelola Jadwal Pelajaran</a>
                        @elseif(Auth::user()->role == 'bendahara')
                            <a href="{{ route('keuangan.ppdb.index') }}" class="btn btn-primary"><i class="fas fa-dollar-sign me-2"></i>Pembayaran PPDB</a>
                            <a href="{{ route('keuangan.tagihan.index') }}" class="btn btn-info"><i class="fas fa-file-invoice-dollar me-2"></i>Tagihan Siswa</a>
                        @else
                            <p>Tidak ada pintasan cepat untuk peran Anda.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection