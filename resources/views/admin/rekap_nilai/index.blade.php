@extends('layouts.app')
@section('title', 'Rekap Nilai Siswa')
@section('content')
<div class="page-header"><div class="row"><div class="col"><h3 class="page-title">Wali Kelas</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Rekap Nilai Siswa</li></ul></div></div></div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Rekap Nilai Siswa Kelas: {{ $kelas->nama_kelas }}</h3>
                            <p class="text-muted">Tahun Ajaran: {{ $tahunAjaranAktif->nama }} - Semester: {{ $tahunAjaranAktif->semester }}</p>
                        </div>
                        <div class="col-auto text-end float-end ms-auto">
                            <a href="{{ route('rekap-nilai.cetak') }}" target="_blank" class="btn btn-primary"><i class="fas fa-print"></i> Cetak PDF</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="2" class="align-middle">NO</th>
                                <th rowspan="2" class="align-middle">NAMA SISWA</th>
                                <th colspan="{{ $mataPelajaranList->count() }}">NILAI AKHIR</th>
                                <th rowspan="2" class="align-middle">JUMLAH</th>
                                <th rowspan="2" class="align-middle">RATA-RATA</th>
                                <th rowspan="2" class="align-middle">RANKING</th>
                            </tr>
                            <tr>
                                @foreach($mataPelajaranList as $mapel)
                                <th style="writing-mode: vertical-rl; transform: rotate(180deg); white-space: nowrap;">{{ $mapel->nama_mapel }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataRekap as $rekap)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $rekap['siswa']->nama }}</td>
                                @foreach($mataPelajaranList as $mapel)
                                <td class="text-center">{{ $rekap['nilai_akhir'][$mapel->id] }}</td>
                                @endforeach
                                <td class="text-center"><strong>{{ $rekap['jumlah'] }}</strong></td>
                                <td class="text-center"><strong>{{ number_format($rekap['rata_rata'], 2) }}</strong></td>
                                <td class="text-center"><strong>{{ $rekap['ranking'] }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection