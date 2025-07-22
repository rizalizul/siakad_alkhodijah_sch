@extends('layouts.app')
@section('title', 'Detail Siswa')
@section('content')

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Detail Siswa</h3>
        </div>
        <div class="col-auto">
            <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body row">
        <div class="col-md-3 text-center">
            @if ($siswa->foto)
                <img src="{{ asset('storage/'.$siswa->foto) }}" class="img-fluid mb-3" width="150" alt="Foto Siswa">
                <p>{{ $siswa->nama }}</p>
                <p>Kelas </p>
            @else
                <p>Tidak Ada</p>
            @endif
        </div>
        <div class="col-md-9">
            <h5 class="mb-3">Biodata Siswa</h5>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ $siswa->nama }}</p>
                    <p><strong>NISN:</strong> {{ $siswa->nisn }}</p>
                    <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
                    <p><strong>Nama Panggilan:</strong> {{ $siswa->nama_panggilan }}</p>
                    <p><strong>Tempat, Tanggal Lahir:</strong> {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}</p>
                    <p><strong>Jenis Kelamin:</strong> {{ $siswa->jenis_kelamin }}</p>
                    <p><strong>Agama:</strong> {{ $siswa->agama }}</p>
                    <p><strong>Agama:</strong> {{ $siswa->pendidikan_sebelumnya }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Alamat Siswa:</strong><br /> {{ $siswa->alamat_siswa }}</p>
                    <p><strong>Ayah:</strong> {{ $siswa->nama_ayah }}</p>
                    <p><strong>Ibu:</strong> {{ $siswa->nama_ibu }}</p>
                    <p><strong>Pekerjaan Ayah:</strong> {{ $siswa->pekerjaan_ayah }}</p>
                    <p><strong>Pekerjaan Ibu:</strong> {{ $siswa->pekerjaan_ibu }}</p>
                </div>
            </div>
            <hr />
            <h5 class="mb-3">Informasi Tambahan</h5>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Alamat Ortu:</strong><br /> {{ $siswa->alamat_ortu }}</p>
                    <p><strong>No WA Ortu:</strong> {{ $siswa->no_wa_ortu }}</p>
                    <p><strong>Kelurahan:</strong> {{ $siswa->kelurahan }}</p>
                    <p><strong>Kecamatan:</strong> {{ $siswa->kecamatan }}</p>
                    <p><strong>Kota:</strong> {{ $siswa->kota }}</p>
                    <p><strong>Provinsi:</strong> {{ $siswa->provinsi }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Nama Wali:</strong> {{ $siswa->nama_wali }}</p>
                    <p><strong>Pekerjaan Wali:</strong> {{ $siswa->pekerjaan_wali }}</p>
                    <p><strong>Alamat Wali:</strong> {{ $siswa->alamat_wali }}</p>
                </div>
            </div>
            <hr />
            <h5 class="mb-3">Dokumen</h5>
            <ul class="list-unstyled">
                <li><i class="far fa-file-pdf text-danger me-2"></i> <a href="#">Kartu Keluarga</a></li>
                <li><i class="far fa-file-pdf text-danger me-2"></i> <a href="#">KTP Ayah</a></li>
                <li><i class="far fa-file-pdf text-danger me-2"></i> <a href="#">KTP Ibu</a></li>
                <li><i class="far fa-file-pdf text-danger me-2"></i> <a href="#">Akta Kelahiran</a></li>
                <li><i class="far fa-file text-secondary me-2"></i> <a href="#">KTA</a></li>
            </ul>
        </div>
    </div>
</div>

@endsection