@extends('layouts.app')
@section('title', 'Daftar Nilai')
@push('styles')
<style>
    .table-nilai th, .table-nilai td { padding: 0.4rem; vertical-align: middle; text-align: center; font-size: 0.8rem; }
    .table-nilai td:nth-child(2) { text-align: left; min-width: 200px; }
    .table-nilai input { width: 45px; padding: 2px 4px; text-align: center; border: 1px solid #ddd; border-radius: 4px; }
    .table-nilai thead th { position: sticky; top: -1px; background-color: #f8f9fa; z-index: 1; }
    /* Hilangkan panah di Chrome, Edge, Safari */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Hilangkan panah di Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush
@section('content')
<div class="page-header"><div class="row"><div class="col"><h3 class="page-title">Input Nilai</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('nilai.index') }}">Pengelolaan Nilai</a></li><li class="breadcrumb-item active">Daftar Nilai</li></ul></div></div></div>
@if (session('success'))<div class="alert alert-success alert-dismissible fade show"><strong>Sukses!</strong> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif

<div class="card card-table comman-shadow">
    <div class="card-body">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Daftar Nilai Kelas: <strong>{{ $kelas->nama_kelas }}</strong> - Mata Pelajaran: <strong>{{ $mapel->nama_mapel }}</strong></h3>
                </div>
                <div class="col-auto text-end float-end ms-auto">
                    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addTpModal">
                        <i class="fas fa-plus"></i> Tambah Deskripsi TP
                    </button>
                    <a href="{{ route('nilai.cetak', ['kelas_id' => $kelas->id, 'mapel_id' => $mapel->id]) }}" target="_blank" class="btn btn-outline-primary"><i class="fas fa-print"></i> Cetak Daftar Nilai</a>
                </div>
            </div>
        </div>
        <form action="{{ route('nilai.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
            <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-nilai">
                    <thead class="text-center">
                        <tr>
                            <th rowspan="2">No</th><th rowspan="2">Nama Siswa</th>
                            <th colspan="{{ $tpDeskripsi->count() > 0 ? $tpDeskripsi->count() : 1 }}" class="bg-light">Nilai Tujuan Pembelajaran (TP)</th>
                            <th rowspan="2">STS</th><th rowspan="2">SAS</th><th rowspan="2">Nilai Akhir</th>
                        </tr>
                        <tr>
                            @foreach($tpDeskripsi as $deskripsi)
                            <th>
                                <span class="d-inline-block text-truncate" style="max-width: 50px;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $deskripsi }}">{{ 'TP' . $loop->iteration }}</span>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#editTpModal" data-old-deskripsi="{{ $deskripsi }}">
                                    <i class="fas fa-pencil-alt text-warning" style="font-size: 0.7rem;"></i>
                                </a>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataNilaiSiswa as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data['item']->siswa->nama }}</td>
                            @if ($tpDeskripsi->count() > 0)
                            @foreach($tpDeskripsi as $deskripsi)
                            <td>
                                <input type="number" name="nilai[{{ $data['item']->id }}][TP][{{$deskripsi}}]" value="{{ $data['nilai_tp']->get($deskripsi) }}" class="form-control form-control-sm" min="0" max="100">
                            </td>
                            @endforeach
                            @else
                            <td>
                                <p class="text-muted text-center" style="">Tambahkan deskripsi TP terlebih dahulu</p>
                                <input type="hidden" name="nilai[{{ $data['item']->id }}][TP][placeholder_hidden]" value="0">
                            </td>
                            @endif
                            <td><input type="number" name="nilai[{{ $data['item']->id }}][STS]" value="{{ $data['nilai_sts']->nilai_sts ?? '' }}" class="form-control form-control-sm" min="0" max="100"></td>
                            <td><input type="number" name="nilai[{{ $data['item']->id }}][SAS]" value="{{ $data['nilai_sas']->nilai_sas ?? '' }}" class="form-control form-control-sm" min="0" max="100"></td>
                            <td><strong>{{ $data['nilai_akhir'] }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="student-submit mt-4 d-flex justify-content-between">
                <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-success">Simpan Semua Nilai</button>
            </div>
        </form>
        <hr>
        <div>
            <h6>Keterangan:</h6>
            <ul class="list-unstyled">
                <li><strong>TP</strong>: Nilai Tujuan Pembelajaran (Nilai Harian)</li>
                <li><strong>STS</strong>: Nilai Sumatif Tengah Semester</li>
                <li><strong>SAS</strong>: Nilai Sumatif Akhir Semester</li>
            </ul>
        </div>
    </div>
</div>

<div class="modal fade" id="addTpModal" tabindex="-1" aria-labelledby="addTpModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('nilai.store.tp') }}" method="POST">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTpModalLabel">Tambah Deskripsi TP Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Tujuan Pembelajaran</label>
                        <input type="text" name="deskripsi" id="deskripsi" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editTpModal" tabindex="-1" aria-labelledby="editTpModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('nilai.update.tp') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
                <input type="hidden" name="old_deskripsi" id="old_deskripsi">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTpModalLabel">Ubah Deskripsi TP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new_deskripsi">Deskripsi TP Baru</label>
                        <input type="text" name="new_deskripsi" id="new_deskripsi" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editTpModal = document.getElementById('editTpModal');
        editTpModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var oldDeskripsi = button.getAttribute('data-old-deskripsi');
            var modalInputOldDeskripsi = editTpModal.querySelector('#old_deskripsi');
            var modalInputNewDeskripsi = editTpModal.querySelector('#new_deskripsi');

            modalInputOldDeskripsi.value = oldDeskripsi;
            modalInputNewDeskripsi.value = oldDeskripsi;
        });
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush