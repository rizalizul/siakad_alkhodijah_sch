@extends('layouts.app')
@section('title', 'Kelola Siswa di Kelas')
@push('styles')<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />@endpush

@section('content')
<div class="page-header"><div class="row align-items-center"><div class="col-sm-12"><div class="page-sub-header"><h3 class="page-title">Kelola Siswa di Kelas: {{ $kela->nama_kelas }}</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('kelas.index') }}">Manajemen Kelas</a></li><li class="breadcrumb-item active">Kelola Siswa</li></ul></div></div></div></div>
@if (session('success'))<div class="alert alert-success alert-dismissible fade show"><strong>Sukses!</strong> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif

<div class="row">
    <div class="col-sm-12">
        <div class="card comman-shadow">
            <div class="card-body">
                <form action="{{ route('kelas.updateSiswa', $kela->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        {{-- Fitur Salin Siswa --}}
                        <div class="col-12">
                            <h5 class="form-title"><span>Pintasan Kenaikan Kelas</span></h5>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group local-forms">
                                        <label>Salin Daftar Siswa dari Kelas Tahun Ajaran Sebelumnya</label>
                                        <select id="kelas_lama_selector" class="form-control">
                                            <option value="">Pilih Kelas Lama</option>
                                            @foreach($kelasLama as $kl)
                                                <option value="{{ $kl->id }}">{{ $kl->nama_kelas }} (T.A. {{ $kl->tahun_ajaran_nama }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{-- <label>&nbsp;</label> --}}
                                        <button type="button" id="btn-salin-siswa" class="btn btn-primary w-100">Terapkan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-3">
                        {{-- Form Pilih Siswa --}}
                        <div class="col-12">
                            <h5 class="form-title"><span>Pilih Siswa Secara Manual</span></h5>
                            <div class="form-group local-forms">
                                <label>Pilih siswa untuk dimasukkan ke dalam kelas ini <span class="login-danger">*</span></label>
                                <select name="siswa_ids[]" id="siswa_selector" class="form-control select2" multiple="multiple">
                                    @foreach($siswaTersedia as $siswa)
                                        <option value="{{ $siswa->id }}" {{ $siswaDiKelasIds->contains($siswa->id) ? 'selected' : '' }}>
                                            {{ $siswa->nama }} (NIS: {{ $siswa->nis ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                <small>Anda dapat memilih lebih dari satu siswa. Siswa yang sudah berada di kelas lain tidak akan muncul di daftar ini.</small>
                            </div>
                        </div>
                        <div class="col-12"><div class="student-submit"><button type="submit" class="btn btn-success float-end">Simpan Data Siswa Kelas</button></div></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Daftar Siswa di Kelas Ini --}}
<div class="row mt-4">
    <div class="col-sm-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header"><div class="row align-items-center"><div class="col"><h3 class="page-title">Daftar Siswa Saat Ini di Kelas {{ $kela->nama_kelas }} ({{ $siswaDiKelas->count() }} siswa)</h3></div></div></div>
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0 datatable">
                        <thead><tr><th>No</th><th>NIS</th><th>Nama Siswa</th><th>Jenis Kelamin</th></tr></thead>
                        <tbody>
                            @forelse($siswaDiKelas as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->siswa->nis ?? '-' }}</td>
                                <td>{{ $item->siswa->nama }}</td>
                                <td>{{ $item->siswa->jenis_kelamin }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center">Belum ada siswa di kelas ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Inisialisasi Select2
    const siswaSelector = $('#siswa_selector').select2();

    // Event handler untuk tombol "Terapkan"
    $('#btn-salin-siswa').on('click', function() {
        const kelasLamaId = $('#kelas_lama_selector').val();
        if (!kelasLamaId) {
            alert('Silakan pilih kelas lama terlebih dahulu.');
            return;
        }

        // Ambil token CSRF dari meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Lakukan request AJAX ke server
        fetch(`/api/kelas/${kelasLamaId}/get-siswa`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            // 'data' adalah array berisi ID siswa [1, 5, 12, ...]
            
            // Ambil ID siswa yang sudah terpilih saat ini
            let selectedSiswaIds = siswaSelector.val() || [];
            
            // Gabungkan ID yang sudah ada dengan ID baru, dan hilangkan duplikat
            let newSelection = [...new Set([...selectedSiswaIds, ...data.map(String)])];
            
            // Set nilai baru ke Select2 dan trigger event 'change' untuk memperbarui tampilan
            siswaSelector.val(newSelection).trigger('change');
            
            alert('Daftar siswa dari kelas lama berhasil ditambahkan ke pilihan. Silakan periksa kembali sebelum menyimpan.');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data siswa dari kelas lama.');
        });
    });
});
</script>
@endpush