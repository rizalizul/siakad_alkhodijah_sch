@extends('layouts.app')
@section('title', 'Manajemen Mata Pelajaran')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <h3 class="page-title">Data Master</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Mata Pelajaran</li>
            </ul>
        </div>
    </div>
</div>
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Sukses!</strong> {{ session('success') }}
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
                            <h3 class="page-title">Data Mata Pelajaran</h3>
                        </div>
                        <div class="col-auto text-end float-end ms-auto download-grp">
                            <a href="{{ route('mata-pelajaran.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Mata Pelajaran</th>
                                <th>Kelompok</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mapels as $mapel)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mapel->nama_mapel }}</td>
                                <td>{{ ucwords($mapel->kelompok) }}</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="{{ route('mata-pelajaran.edit', $mapel->id) }}" class="btn btn-sm bg-warning-light me-2"><i class="far fa-edit"></i></a>
                                        <form action="{{ route('mata-pelajaran.destroy', $mapel->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus mata pelajaran ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm bg-danger-light"><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </div>
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