@extends('ortu.layouts.app')
@section('title', 'Dashboard Siswa')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-sub-header">
                <h3 class="page-title">Informasi Akademik: {{ $siswa->nama }}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Kelas: {{ $kelasSiswa->kelas->nama_kelas }} | Wali Kelas: {{ $kelasSiswa->kelas->waliKelas->nama ?? '-' }}</li>
                    {{-- Tampilkan Tahun Ajaran & Semester --}}
                    <li class="breadcrumb-item active ms-auto">T.A. {{ $tahunAjaranAktif->nama }} - Semester {{ $tahunAjaranAktif->semester }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card"><div class="card-body">
            <h5 class="card-title">Rekap Nilai Semester</h5>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Mata Pelajaran</th>
                            <th>Rata-rata TP</th>
                            <th>STS</th>
                            <th>SAS</th>
                            <th>Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nilaiAkademikLengkap as $nilai)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $nilai['mapel']->nama_mapel }}</td>
                            <td class="text-center">{{ $nilai['rata_rata_tp'] ?? '-' }}</td>
                            <td class="text-center">{{ $nilai['sts'] ?? '-' }}</td>
                            <td class="text-center">{{ $nilai['sas'] ?? '-' }}</td>
                            <td class="text-center"><strong>{{ $nilai['nilai_akhir'] }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <small class="form-text text-muted mt-2">* Ini bukan merupakan nilai rapor akhir yang sebenarnya.</small>
        </div></div>
    </div>
    <div class="col-lg-4">
        <div class="card"><div class="card-body">
            <h5 class="card-title">Rekap Absensi Semester</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">Sakit<span class="badge bg-warning rounded-pill">{{ $rekapAbsensi->get('Sakit', 0) }} hari</span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Izin<span class="badge bg-info rounded-pill">{{ $rekapAbsensi->get('Izin', 0) }} hari</span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Tanpa Keterangan<span class="badge bg-danger rounded-pill">{{ $rekapAbsensi->get('Tanpa Keterangan', 0) }} hari</span></li>
            </ul>
            <a href="{{ route('ortu.absensi.detail') }}" class="btn btn-outline-primary btn-sm mt-3">Lihat Detail Absensi Bulanan</a>
        </div></div>
    </div>
    <div class="col-12">
        <div class="card"><div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Jadwal Pelajaran</h5>
                <a href="{{ route('ortu.jadwal.cetak') }}" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-print"></i> Cetak Jadwal</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center"><tr>@foreach($hari as $h)<th>{{ $h }}</th>@endforeach</tr></thead>
                    <tbody><tr>@foreach($hari as $h)<td class="p-2" style="vertical-align: top;">@if(isset($jadwals[$h]))@foreach($jadwals[$h] as $jadwal)<div class="p-1 mb-1 bg-light rounded border"><p class="fw-bold mb-0">{{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}</p><p class="mb-0">{{ $jadwal->mapel->nama_mapel }}</p><p class="text-muted small mb-0">{{ $jadwal->guru->nama }}</p></div>@endforeach @endif</td>@endforeach</tr></tbody>
                </table>
            </div>
        </div></div>
    </div>
</div>
@endsection