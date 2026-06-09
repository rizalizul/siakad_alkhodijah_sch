@extends('layouts.app')
@section('title', 'Ubah Guru')
@section('content')

<div class="page-header">
    <h3 class="page-title">Ubah Guru</h3>
</div>

<div class="card comman-shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('guru.update', $guru->id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label>Nama Guru</label>
                        <input type="text" name="nama" class="form-control" value="{{ $guru->nama }}" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group local-forms">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" value="{{ $guru->nip }}" placeholder="Contoh: 19880923xxxx" required>
                    </div>
                    <div class="form-group local-forms">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control select" required>
                            <option value="L" {{ $guru->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $guru->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $guru->email }}" placeholder="Contoh: guru@mail.com">
                    </div>
                    <div class="form-group local-forms">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ $guru->no_hp }}" placeholder="Contoh: 081234567890">
                    </div>
                    <div class="form-group local-forms">
                        <label>Foto Baru (opsional)</label>
                        <input type="file" name="foto" class="form-control">
                        <small class="form-text text-muted">
                            File harus bertipe gambar (jpg/jpeg/png) dan ukuran maksimal 2MB.
                        </small>
                        @if ($guru->foto && file_exists(public_path('storage/' . $guru->foto)))
                            <small>Foto saat ini:</small><br>
                            <img src="{{ asset('storage/' . $guru->foto) }}" width="80" class="mt-2 rounded">
                        @else
                            <small class="text-muted">Tidak ada foto.</small>
                        @endif
                    </div>
                </div>

                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
