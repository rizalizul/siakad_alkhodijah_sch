@extends('layouts.app')
@section('title', 'Edit Data Pendaftar')
@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-sm-12">
            <div class="page-sub-header">
                <h3 class="page-title">Edit Data: {{ $siswa->nama }}</h3>
                <ul class="breadcrumb">
                    {{-- <li class="breadcrumb-item"><a href="{{ route('admin.ppdb.index') }}">Manajemen PPDB</a></li> --}}
                    <li class="breadcrumb-item active">Edit</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-sm-12">
        <div class="card comman-shadow">
            <div class="card-body">
                <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        {{-- Informasi Siswa --}}
                        <div class="col-12"><h5 class="form-title"><span>Informasi Siswa</span></h5></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Nama Lengkap <span class="login-danger">*</span></label><input type="text" name="nama" class="form-control" value="{{ old('nama', $siswa->nama) }}" required></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Nama Panggilan <span class="login-danger">*</span></label><input type="text" name="nama_panggilan" class="form-control" value="{{ old('nama_panggilan', $siswa->nama_panggilan) }}" required></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>NISN</label><input type="tel" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn) }}" oninput="this.value = this.value.replace(/[^0-9]/g, '');"></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>NIS</label><input type="text" name="nis" readonly class="form-control" value="{{ old('nis', $siswa->nis) }}"></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Jenis Kelamin <span class="login-danger">*</span></label><select name="jenis_kelamin" class="form-control" required><option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option><option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option></select></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Tempat Lahir <span class="login-danger">*</span></label><input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" required></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Tanggal Lahir <span class="login-danger">*</span></label><input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" required></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Agama <span class="login-danger">*</span></label><input type="text" name="agama" class="form-control" value="{{ old('agama', $siswa->agama) }}" required></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Pendidikan Sebelumnya</label><input type="text" name="pendidikan_sebelumnya" class="form-control" value="{{ old('pendidikan_sebelumnya', $siswa->pendidikan_sebelumnya) }}"></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Alamat Siswa <span class="login-danger">*</span></label><textarea name="alamat_siswa" class="form-control" required>{{ old('alamat_siswa', $siswa->alamat_siswa) }}</textarea></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>No WhatsApp Siswa</label><input type="tel" name="no_wa_siswa" class="form-control" value="{{ old('no_wa_siswa', $siswa->no_wa_siswa) }}" oninput="this.value = this.value.replace(/[^0-9]/g, '');"></div></div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Status Siswa <span class="login-danger">*</span></label>
                                @php
                                    $ppdbStatuses = ['calon', 'diverifikasi', 'menunggu_screening', 'tidak_diterima'];
                                @endphp

                                @if (in_array($siswa->status, $ppdbStatuses))
                                    {{-- Jika siswa masih dalam proses PPDB, tampilkan status sebagai teks biasa --}}
                                    <input type="text" class="form-control" value="{{ Str::ucfirst(str_replace('_', ' ', $siswa->status)) }}" readonly>
                                    {{-- Kirim status asli sebagai input tersembunyi agar tidak berubah saat update --}}
                                    <input type="hidden" name="status" value="{{ $siswa->status }}">
                                @else
                                    {{-- Jika siswa sudah aktif/lulus/pindah, tampilkan dropdown --}}
                                    <select name="status" class="form-control" required>
                                        <option value="aktif" {{ old('status', $siswa->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="lulus" {{ old('status', $siswa->status) == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                        <option value="pindah" {{ old('status', $siswa->status) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                                    </select>
                                @endif
                            </div>
                        </div>

                        {{-- Informasi Orang Tua --}}
                        <div class="col-12 mt-4"><h5 class="form-title"><span>Informasi Orang Tua</span></h5></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Nama Ayah <span class="login-danger">*</span></label><input type="text" id="nama_ayah" name="nama_ayah" class="form-control" value="{{ old('nama_ayah', $siswa->nama_ayah) }}" required></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Pekerjaan Ayah <span class="login-danger">*</span></label><input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" class="form-control" value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}" required></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Nama Ibu <span class="login-danger">*</span></label><input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu', $siswa->nama_ibu) }}" required></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Pekerjaan Ibu <span class="login-danger">*</span></label><input type="text" name="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}" required></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>No WhatsApp Ortu/Wali <span class="login-danger">*</span></label><input type="tel" name="no_wa_ortu" class="form-control" value="{{ old('no_wa_ortu', $siswa->no_wa_ortu) }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '');"></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Alamat Orang Tua <span class="login-danger">*</span></label><textarea id="alamat_ortu" name="alamat_ortu" class="form-control" required>{{ old('alamat_ortu', $siswa->alamat_ortu) }}</textarea></div></div>
                        
                        {{-- Informasi Wali --}}
                        <div class="col-12 mt-4"><h5 class="form-title"><span>Informasi Wali (Jika berbeda dengan Ayah/Ibu)</span></h5></div>
                        <div class="col-12"><div class="form-check mb-3"><input class="form-check-input" type="checkbox" id="use_ayah_data"><label class="form-check-label" for="use_ayah_data">Gunakan data Ayah sebagai Wali</label></div></div>
                        <div class="col-12 col-sm-4"><div class="form-group local-forms"><label>Nama Wali</label><input type="text" id="nama_wali" name="nama_wali" class="form-control" value="{{ old('nama_wali', $siswa->nama_wali) }}"></div></div>
                        <div class="col-12 col-sm-4"><div class="form-group local-forms"><label>Pekerjaan Wali</label><input type="text" id="pekerjaan_wali" name="pekerjaan_wali" class="form-control" value="{{ old('pekerjaan_wali', $siswa->pekerjaan_wali) }}"></div></div>
                        <div class="col-12 col-sm-4"><div class="form-group local-forms"><label>Alamat Wali</label><textarea id="alamat_wali" name="alamat_wali" class="form-control">{{ old('alamat_wali', $siswa->alamat_wali) }}</textarea></div></div>

                        {{-- Dokumen --}}
                        <div class="col-12 mt-4"><h5 class="form-title"><span>Dokumen (Upload file baru untuk menggantikan yang lama)</span></h5></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Kartu Keluarga</label><input type="file" name="kk" class="form-control"><small><a href="{{ Storage::url($siswa->kk) }}" target="_blank">Lihat file saat ini</a></small></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>KTP Ayah</label><input type="file" name="ktp_ayah" class="form-control"><small><a href="{{ Storage::url($siswa->ktp_ayah) }}" target="_blank">Lihat file saat ini</a></small></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>KTP Ibu</label><input type="file" name="ktp_ibu" class="form-control"><small><a href="{{ Storage::url($siswa->ktp_ibu) }}" target="_blank">Lihat file saat ini</a></small></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Akta Kelahiran</label><input type="file" name="akta_kelahiran" class="form-control"><small><a href="{{ Storage::url($siswa->akta_kelahiran) }}" target="_blank">Lihat file saat ini</a></small></div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Kartu Identitas Anak (KIA)</label><input type="file" name="kia" class="form-control">@if($siswa->kia)<small><a href="{{ Storage::url($siswa->kia) }}" target="_blank">Lihat file saat ini</a></small>@endif</div></div>
                        <div class="col-12 col-sm-6"><div class="form-group local-forms"><label>Foto Siswa</label><input type="file" name="foto" class="form-control"><small><a href="{{ Storage::url($siswa->foto) }}" target="_blank">Lihat file saat ini</a></small></div></div>

                        {{-- Tombol Submit --}}
                        <div class="col-12">
                            <div class="student-submit">
                                <button type="submit" class="btn btn-success float-end">Simpan Perubahan</button>
                                <a href="{{ route('admin.ppdb.show', $siswa->id) }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- JavaScript untuk checkbox Wali --}}
<script>
    document.getElementById('use_ayah_data').addEventListener('change', function() {
        const namaAyah = document.getElementById('nama_ayah').value;
        const pekerjaanAyah = document.getElementById('pekerjaan_ayah').value;
        const alamatOrtu = document.getElementById('alamat_ortu').value;
        
        if (this.checked) {
            document.getElementById('nama_wali').value = namaAyah;
            document.getElementById('pekerjaan_wali').value = pekerjaanAyah;
            document.getElementById('alamat_wali').value = alamatOrtu;
        } else {
            document.getElementById('nama_wali').value = '';
            document.getElementById('pekerjaan_wali').value = '';
            document.getElementById('alamat_wali').value = '';
        }
    });
</script>
@endpush