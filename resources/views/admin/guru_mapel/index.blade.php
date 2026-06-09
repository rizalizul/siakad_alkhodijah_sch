@extends('layouts.app')
@section('title', 'Penugasan Guru')
@section('content')
<div class="page-header"><div class="row"><div class="col"><h3 class="page-title">Akademik</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Penugasan Guru</li></ul></div></div></div>
@if (session('success'))<div class="alert alert-success alert-dismissible fade show"><strong>Sukses!</strong> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
@if (session('error'))<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal!</strong> {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
<div class="row">
    <div class="col-md-12"><div class="card card-table comman-shadow"><div class="card-body">
        <div class="page-header"><div class="row align-items-center"><div class="col"><h3 class="page-title">Penugasan Guru Mengajar (T.A. {{ $tahunAjaranAktif->nama }})</h3></div><div class="col-auto text-end float-end ms-auto"><a href="{{ route('guru-mapel.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Buat Penugasan</a></div></div></div>
        <div class="table-responsive">
            <table class="table table-hover table-center mb-0 datatable">
                <thead><tr><th>#</th><th>Nama Guru</th><th>Mata Pelajaran</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @foreach ($penugasan as $tugas)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tugas->guru->nama ?? '' }}</td>
                        <td>{{ $tugas->mapel->nama_mapel ?? '' }}</td>
                        <td class="text-end">
                            <form action="{{ route('guru-mapel.destroy', $tugas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus penugasan ini?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm bg-danger-light"><i class="far fa-trash-alt"></i></button></form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div></div></div>
</div>
@endsection