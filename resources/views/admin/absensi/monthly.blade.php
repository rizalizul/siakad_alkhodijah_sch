@extends('layouts.app')
@section('title', 'Laporan Absensi Bulanan')
@section('content')
<div class="page-header"><div class="row"><div class="col"><h3 class="page-title">Wali Kelas</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('absensi.index') }}">Absensi Kelas</a></li><li class="breadcrumb-item active">Laporan Bulanan</li></ul></div></div></div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header"><div class="row align-items-center"><div class="col"><h3 class="page-title">Laporan Absensi Kelas {{ $kelas->nama_kelas }} - Bulan: {{ $bulan->isoFormat('MMMM Y') }}</h3></div><div class="col-auto text-end float-end ms-auto"><a href="{{ route('absensi.monthly', ['bulan' => $bulan->format('Y-m'), 'cetak' => 'true']) }}" target="_blank" class="btn btn-primary"><i class="fas fa-print"></i> Cetak PDF</a></div></div></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="2" class="align-middle">No</th>
                                <th rowspan="2" class="align-middle">Nama Siswa</th>
                                <th colspan="{{ $bulan->daysInMonth }}">Tanggal</th>
                                <th colspan="3">Rekap</th>
                            </tr>
                            <tr>
                                @for ($i = 1; $i <= $bulan->daysInMonth; $i++)<th>{{ $i }}</th>@endfor
                                <th>S</th><th>I</th><th>A</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($report as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data['siswa']->nama }}</td>
                                @foreach($data['kehadiran'] as $status)
                                <td class="text-center">{{ $status }}</td>
                                @endforeach
                                <td class="text-center">{{ $data['rekap']['S'] }}</td>
                                <td class="text-center">{{ $data['rekap']['I'] }}</td>
                                <td class="text-center">{{ $data['rekap']['A'] }}</td>
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