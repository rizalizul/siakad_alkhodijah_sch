@extends('layouts.app')
@section('title', 'Pendaftaran Siswa Baru')
@section('content')

<div class="page-header">
    <h3 class="page-title">Formulir Pendaftaran Siswa Baru</h3>
</div>

<div class="card comman-shadow">
    <div class="card-body">
        <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <h5 class="form-title"><span>Informasi Siswa</span></h5>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>NISN</label>
                        <input type="text" name="nisn" class="form-control" placeholder="Masukkan NISN (jika ada)">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Nama Lengkap <span class="login-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Nama Panggilan <span class="login-danger">*</span></label>
                        <input type="text" name="nama_panggilan" class="form-control" placeholder="Masukkan Nama Panggilan" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Jenis Kelamin <span class="login-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-control select" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Tempat Lahir <span class="login-danger">*</span></label>
                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms calendar-icon">
                        <label>Tanggal Lahir <span class="login-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Agama <span class="login-danger">*</span></label>
                        <select name="agama" class="form-control select" required>
                            <option value="Islam">Islam</option>
                            <option value="Protestan">Protestan</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Pendidikan Sebelumnya</label>
                        <input type="text" name="pendidikan_sebelumnya" class="form-control" placeholder="Contoh: TK Bina Insani">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Alamat Siswa</label>
                        <input type="text" name="alamat_siswa" class="form-control" placeholder="Masukkan Alamat Lengkap">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>No WhatsApp Siswa</label>
                        <input type="text" name="no_wa_siswa" class="form-control" placeholder="Masukkan No WhatsApp (jika ada)">
                    </div>
                </div>
                <!-- Informasi Orang Tua -->
                @include('ppdb._orangtua_wali')
                <!-- Dokumen Upload (optional include) -->
                @include('ppdb._dokumen_upload')

                <div class="col-12">
                    <div class="student-submit text-end">
                        <button type="submit" class="btn btn-primary">Kirim Pendaftaran</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection