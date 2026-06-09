@extends('layouts.app')
@section('title', 'Kelola Absensi')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <h3 class="page-title">Wali Kelas</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('absensi.index') }}">Absensi Kelas</a></li>
                <li class="breadcrumb-item active">Kelola Absensi</li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Absensi Kelas {{ $kelas->nama_kelas }} - Tanggal: {{ $tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}</h3>
                        </div>
                    </div>
                </div>
                <form action="{{ route('absensi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tanggal" value="{{ $tanggal->format('Y-m-d') }}">
                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th class="text-center" width="15%">Hadir</th>
                                    <th class="text-center" width="15%">Sakit</th>
                                    <th class="text-center" width="15%">Izin</th>
                                    <th class="text-center" width="15%">Tanpa Keterangan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($daftarSiswa as $item)
                                @php
                                    $absensi = $absensiSudahAda->get($item->id);
                                    $status = $absensi->status ?? 'Hadir';
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->siswa->nis }}</td>
                                    <td>{{ $item->siswa->nama }}</td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="absensi[{{ $item->id }}][status]" value="Hadir" {{ $status == 'Hadir' ? 'checked' : '' }}></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="absensi[{{ $item->id }}][status]" value="Sakit" {{ $status == 'Sakit' ? 'checked' : '' }}></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="absensi[{{ $item->id }}][status]" value="Izin" {{ $status == 'Izin' ? 'checked' : '' }}></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="absensi[{{ $item->id }}][status]" value="Tanpa Keterangan" {{ $status == 'Tanpa Keterangan' ? 'checked' : '' }}></td>
                                    <td><input type="text" name="absensi[{{ $item->id }}][keterangan]" class="form-control form-control-sm" value="{{ $absensi->keterangan ?? '' }}" placeholder="Opsional..."></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="student-submit mt-4">
                        <button type="submit" class="btn btn-success float-end">Simpan Absensi</button>
                        <a href="{{ route('absensi.index', ['bulan' => $tanggal->format('Y-m')]) }}" class="btn btn-secondary">Kembali ke Kalender</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection