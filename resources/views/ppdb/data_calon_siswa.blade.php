@extends('layouts.app')
@section('title', 'Data Calon Siswa')
@section('content')

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Data Calon Siswa</h3>
        </div>
    </div>
</div>

<div class="card card-table comman-shadow">
    <div class="card-body">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Data Calon</h3>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ route('ppdb.formulir') }}" class="btn btn-success"><i class="fas fa-plus"></i> Form PPDB</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Nama Ayah</th>
                        <th>No. WA Ortu</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $item->tempat_lahir }}, {{ $item->tanggal_lahir }}</td>
                        <td>{{ $item->nama_ayah }}</td>
                        <td>{{ $item->no_wa_ortu }}</td>
                        <td>
                            <span class="badge bg-{{ $item->status == 'diterima' ? 'success' : ($item->status == 'ditolak' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('ppdb.verifikasi', $item->id) }}" class="btn btn-sm btn-primary">Verifikasi</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
