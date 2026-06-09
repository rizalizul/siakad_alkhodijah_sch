@extends('layouts.app')
@section('title', 'Edit Mata Pelajaran')
@section('content')
<div class="page-header"><div class="row align-items-center"><div class="col-sm-12"><div class="page-sub-header"><h3 class="page-title">Edit Mata Pelajaran</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('mata-pelajaran.index') }}">Mata Pelajaran</a></li><li class="breadcrumb-item active">Edit</li></ul></div></div></div></div>
<div class="row">
    <div class="col-sm-12"><div class="card comman-shadow"><div class="card-body">
        <form action="{{ route('mata-pelajaran.update', $mataPelajaran->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12"><h5 class="form-title"><span>Informasi Mata Pelajaran</span></h5></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Nama Mata Pelajaran <span class="login-danger">*</span></label><input type="text" name="nama_mapel" class="form-control @error('nama_mapel') is-invalid @enderror" value="{{ old('nama_mapel', $mataPelajaran->nama_mapel) }}" required>@error('nama_mapel')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Kelompok <span class="login-danger">*</span></label>
                    <select name="kelompok" class="form-control @error('kelompok') is-invalid @enderror" required>
                        <option value="">Pilih Kelompok</option>
                        <option value="Wajib" {{ old('kelompok', $mataPelajaran->kelompok) == 'Wajib' ? 'selected' : '' }}>Wajib</option>
                        <option value="Seni Pilihan" {{ old('kelompok', $mataPelajaran->kelompok) == 'Seni Pilihan' ? 'selected' : '' }}>Seni Pilihan</option>
                        <option value="Muatan Lokal" {{ old('kelompok', $mataPelajaran->kelompok) == 'Muatan Lokal' ? 'selected' : '' }}>Muatan Lokal</option>
                    </select>
                    @error('kelompok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div></div>
                <div class="col-12"><div class="student-submit"><button type="submit" class="btn btn-primary">Ubah</button></div></div>
            </div>
        </form>
    </div></div></div>
</div>
@endsection