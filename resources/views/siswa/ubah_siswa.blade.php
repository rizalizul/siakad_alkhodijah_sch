@extends('layouts.app')
@section('title', 'Ubah Siswa')
@section('content')

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Ubah Siswa</h3>
        </div>
        <div class="col-auto">
            <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-body row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $siswa->nama) }}" required>
                </div>
                <div class="form-group">
                    <label>NISN</label>
                    <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn) }}">
                </div>
                <div class="form-group">
                    <label>NIS</label>
                    <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}">
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control">
                        <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                </div>
                <div class="form-group">
                    <label>Agama</label>
                    <input type="text" name="agama" class="form-control" value="{{ old('agama', $siswa->agama) }}">
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Ayah</label>
                    <input type="text" name="nama_ayah" class="form-control" value="{{ old('nama_ayah', $siswa->nama_ayah) }}">
                </div>
                <div class="form-group">
                    <label>Nama Ibu</label>
                    <input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu', $siswa->nama_ibu) }}">
                </div>
                <div class="form-group">
                    <label>No WA Ortu</label>
                    <input type="text" name="no_wa_ortu" class="form-control" value="{{ old('no_wa_ortu', $siswa->no_wa_ortu) }}">
                </div>
                <div class="form-group">
                    <label>Alamat Siswa</label>
                    <textarea name="alamat_siswa" class="form-control">{{ old('alamat_siswa', $siswa->alamat_siswa) }}</textarea>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
    </div>
</form>

@endsection