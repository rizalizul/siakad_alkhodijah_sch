@extends('layouts.app')
@section('title', 'Edit Guru')
@section('content')
<div class="page-header"><div class="row align-items-center"><div class="col-sm-12"><div class="page-sub-header"><h3 class="page-title">Edit Guru</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Guru</a></li><li class="breadcrumb-item active">Edit</li></ul></div></div></div></div>
<div class="row">
    <div class="col-sm-12"><div class="card comman-shadow"><div class="card-body">
        <form action="{{ route('guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12"><h5 class="form-title"><span>Informasi Guru</span></h5></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Nama Lengkap <span class="login-danger">*</span></label><input type="text" name="nama" class="form-control" value="{{ old('nama', $guru->nama) }}" required></div></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Email <span class="login-danger">*</span></label><input type="email" name="email" class="form-control" value="{{ old('email', $guru->email) }}" required></div></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>NIP</label><input type="text" name="nip" class="form-control" value="{{ old('nip', $guru->nip) }}"></div></div>
                {{-- PERBAIKAN: Tambah Jenis Kelamin --}}
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Jenis Kelamin <span class="login-danger">*</span></label><select name="jenis_kelamin" class="form-control" required><option value="Laki-laki" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option><option value="Perempuan" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option></select></div></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>No. Telepon</label><input type="text" name="telepon" class="form-control" value="{{ old('telepon', $guru->telepon) }}"></div></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Alamat</label><textarea name="alamat" class="form-control">{{ old('alamat', $guru->alamat) }}</textarea></div></div>
                {{-- PERBAIKAN: Tambah Foto --}}
                <div class="col-12 col-sm-6">
                    <div class="form-group local-forms">
                        <label>Ganti Foto (Opsional)</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <label>Foto Saat Ini</label><br>
                    <img src="{{ $guru->foto ? Storage::url($guru->foto) : asset('assets/img/profiles/avatar-01.jpg') }}" class="img-thumbnail" width="100" alt="Foto Guru">
                </div>
                <div class="col-12"><div class="student-submit"><button type="submit" class="btn btn-success">Ubah</button></div></div>
            </div>
        </form>
    </div></div></div>
</div>
@endsection