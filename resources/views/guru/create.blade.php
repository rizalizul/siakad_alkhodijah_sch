@extends('layouts.app')
@section('title', 'Tambah Guru')
@section('content')
<div class="page-header"><div class="row align-items-center"><div class="col-sm-12"><div class="page-sub-header"><h3 class="page-title">Tambah Guru</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Guru</a></li><li class="breadcrumb-item active">Tambah</li></ul></div></div></div></div>
<div class="row">
    <div class="col-sm-12"><div class="card comman-shadow"><div class="card-body">
        <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12"><h5 class="form-title"><span>Informasi Guru</span></h5></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Nama Lengkap <span class="login-danger">*</span></label><input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>@error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Email <span class="login-danger">*</span></label><input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>NIP</label><input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}">@error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                {{-- PERBAIKAN: Tambah Jenis Kelamin --}}
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Jenis Kelamin <span class="login-danger">*</span></label><select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" required><option value="">Pilih</option><option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option><option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option></select>@error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>No. Telepon</label><input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') }}">@error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Alamat</label><textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>@error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                {{-- PERBAIKAN: Tambah Foto --}}
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Foto</label><input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">@error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-12"><div class="student-submit"><button type="submit" class="btn btn-success">Simpan</button></div></div>
            </div>
        </form>
    </div></div></div>
</div>
@endsection