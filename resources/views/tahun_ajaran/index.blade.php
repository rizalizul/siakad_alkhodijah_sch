@extends('layouts.app')
@section('title', 'Manajemen Tahun Ajaran')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <h3 class="page-title">Data Master</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Tahun Ajaran</li>
            </ul>
        </div>
    </div>
</div>

{{-- Pesan Sukses --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Sukses!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Gagal!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


<div class="row">
    <div class="col-md-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Data Tahun Ajaran</h3>
                        </div>
                        <div class="col-auto text-end float-end ms-auto download-grp">
                            <a href="{{ route('tahun-ajaran.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Tahun Ajaran</th>
                                <th>Semester</th>
                                <th>Status T.A</th>
                                <th>Status PPDB</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tahunAjarans as $ta)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ta->nama }}</td>
                                <td>{{ $ta->semester }}</td>
                                <td>
                                    @if ($ta->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($ta->is_ppdb_open)
                                        <span class="badge badge-warning">Pendaftaran Dibuka</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="actions">
                                        @if (!$ta->is_active)
                                            <form action="{{ route('tahun-ajaran.setActive', $ta->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin mengaktifkan tahun ajaran ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm bg-success-light me-2" title="Jadikan Tahun Ajaran Aktif">Aktifkan T.A</button>
                                            </form>
                                        @endif
                                        
                                        @if ($ta->is_ppdb_open)
                                            <form action="{{ route('tahun-ajaran.closePpdb', $ta->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menutup pendaftaran untuk tahun ajaran ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm bg-danger-light me-2" title="Tutup Pendaftaran Untuk Tahun Ajaran Ini">Tutup PPDB</button>
                                            </form>
                                        @else
                                            <form action="{{ route('tahun-ajaran.setPpdb', $ta->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin membuka pendaftaran untuk tahun ajaran ini? Hanya satu tahun ajaran yang bisa dibuka pendaftarannya.');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm bg-warning-light me-2" title="Buka Pendaftaran Untuk Tahun Ajaran Ini">Buka PPDB</button>
                                            </form>
                                        @endif
                                        
                                        <a href="{{ route('tahun-ajaran.edit', $ta->id) }}" class="btn btn-sm bg-info-light me-2">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <form action="{{ route('tahun-ajaran.destroy', $ta->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm bg-danger-light">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data tahun ajaran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection