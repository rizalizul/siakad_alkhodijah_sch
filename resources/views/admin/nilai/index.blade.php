@extends('layouts.app')
@section('title', 'Pengelolaan Nilai')
@section('content')
<div class="page-header"><div class="row"><div class="col"><h3 class="page-title">Guru</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Pengelolaan Nilai</li></ul></div></div></div>
@if (session('success'))<div class="alert alert-success alert-dismissible fade show"><strong>Sukses!</strong> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
<div class="row">
    <div class="col-sm-12">
        <div class="card comman-shadow">
            <div class="card-body">
                <h5 class="card-title">Pilih Kelas dan Mata Pelajaran</h5>
                <form action="{{ route('nilai.manage') }}" method="GET">
                    <div class="row">
                        <div class="col-md-5"><div class="form-group local-forms"><label>Kelas</label><select name="kelas_id" class="form-control" required><option value="">Pilih Kelas</option>@foreach($kelases as $kelas)<option value="{{$kelas->id}}">{{$kelas->nama_kelas}}</option>@endforeach</select></div></div>
                        <div class="col-md-5"><div class="form-group local-forms"><label>Mata Pelajaran</label><select name="mapel_id" class="form-control" required><option value="">Pilih Mata Pelajaran</option>@foreach($mapels as $mapel)<option value="{{$mapel->id}}">{{$mapel->nama_mapel}}</option>@endforeach</select></div></div>
                        <div class="col-md-2"><div class="form-group local-forms"><button type="submit" class="btn btn-success w-100">Buka Nilai</button></div></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection