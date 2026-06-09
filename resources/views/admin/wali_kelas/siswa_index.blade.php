@extends('layouts.app')
@section('title', 'Data Siswa')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <h3 class="page-title">Wali Kelas</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Siswa</li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Daftar Siswa Kelas: {{ $kelas->nama_kelas }}</h3>
                        </div>
                        <div class="col-auto text-end float-end ms-auto">
                            {{-- Tombol cetak bisa ditambahkan di sini nanti jika diperlukan --}}
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0 datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Nama Orang Tua</th>
                                <th>No. WA Orang Tua</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($daftarSiswa as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ $item->siswa->foto ? Storage::url($item->siswa->foto) : asset('assets/img/profiles/avatar-01.jpg') }}" class="rounded-circle" width="40" height="40" alt="Foto Siswa">
                                </td>
                                <td>{{ $item->siswa->nis ?? '-' }}</td>
                                <td>{{ $item->siswa->nama }}</td>
                                <td>{{ $item->siswa->jenis_kelamin }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->siswa->tanggal_lahir)->format('d-m-Y') }}</td>
                                <td>{{ $item->siswa->nama_ayah }}</td>
                                <td>{{ $item->siswa->no_wa_ortu }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada siswa di kelas ini.</td>
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