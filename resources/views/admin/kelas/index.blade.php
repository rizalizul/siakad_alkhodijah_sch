@extends('layouts.app')
@section('title', 'Manajemen Kelas')
@section('content')
<div class="page-header">
    <div class="row"><div class="col"><h3 class="page-title">Akademik</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Manajemen Kelas</li></ul></div></div>
</div>
@if (session('success'))<div class="alert alert-success alert-dismissible fade show"><strong>Sukses!</strong> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
@if (session('error'))<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal!</strong> {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
<div class="row">
    <div class="col-md-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Data Kelas (T.A. {{ $tahunAjaranAktif->nama }})</h3>
                        </div>
                        <div class="col-auto text-end float-end ms-auto">
                            <a href="{{ route('kelas.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Kelas</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0 datatable">
                        <thead><tr><th>#</th><th>Nama Kelas</th><th>Tingkat</th><th>Wali Kelas</th><th>Jumlah Siswa</th><th class="text-center">Aksi</th></tr></thead>
                        <tbody>
                            @foreach ($kelases as $kelas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kelas->nama_kelas }}</td>
                                <td>{{ $kelas->tingkat_kelas }}</td>
                                <td>{{ $kelas->waliKelas->nama ?? 'Belum Ditentukan' }}</td>
                                <td>{{ $kelas->kelasSiswa->count() }} Siswa</td>
                                <td class="text-end">
                                    <a href="{{ route('kelas.show', $kelas->id) }}" class="btn btn-sm bg-warning me-2"><i class="fas fa-users"></i> Kelola Siswa</a>
                                    {{-- TAMBAHKAN TOMBOL CETAK PDF --}}
                                    <a href="{{ route('kelas.cetakSiswa', $kelas->id) }}" target="_blank" class="btn btn-sm bg-info-light me-2"><i class="fas fa-print"></i> Cetak Siswa</a>
                                    <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kelas ini?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm bg-danger-light"><i class="far fa-trash-alt"></i></button></form>
                                </td>
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