@extends('layouts.app')
@section('title', 'Tambah Ekstrakurikuler')
@section('content')
<div class="page-header"><div class="row align-items-center"><div class="col-sm-12"><div class="page-sub-header"><h3 class="page-title">Tambah Ekstrakurikuler</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('ekstrakurikuler.index') }}">Ekstrakurikuler</a></li><li class="breadcrumb-item active">Tambah</li></ul></div></div></div></div>
<div class="row">
    <div class="col-sm-12"><div class="card comman-shadow"><div class="card-body">
        <form action="{{ route('ekstrakurikuler.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12"><h5 class="form-title"><span>Informasi Ekstrakurikuler</span></h5></div>
                <div class="col-12"><div class="form-group local-forms"><label>Nama Ekstrakurikuler <span class="login-danger">*</span></label><input type="text" name="nama_ekskul" class="form-control @error('nama_ekskul') is-invalid @enderror" value="{{ old('nama_ekskul') }}" required>@error('nama_ekskul')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-12"><div class="student-submit"><button type="submit" class="btn btn-success">Simpan</button></div></div>
            </div>
        </form>
    </div></div></div>
</div>
@endsection