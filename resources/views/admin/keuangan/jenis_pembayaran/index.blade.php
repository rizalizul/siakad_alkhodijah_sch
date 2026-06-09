@extends('layouts.app')
@section('title', 'Jenis Pembayaran')
@section('content')
<div class="page-header"><div class="row"><div class="col"><h3 class="page-title">Keuangan</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Jenis Pembayaran</li></ul></div></div></div>
@if (session('success'))<div class="alert alert-success alert-dismissible fade show"><strong>Sukses!</strong> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
@if (session('error'))<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal!</strong> {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
<div class="row">
    <div class="col-md-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header"><div class="row align-items-center"><div class="col"><h3 class="page-title">Daftar Jenis Pembayaran</h3></div><div class="col-auto text-end float-end ms-auto"><a href="{{ route('keuangan.jenis-pembayaran.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah</a></div></div></div>
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0 datatable">
                        <thead><tr><th>#</th><th>Nama Jenis</th><th>Jumlah Default</th><th>Tahun Ajaran</th><th class="text-end">Aksi</th></tr></thead>
                        <tbody>
                            @foreach ($jenisPembayarans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_jenis }}</td>
                                <td>Rp {{ number_format($item->jumlah_default, 0, ',', '.') }}</td>
                                <td>{{ $item->tahun_ajaran_nama ?? '-' }}</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="{{ route('keuangan.jenis-pembayaran.edit', $item->id) }}" class="btn btn-sm bg-warning-light me-2"><i class="far fa-edit"></i></a>
                                        <form action="{{ route('keuangan.jenis-pembayaran.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
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
