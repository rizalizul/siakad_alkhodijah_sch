@extends('layouts.app')
@section('title', 'Screening Siswa')
@section('content')
<div class="page-header">
    <div class="row"><div class="col"><h3 class="page-title">Akademik</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Screening Siswa</li></ul></div></div>
</div>
@if (session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>@endif
<div class="row">
    <div class="col-md-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header"><div class="row align-items-center"><div class="col"><h3 class="page-title">Siswa Menunggu Screening</h3></div></div></div>
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0 datatable">
                        <thead><tr><th>#</th><th>Nama Calon Siswa</th><th>Umur</th><th>Nama Ayah</th><th>No. WA Ortu</th><th class="text-end">Aksi</th></tr></thead>
                        <tbody>
                            @foreach ($siswaMenungguScreening as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->nama }}</td><td>{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->age }} tahun</td><td>{{ $siswa->nama_ayah }}</td><td>{{ $siswa->no_wa_ortu }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm bg-info-light" data-bs-toggle="modal" data-bs-target="#screeningModal{{ $siswa->id }}"><i class="fas fa-user-check me-1"></i> Proses Screening</button>
                                </td>
                            </tr>
                            {{-- Modal Screening --}}
                            <div class="modal fade" id="screeningModal{{ $siswa->id }}" tabindex="-1" aria-labelledby="screeningModalLabel{{ $siswa->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header"><h5 class="modal-title" id="screeningModalLabel{{ $siswa->id }}">Hasil Screening: {{ $siswa->nama }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                                        <form action="{{ route('screening.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-body">
                                                <p>Tentukan status akhir calon siswa berdasarkan hasil observasi/screening.</p>
                                                <div class="form-group">
                                                    <label>Upload Hasil Screening</label>
                                                    <input type="file" name="hasil_screening" class="form-control">
                                                    <small class="form-text text-muted">Format: JPG, PNG, PDF. Maksimal 2MB.</small>
                                                    @if($siswa->hasil_screening)
                                                        <small class="form-text"><a href="{{ Storage::url($siswa->hasil_screening) }}" target="_blank">Lihat file saat ini</a></small>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label>Status Penerimaan <span class="login-danger">*</span></label>
                                                    <select name="status" class="form-control" required>
                                                        <option value="">Pilih Hasil</option>
                                                        <option value="aktif">Diterima (Aktifkan Siswa)</option>
                                                        <option value="tidak_diterima">Ditolak</option></select>
                                                </div>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Simpan Hasil</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection