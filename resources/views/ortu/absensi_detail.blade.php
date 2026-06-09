@extends('ortu.layouts.app')
@section('title', 'Detail Absensi')
@section('content')
<div class="page-header"><div class="row"><div class="col-sm-12"><div class="page-sub-header"><h3 class="page-title">Detail Absensi: {{ $siswa->nama }}</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('ortu.dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Detail Absensi</li></ul></div></div></div></div>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">Kalender Absensi</h5>
            <div>
                <a href="{{ route('ortu.absensi.detail', ['bulan' => $bulan->copy()->subMonth()->format('Y-m')]) }}" class="btn btn-outline-secondary btn-sm">&lt; Sebelumnya</a>
                <strong class="mx-2">{{ $bulan->locale('id')->isoFormat('MMMM YYYY') }}</strong>
                <a href="{{ route('ortu.absensi.detail', ['bulan' => $bulan->copy()->addMonth()->format('Y-m')]) }}" class="btn btn-outline-secondary btn-sm">Berikutnya &gt;</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead><tr><th>Sen</th><th>Sel</th><th>Rab</th><th>Kam</th><th>Jum</th><th>Sab</th><th>Min</th></tr></thead>
                <tbody>
                    @php $dayOfWeek = $bulan->copy()->startOfMonth()->dayOfWeek; if($dayOfWeek == 0) $dayOfWeek = 7; @endphp
                    <tr>
                        @for($i = 1; $i < $dayOfWeek; $i++)<td class="bg-light"></td>@endfor
                        @for($day = 1; $day <= $bulan->daysInMonth; $day++)
                            @if($dayOfWeek > 7)</tr><tr>@php $dayOfWeek = 1; @endphp @endif
                            <td>
                                <strong>{{ $day }}</strong>
                                @if(isset($absensiData[$day]))
                                    @php $status = $absensiData[$day]->status; @endphp
                                    @if($status == 'Sakit') <span class="badge bg-warning">S</span>
                                    @elseif($status == 'Izin') <span class="badge bg-info">I</span>
                                    @elseif($status == 'Tanpa Keterangan') <span class="badge bg-danger">A</span>
                                    @elseif($status == 'Hadir') <i class="fas fa-check-circle hadir" style="color: #28a745;" title="Hadir"></i>
                                    @endif
                                @endif
                            </td>
                            @php $dayOfWeek++; @endphp
                        @endfor
                        @while($dayOfWeek <= 7) <td class="bg-light"></td> @php $dayOfWeek++; @endphp @endwhile
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection