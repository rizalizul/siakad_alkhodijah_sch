@extends('layouts.app')
@section('title', 'Tambah Guru')
@section('content')

<div class="page-header">
    <h3 class="page-title">Tambah Guru</h3>
</div>

<div class="card comman-shadow">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('guru.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label>Nama Guru <span class="login-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group local-forms">
                        <label>NIP <span class="login-danger">*</span></label>
                        <input type="text" name="nip" class="form-control" placeholder="Contoh: 19880923xxxx" required>
                    </div>
                    <div class="form-group local-forms">
                        <label>Jenis Kelamin <span class="login-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-control select" required>
                            <option value="">Pilih</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Contoh: guru@mail.com">
                    </div>
                    <div class="form-group local-forms">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 081234567890">
                    </div>
                    <div class="form-group local-forms">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control">
                        <small class="form-text text-muted">
                            File harus bertipe gambar (jpg/jpeg/png) dan ukuran maksimal 2MB.
                        </small>
                    </div>
                </div>

                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
