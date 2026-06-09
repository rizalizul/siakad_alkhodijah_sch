@extends('layouts.app')
@section('title', 'Tagihan Siswa')
@section('content')
<div class="page-header"><div class="row"><div class="col"><h3 class="page-title">Keuangan</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Tagihan Siswa</li></ul></div></div></div>
<div class="row">
    <div class="col-sm-12">
        <div class="card comman-shadow">
            <div class="card-body">
                <h5 class="card-title">Cari Siswa</h5>
                <form action="{{ route('keuangan.tagihan.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-10"><div class="form-group local-forms"><input type="text" name="search" class="form-control" placeholder="Masukkan Nama, NIS, atau No. Pendaftaran..." value="{{ $searchTerm ?? '' }}"></div></div>
                        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100">Cari</button></div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-table">
            <div class="card-body">
                @if(!empty($searchTerm))
                    <h5 class="card-title">Hasil Pencarian untuk: "{{ $searchTerm }}"</h5>
                @else
                    <h5 class="card-title">Daftar Siswa & Calon Siswa (Tahap Pembayaran)</h5>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIS / No. Pendaftaran</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->nis ?? $siswa->no_pendaftaran }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>{{ optional($siswa->kelasSiswa->last())->kelas->nama_kelas ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $siswa->status == 'aktif' ? 'bg-success-light' : 'bg-info-light' }}">
                                        {{ Str::ucfirst(str_replace('_', ' ', $siswa->status)) }}
                                    </span>
                                </td>
                                <td class="text-end"><a href="{{ route('keuangan.tagihan.detail', $siswa->id) }}" class="btn btn-sm btn-primary">Lihat Tagihan</a></td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center">Siswa tidak ditemukan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection