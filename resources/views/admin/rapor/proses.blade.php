@extends('layouts.app')
@section('title', 'Proses Rapor')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-sub-header">
                <h3 class="page-title">Proses Rapor: {{ $kelasSiswa->siswa->nama }}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('rapor.index') }}">Manajemen Rapor</a></li>
                    <li class="breadcrumb-item active">Proses</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('rapor.update', $rapor->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">

        {{-- ====================================================== --}}
        {{-- KOLOM KIRI: NILAI AKADEMIK & EKSTRAKURIKULER --}}
        {{-- ====================================================== --}}
        <div class="col-lg-8">
            {{-- Card Nilai Akademik --}}
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nilai Akademik</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Mata Pelajaran</th>
                                    <th class="text-center">Nilai Akhir</th>
                                    <th>Capaian Kompetensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nilaiAkademik as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['mapel']->nama_mapel }}</td>
                                    <td class="text-center">{{ $item['nilai_akhir'] }}</td>
                                    <td>{{ $item['deskripsi'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Card Ekstrakurikuler --}}
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nilai Ekstrakurikuler</h5>
                    <div id="ekskul-container">
                        @forelse($ekskul as $e)
                            <div class="row ekskul-item mb-2">
                                <div class="col-3">
                                    <select name="ekskul[{{$loop->index}}][nama]" class="form-control form-control-sm">
                                        <option value="">Pilih Ekskul</option>
                                        @foreach($ekskulOptions as $option)
                                            <option value="{{ $option->nama_ekskul }}" {{ $e->nama_ekskul == $option->nama_ekskul ? 'selected' : '' }}>{{ $option->nama_ekskul }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-8"><input type="text" name="ekskul[{{$loop->index}}][keterangan]" class="form-control form-control-sm" placeholder="Keterangan" value="{{$e->keterangan}}"></div>
                                <div class="col-1"><button type="button" class="btn btn-sm btn-danger remove-ekskul-btn">X</button></div>
                            </div>
                            @empty
                            <div class="row ekskul-item mb-2">
                                <div class="col-3">
                                    <select name="ekskul[0][nama]" class="form-control form-control-sm">
                                        <option value="">Pilih Ekskul</option>
                                        @foreach($ekskulOptions as $option)
                                            <option value="{{ $option->nama_ekskul }}">{{ $option->nama_ekskul }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-8"><input type="text" name="ekskul[0][keterangan]" class="form-control form-control-sm" placeholder="Keterangan"></div>
                                <div class="col-1"><button type="button" class="btn btn-sm btn-danger remove-ekskul-btn">X</button></div>
                            </div>
                        @endforelse
                    </div>
                    <button type="button" id="add-ekskul-btn" class="btn btn-sm btn-outline-primary mt-2">+ Tambah Ekskul</button>
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- KOLOM KANAN: ABSENSI, CATATAN, & AKSI --}}
        {{-- ====================================================== --}}
        <div class="col-lg-4">
            {{-- Card Ketidakhadiran --}}
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ketidakhadiran</h5>
                    <p>Sakit: <strong>{{ $rekapAbsensi->get('Sakit', 0) }}</strong> hari</p>
                    <p>Izin: <strong>{{ $rekapAbsensi->get('Izin', 0) }}</strong> hari</p>
                    <p>Tanpa Keterangan: <strong>{{ $rekapAbsensi->get('Tanpa Keterangan', 0) }}</strong> hari</p>
                </div>
            </div>

            {{-- Card Catatan Guru --}}
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Catatan Wali Kelas</h5>
                    <textarea name="catatan_wali_kelas" class="form-control" rows="5" placeholder="Tulis catatan untuk siswa...">{{ old('catatan_wali_kelas', $rapor->catatan_wali_kelas) }}</textarea>
                </div>
            </div>

            {{-- Card Keputusan Akhir Tahun (hanya tampil di semester 2) --}}
            @if($rapor->tahunAjaran->semester == '2')
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Keputusan Akhir Tahun</h5>
                    <select name="naik_kelas" class="form-control">
                        <option value="">Pilih Keputusan</option>
                        <option value="1" {{ $rapor->naik_kelas === 1 ? 'selected' : '' }}>Naik Kelas</option>
                        <option value="0" {{ $rapor->naik_kelas === 0 ? 'selected' : '' }}>Tinggal Kelas</option>
                    </select>
                </div>
            </div>
            @endif

            {{-- Tombol Aksi --}}
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">Simpan dan Finalisasi Rapor</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let ekskulIndex = {{ $ekskul->count() }};
    const ekskulOptions = @json($ekskulOptions->pluck('nama_ekskul'));

    document.getElementById('add-ekskul-btn').addEventListener('click', function() {
        const container = document.getElementById('ekskul-container');
        const newItem = document.createElement('div');
        newItem.classList.add('row', 'ekskul-item', 'mb-2');

        let optionsHtml = '<option value="">Pilih Ekskul</option>';
        ekskulOptions.forEach(function(option) {
            optionsHtml += `<option value="${option}">${option}</option>`;
        });

        newItem.innerHTML = `
            <div class="col-3">
                <select name="ekskul[${ekskulIndex}][nama]" class="form-control form-control-sm">
                    ${optionsHtml}
                </select>
            </div>
            <div class="col-8"><input type="text" name="ekskul[${ekskulIndex}][keterangan]" class="form-control form-control-sm" placeholder="Keterangan/Deskripsi"></div>
            <div class="col-1"><button type="button" class="btn btn-sm btn-danger remove-ekskul-btn">X</button></div>
        `;
        container.appendChild(newItem);
        ekskulIndex++;
    });

    document.getElementById('ekskul-container').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-ekskul-btn')) {
            e.target.closest('.ekskul-item').remove();
        }
    });
});
</script>
@endpush
