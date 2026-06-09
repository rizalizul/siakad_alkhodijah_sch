@extends('layouts.app')
@section('title', 'Manajemen Rapor')
@section('content')
<div class="page-header"><div class="row"><div class="col"><h3 class="page-title">Wali Kelas</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Manajemen Rapor</li></ul></div></div></div>
@if (session('success'))<div class="alert alert-success alert-dismissible fade show"><strong>Sukses!</strong> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
<div class="row">
    <div class="col-md-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header"><div class="row align-items-center"><div class="col"><h3 class="page-title">Daftar Siswa Kelas {{ $kelas->nama_kelas }}</h3></div></div></div>
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0 datatable">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Status Rapor</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftarSiswa as $item)
                            <tr>
                                <td>{{ $item->siswa->nis }}</td>
                                <td>{{ $item->siswa->nama }}</td>
                                <td><span class="badge badge-{{ $item->rapor?->status_rapor == 'ditandatangani' ? 'success' : ($item->rapor?->status_rapor == 'final' ? 'warning' : 'info') }}">{{ Str::ucfirst($item->rapor?->status_rapor ?? 'Belum Diproses') }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('rapor.proses', $item->id) }}" class="btn btn-sm bg-success-light">
                                        <i class="fas fa-edit"></i> Proses Rapor
                                    </a>
                                    {{-- <a href="{{ route('rapor.cetak', $item->rapor->id) }}" target="_blank" class="btn btn-sm bg-info-light"><i class="fas fa-print"></i> Cetak</a> --}}
                                    @if($item->rapor?->status_rapor == 'final')
                                    <a href="{{ route('rapor.cetak', $item->rapor->id) }}" target="_blank" class="btn btn-sm bg-info-light"><i class="fas fa-print"></i> Cetak Rapor</a>
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