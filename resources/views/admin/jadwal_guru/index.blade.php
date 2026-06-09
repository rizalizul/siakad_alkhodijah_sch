@extends('layouts.app')
@section('title', 'Jadwal Mengajar')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <h3 class="page-title">Guru</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Jadwal Mengajar</li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Jadwal Mengajar Anda &nbsp;</h3>
                            <h5>Tahun Ajaran: {{ $tahunAjaranAktif->nama }}</h5>
                        </div>
                        <div class="col-auto text-end float-end ms-auto">
                            <a href="{{ route('jadwal-guru.cetak') }}" target="_blank" class="btn btn-primary"><i class="fas fa-print"></i> Cetak Jadwal</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table border star-student table-hover table-center table-borderless table-striped">
                        <thead class="thead-light">
                            <tr>
                                @foreach($hari as $h)
                                <th>{{ $h }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($hari as $h)
                                <td class="p-2" style="vertical-align: top;">
                                    @if(isset($jadwals[$h]))
                                        @foreach($jadwals[$h] as $jadwal)
                                        <div class="card shadow-sm border bg-light mb-2">
                                            <div class="card-body p-2">
                                                <p class="font-weight-bold mb-0">{{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}</p>
                                                <p class="mb-0">{{ $jadwal->mapel->nama_mapel }}</p>
                                                <p class="text-muted small mb-1">Kelas: {{ $jadwal->kelas->nama_kelas }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="text-center text-muted mt-3">
                                            <small>Tidak ada jadwal</small>
                                        </div>
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection