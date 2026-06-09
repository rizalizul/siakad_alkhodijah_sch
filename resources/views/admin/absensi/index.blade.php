@extends('layouts.app')
@section('title', 'Absensi Kelas')
@push('styles')
<style>
    .absensi-grid .date-header a {
        text-decoration: none;
        color: #333;
        display: block;
        padding: 5px;
        border-radius: 5px;
        transition: background-color 0.2s;
    }
    .absensi-grid .date-header a:hover { background-color: #e9ecef; }
    .absensi-grid .hadir { color: #28a745; }
    .absensi-grid .sakit { color: #ffc107; }
    .absensi-grid .izin { color: #17a2b8; }
    .absensi-grid .alpha { color: #dc3545; }
    .absensi-grid .kosong { color: #ccc; }
</style>
@endpush

@section('content')
<div class="page-header"><div class="row"><div class="col"><h3 class="page-title">Wali Kelas</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Absensi Kelas</li></ul></div></div></div>
@if (session('success'))<div class="alert alert-success alert-dismissible fade show"><strong>Sukses!</strong> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
@if (session('error'))<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal!</strong> {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif

<div class="row">
    {{-- Input Absensi Harian --}}
    <div class="col-lg-6">
        <div class="card comman-shadow">
            <div class="card-body">
                <h5 class="card-title">Input Absensi Harian</h5>
                <p>Pilih tanggal untuk mengisi atau mengubah absensi harian.</p>
                <form action="{{ route('absensi.manage') }}" method="GET">
                    <div class="form-group local-forms">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal_harian" class="form-control" value="{{ date('Y-m-d') }}" required>
                        <small id="nama_hari" class="form-text text-muted"></small>
                    </div>
                    <button type="submit" class="btn btn-primary">Buka Absensi Harian</button>
                </form>
            </div>
        </div>
    </div>
    {{-- Laporan & Cetak --}}
    <div class="col-lg-6">
        <div class="card comman-shadow">
            <div class="card-body">
                <h5 class="card-title">Laporan & Cetak</h5>
                <p>Pilih bulan untuk mencetak laporan rekap atau blanko absensi.</p>
                <form action="{{ route('absensi.monthly') }}" method="GET" target="_blank" class="mb-2">
                    <div class="input-group">
                        <input type="month" name="bulan" class="form-control" value="{{ $bulan->format('Y-m') }}" required>
                        <button type="submit" name="cetak" value="true" class="btn btn-outline-primary"><i class="fas fa-print"></i> Cetak Rekap Bulanan</button>
                    </div>
                </form>
                <form action="{{ route('absensi.cetakBlanko') }}" method="GET" target="_blank" class="mb-3">
                     <div class="input-group">
                        <input type="month" name="bulan" class="form-control" value="{{ $bulan->format('Y-m') }}" required>
                        <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-print"></i> Cetak Blanko Bulanan</button>
                    </div>
                </form>
                <a href="{{ route('absensi.cetakSemester') }}" target="_blank" class="btn btn-info w-100"><i class="fas fa-print"></i> Cetak Rekap Presensi Semester</a>
            </div>
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
                            <h3 class="page-title">Kalender Absensi Kelas: {{ $kelas->nama_kelas }}</h3>
                        </div>
                        <div class="col-auto text-end float-end ms-auto">
                            <a href="{{ route('absensi.index', ['bulan' => $bulan->copy()->subMonth()->format('Y-m')]) }}" class="btn btn-outline-secondary btn-sm">&lt; Sebelumnya</a>
                            <strong class="mx-2">{{ $bulan->locale('id')->isoFormat('MMMM YYYY') }}</strong>
                            <a href="{{ route('absensi.index', ['bulan' => $bulan->copy()->addMonth()->format('Y-m')]) }}" class="btn btn-outline-secondary btn-sm">Berikutnya &gt;</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover absensi-grid">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>NIS</th>
                                <th class="text-start">Nama Siswa</th>
                                @for ($i = 1; $i <= $bulan->daysInMonth; $i++)
                                    @php $tanggal = $bulan->copy()->day($i)->format('Y-m-d'); @endphp
                                    <th class="date-header">
                                        <a href="{{ route('absensi.manage', ['tanggal' => $tanggal]) }}" title="Input Absensi Tanggal {{ $i }}">
                                            {{ $i }}
                                        </a>
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($report as $kelas_siswa_id => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data['siswa']->nis }}</td>
                                <td>{{ $data['siswa']->nama }}</td>
                                @foreach($data['kehadiran'] as $day => $status)
                                <td class="text-center">
                                    @if($status == 'Sakit') <span class="sakit" title="Sakit">S</span>
                                    @elseif($status == 'Izin') <span class="izin" title="Izin">I</span>
                                    @elseif($status == 'Tanpa Keterangan') <span class="alpha" title="Tanpa Keterangan">A</span>
                                    @elseif($status == 'Hadir') <i class="fas fa-check-circle hadir" title="Hadir"></i>
                                    @else <i class="fas fa-minus kosong" title="Belum Diisi"></i>
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                 <div class="mt-3">
                    <strong>Keterangan:</strong>
                    <span class="ms-3"><i class="fas fa-check-circle hadir"></i> : Hadir</span>
                    <span class="ms-3"><span class="sakit">S</span> : Sakit</span>
                    <span class="ms-3"><span class="izin">I</span> : Izin</span>
                    <span class="ms-3"><span class="alpha">A</span> : Tanpa Keterangan</span>
                    <span class="ms-3"><i class="fas fa-minus kosong"></i> : Belum Diisi</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tanggalInput = document.getElementById('tanggal_harian');
        const namaHariDisplay = document.getElementById('nama_hari');
        const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        function updateNamaHari() {
            if (!tanggalInput.value) return;
            const tanggal = new Date(tanggalInput.value);
            const adjustedTanggal = new Date(tanggal.valueOf() + tanggal.getTimezoneOffset() * 60 * 1000);
            const namaHari = hari[adjustedTanggal.getDay()];
            namaHariDisplay.textContent = 'Hari: ' + namaHari;
        }

        tanggalInput.addEventListener('change', updateNamaHari);
        updateNamaHari();
    });
</script>
@endpush