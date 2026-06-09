@extends('layouts.app')
@section('title', 'Jadwal Pelajaran')
@section('content')
<div class="page-header"><div class="row"><div class="col"><h3 class="page-title">Akademik</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Jadwal Pelajaran</li></ul></div></div></div>
@if (session('error'))<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal!</strong> {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">
                <div class="page-header"><div class="row align-items-center"><div class="col"><h3 class="page-title">Pilih Kelas untuk Mengelola Jadwal (T.A. {{ $tahunAjaranAktif->nama }})</h3></div></div></div>
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0 datatable">
                        <thead><tr><th>#</th><th>Nama Kelas</th><th>Tingkat</th><th>Wali Kelas</th><th class="text-end">Aksi</th></tr></thead>
                        <tbody>
                            @foreach ($kelases as $kelas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kelas->nama_kelas }}</td><td>{{ $kelas->tingkat_kelas }}</td><td>{{ $kelas->waliKelas->nama ?? '-' }}</td>
                                <td class="text-end"><a href="{{ route('jadwal.show', $kelas->id) }}" class="btn btn-sm btn-warning">Lihat & Kelola Jadwal</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection