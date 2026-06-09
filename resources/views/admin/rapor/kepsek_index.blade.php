@extends('layouts.app')
@section('title', 'Persetujuan Rapor')
@section('content')
<div class="page-header"><div class="row"><div class="col"><h3 class="page-title">Kepala Sekolah</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Persetujuan Rapor</li></ul></div></div></div>
@if (session('success'))<div class="alert alert-success alert-dismissible fade show"><strong>Sukses!</strong> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
<div class="row">
    <div class="col-md-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header"><div class="row align-items-center"><div class="col"><h3 class="page-title">Daftar Rapor Menunggu Persetujuan</h3></div></div></div>
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0 datatable">
                        <thead><tr><th>Nama Siswa</th><th>Kelas</th><th>Wali Kelas</th><th class="text-end">Aksi</th></tr></thead>
                        <tbody>
                            @foreach ($rapors as $rapor)
                            <tr>
                                <td>{{ $rapor->kelasSiswa->siswa->nama }}</td>
                                <td>{{ $rapor->kelasSiswa->kelas->nama_kelas }}</td>
                                <td>{{ $rapor->kelasSiswa->kelas->waliKelas->nama }}</td>
                                <td class="text-end">
                                    <form action="{{ route('rapor.kepsek.approve', $rapor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menyetujui rapor ini?');">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm bg-success-light"><i class="fas fa-check"></i> Setujui</button>
                                    </form>
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