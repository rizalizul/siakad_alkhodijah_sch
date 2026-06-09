@extends('ortu.layouts.app')
@section('title', 'Dashboard Siswa')
@section('content')
<div class="page-header"><div class="row"><div class="col-sm-12"><div class="page-sub-header"><h3 class="page-title">Informasi Akademik: {{ $siswa->nama }}</h3></div></div></div></div>
<div class="alert alert-warning">Data akademik untuk tahun ajaran saat ini belum tersedia. Silakan hubungi pihak sekolah untuk informasi lebih lanjut.</div>
@endsection