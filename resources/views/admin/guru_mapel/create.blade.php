@extends('layouts.app')
@section('title', 'Buat Penugasan Guru')
@section('content')
<div class="page-header"><div class="row align-items-center"><div class="col-sm-12"><div class="page-sub-header"><h3 class="page-title">Buat Penugasan Guru</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('guru-mapel.index') }}">Penugasan Guru</a></li><li class="breadcrumb-item active">Buat Penugasan</li></ul></div></div></div></div>
<div class="row">
    <div class="col-sm-12"><div class="card comman-shadow"><div class="card-body">
        <form action="{{ route('guru-mapel.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12"><h5 class="form-title"><span>Informasi Penugasan</span></h5></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Guru <span class="login-danger">*</span></label><select name="guru_id" class="form-control" required><option value="">Pilih Guru</option>@foreach($gurus as $guru)<option value="{{ $guru->id }}">{{ $guru->nama }}</option>@endforeach</select></div></div>
                <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Mata Pelajaran <span class="login-danger">*</span></label><select name="mapel_id" class="form-control" required><option value="">Pilih Mata Pelajaran</option>@foreach($mapels as $mapel)<option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>@endforeach</select></div></div>
                <div class="col-12"><div class="student-submit"><button type="submit" class="btn btn-success">Simpan</button></div></div>
            </div>
        </form>
    </div></div></div>
</div>
@endsection