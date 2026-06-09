@extends('layouts.app')
@section('title', 'Manajemen PPDB')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <h3 class="page-title">Penerimaan Siswa</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Manajemen PPDB</li>
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
                            <h3 class="page-title">Data Pendaftar Siswa Baru</h3>
                        </div>
                        <div class="col-auto text-end float-end ms-auto">
                            <a href="{{ route('ppdb.create') }}" target="_blank" class="btn btn-success">
                                <i class="fas fa-plus"></i>
                            Tambah Siswa Baru</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Pendaftaran</th>
                                <th>Nama Calon Siswa</th>
                                <th>Tanggal Daftar</th>
                                <th>Nama Ayah</th>
                                {{-- <th>No. WA Ortu</th> --}}
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($calonSiswa as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->no_pendaftaran }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>{{ $siswa->created_at->isoFormat('D MMM Y') }}</td>
                                <td>{{ $siswa->nama_ayah }}</td>
                                {{-- <td>{{ $siswa->no_wa_ortu }}</td> --}}
                                <td>
                                    @php
                                        $statusClass = [
                                            'calon' => 'badge-info',
                                            'diverifikasi' => 'badge-primary',
                                            'menunggu_screening' => 'badge-warning',
                                            'tidak_diterima' => 'badge-danger',
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusClass[$siswa->status] ?? 'badge-secondary' }}">
                                        {{ Str::ucfirst(str_replace('_', ' ', $siswa->status)) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    @if($siswa->status == 'calon')
                                        <a href="{{ route('admin.ppdb.show', $siswa->id) }}" class="btn btn-sm bg-info-light">
                                            <i class="far fa-eye"></i> Detail & Verifikasi
                                        </a>
                                    @else
                                        <a href="{{ route('admin.ppdb.show', $siswa->id) }}" class="btn btn-sm bg-info-light">
                                            <i class="far fa-eye"></i> Lihat Detail
                                        </a>
                                    @endif
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