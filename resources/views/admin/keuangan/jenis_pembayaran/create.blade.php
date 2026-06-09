@extends('layouts.app')
@section('title', 'Tambah Jenis Pembayaran')
@section('content')
<div class="page-header"><div class="row align-items-center"><div class="col-sm-12"><div class="page-sub-header"><h3 class="page-title">Tambah Jenis Pembayaran</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('keuangan.jenis-pembayaran.index') }}">Jenis Pembayaran</a></li><li class="breadcrumb-item active">Tambah</li></ul></div></div></div></div>
<div class="row">
    <div class="col-sm-12"><div class="card comman-shadow"><div class="card-body">
        <form action="{{ route('keuangan.jenis-pembayaran.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12"><h5 class="form-title"><span>Informasi Pembayaran</span></h5></div>
                <div class="col-12 col-sm-4"><div class="form-group local-forms"><label>Nama Jenis <span class="login-danger">*</span></label><input type="text" name="nama_jenis" class="form-control" required></div></div>
                <div class="col-12 col-sm-4"><div class="form-group local-forms"><label>Jumlah Default (Rp) <span class="login-danger">*</span></label><input type="number" name="jumlah_default" class="form-control" required></div></div>
                <div class="col-12 col-sm-4"><div class="form-group local-forms"><label>Untuk Tahun Ajaran <span class="login-danger">*</span></label>
                    {{-- PERBAIKAN: Dropdown sekarang menampilkan tahun ajaran --}}
                    <select name="tahun_ajaran_nama" class="form-control" required>
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach($tahunAjarans as $ta)
                            <option value="{{ $ta->nama }}" {{ old('tahun_ajaran_nama') == $ta->nama ? 'selected' : '' }}>{{ $ta->nama }}</option>
                        @endforeach
                    </select>
                </div></div>
                <div class="col-12"><div class="student-submit"><button type="submit" class="btn btn-success">Simpan</button></div></div>
            </div>
        </form>
    </div></div></div>
</div>
@endsection