@extends('layouts.app')
@section('title', 'Buat Kelas Baru')
@section('content')
<div class="page-header"><div class="row align-items-center"><div class="col-sm-12"><div class="page-sub-header"><h3 class="page-title">Buat Kelas Baru</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('kelas.index') }}">Manajemen Kelas</a></li><li class="breadcrumb-item active">Buat Kelas</li></ul></div></div></div></div>
<div class="row">
    <div class="col-sm-12"><div class="card comman-shadow"><div class="card-body">
        <form action="{{ route('kelas.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12"><h5 class="form-title"><span>Informasi Kelas</span></h5></div>
                <div class="col-12 col-sm-4"><div class="form-group local-forms"><label>Nama Kelas <span class="login-danger">*</span></label><input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: 1-A" required></div></div>
                <div class="col-12 col-sm-4"><div class="form-group local-forms"><label>Tingkat Kelas <span class="login-danger">*</span></label><select name="tingkat_kelas" class="form-control" required><option value="">Pilih Tingkat</option>@for($i=1; $i<=6; $i++)<option value="{{$i}}">Kelas {{ $i }}</option>@endfor</select></div></div>
                <div class="col-12 col-sm-4"><div class="form-group local-forms"><label>Wali Kelas <span class="login-danger">*</span></label><select name="wali_kelas_id" class="form-control" required><option value="">Pilih Wali Kelas</option>@foreach($gurus as $guru)<option value="{{ $guru->id }}">{{ $guru->nama }}</option>@endforeach</select></div></div>
                <div class="col-12"><div class="student-submit"><button type="submit" class="btn btn-success">Simpan</button></div></div>
            </div>
        </form>
    </div></div></div>
</div>
@endsection