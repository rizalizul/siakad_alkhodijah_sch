@extends('layouts.app')
@section('title', 'Detail Siswa')
@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-sm-12">
            <div class="page-sub-header">
                <h3 class="page-title">Detail Siswa</h3>
                <ul class="breadcrumb">
                    {{-- <li class="breadcrumb-item"><a href="{{ route('admin.ppdb.index') }}">Manajemen PPDB</a></li> --}}
                    <li class="breadcrumb-item active">Detail</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    {{-- Kolom Kiri: Foto & Tombol Aksi --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $siswa->foto ? Storage::url($siswa->foto) : asset('assets/img/profiles/avatar-01.jpg') }}" alt="Foto Siswa" class="img-fluid img-thumbnail rounded-circle mb-3" style="width: 180px; height: 180px; object-fit: cover;">
                <h4 class="card-title">{{ $siswa->nama }}</h4>
                {{-- <p class="">NISN : {{ $siswa->nisn ?? 'NISN Belum Ada' }}</p> --}}
                <hr>
                <div class="d-grid gap-2">
                    @if($siswa->status == 'calon' && Auth::user()->role == 'staf_administrasi')
                        <h5 class="text-start">Tindakan</h5>
                        <p class="text-muted text-start small">Verifikasi data dan dokumen. Jika sesuai, teruskan ke bagian keuangan untuk pembayaran formulir.</p>
                        <form action="{{ route('admin.ppdb.verifikasi', $siswa->id) }}" method="POST" onsubmit="return confirm('Anda yakin data siswa ini sudah benar dan valid?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="status" value="diverifikasi" class="btn btn-success w-100 mb-2">
                                <i class="fas fa-check-circle me-2"></i>Verifikasi & Lanjutkan ke Pembayaran
                            </button>
                        </form>
                        <form action="{{ route('admin.ppdb.verifikasi', $siswa->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin MENOLAK pendaftaran ini?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="status" value="tidak_diterima" class="btn btn-danger w-100">
                                <i class="fas fa-times-circle me-2"></i>Tolak Pendaftaran
                            </button>
                        </form>
                    @else
                        <span class="">
                            {{ Str::ucfirst(str_replace('_', ' ', $siswa->status)) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5 class="card-title">Dokumen Pendukung</h5></div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ Storage::url($siswa->kk) }}" target="_blank" class="btn btn-outline-primary"><i class="far fa-file-pdf me-2"></i>Lihat Kartu Keluarga</a>
                    <a href="{{ Storage::url($siswa->ktp_ayah) }}" target="_blank" class="btn btn-outline-primary"><i class="far fa-file-pdf me-2"></i>Lihat KTP Ayah</a>
                    <a href="{{ Storage::url($siswa->ktp_ibu) }}" target="_blank" class="btn btn-outline-primary"><i class="far fa-file-pdf me-2"></i>Lihat KTP Ibu</a>
                    <a href="{{ Storage::url($siswa->akta_kelahiran) }}" target="_blank" class="btn btn-outline-primary"><i class="far fa-file-pdf me-2"></i>Lihat Akta Kelahiran</a>
                    @if($siswa->kia)
                    <a href="{{ Storage::url($siswa->kia) }}" target="_blank" class="btn btn-outline-primary"><i class="far fa-file-pdf me-2"></i>Lihat KIA</a>
                    @else
                    <button class="btn btn-outline-secondary" disabled><i class="far fa-file-pdf me-2"></i>KIA Tidak Diupload</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Detail Informasi --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-9">
                        <h5 class="card-title">Profil Siswa</h5>
                    </div>
                    @if(Auth::user()->role == 'staf_administrasi')
                    <div class="col-sm-3">
                        <a href="{{ route('admin.ppdb.edit', $siswa->id) }}" class="btn btn-sm btn-warning w-100 mb-2">
                            <i class="far fa-edit me-2"></i>Perbaiki Data
                        </a>
                    </div>
                    @endif
                    <div class="col-sm-4"><p class="text-muted mb-0">NIS</p></div><div class="col-sm-8"><p><b>: {{ $siswa->nis ?? '-' }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">NISN</p></div><div class="col-sm-8"><p><b>: {{ $siswa->nisn ?? '-' }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">Nama Lengkap</p></div><div class="col-sm-8"><p><b>: {{ $siswa->nama }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">Nama Panggilan</p></div><div class="col-sm-8"><p><b>: {{ $siswa->nama_panggilan }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">TTL</p></div><div class="col-sm-8"><p><b>: {{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('D MMMM Y') }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">Umur</p></div><div class="col-sm-8"><p><b>: {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->age }} tahun</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">Jenis Kelamin</p></div><div class="col-sm-8"><p><b>: {{ $siswa->jenis_kelamin }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">Agama</p></div><div class="col-sm-8"><p><b>: {{ $siswa->agama }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">Pendidikan Sebelumnya</p></div><div class="col-sm-8"><p><b>: {{ $siswa->pendidikan_sebelumnya ?? '-' }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">Alamat</p></div><div class="col-sm-8"><p><b>: {{ $siswa->alamat_siswa }}</b></p></div>
                </div>
                <hr>
                <h5 class="card-title">Data Orang Tua</h5>
                <div class="row">
                    <div class="col-sm-4"><p class="text-muted mb-0">Nama Ayah</p></div><div class="col-sm-8"><p><b>: {{ $siswa->nama_ayah }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">Pekerjaan Ayah</p></div><div class="col-sm-8"><p><b>: {{ $siswa->pekerjaan_ayah }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">Nama Ibu</p></div><div class="col-sm-8"><p><b>: {{ $siswa->nama_ibu }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">Pekerjaan Ibu</p></div><div class="col-sm-8"><p><b>: {{ $siswa->pekerjaan_ibu }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">No. WA</p></div><div class="col-sm-8"><p><b>: {{ $siswa->no_wa_ortu }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">Alamat Ortu</p></div><div class="col-sm-8"><p><b>: {{ $siswa->alamat_ortu }}</b></p>
                        @php
                            $no_wa = preg_replace('/^0/', '62', $siswa->no_wa_ortu);
                            $pesan = urlencode("Yth. Orang Tua/Wali dari calon siswa {$siswa->nama}, kami dari panitia PPDB Al Khodijah Elementary School ingin menginformasikan bahwa ada data/dokumen yang perlu diperbaiki. Mohon untuk segera melakukan perbaikan. Terima kasih.");
                        @endphp
                        @if($siswa->status == 'calon')
                        <a href="https://wa.me/{{ $no_wa }}?text={{ $pesan }}" target="_blank" class="btn btn-sm btn-success">
                            <i class="fab fa-whatsapp"></i> Hubungi
                        </a>
                        @endif
                    </div>
                </div>
                <hr>
                <h5 class="card-title">Data Wali</h5>
                <div class="row">
                    <div class="col-sm-4"><p class="text-muted mb-0">Nama Wali</p></div><div class="col-sm-8"><p><b>: {{ $siswa->nama_wali ?? '-' }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">Pekerjaan Wali</p></div><div class="col-sm-8"><p><b>: {{ $siswa->pekerjaan_wali ?? '-' }}</b></p></div>
                    <div class="col-sm-4"><p class="text-muted mb-0">Alamat Wali</p></div><div class="col-sm-8"><p><b>: {{ $siswa->alamat_wali ?? '-' }}</b></p></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection