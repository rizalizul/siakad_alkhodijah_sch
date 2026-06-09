@extends('layouts.app')
@section('title', 'Tambah Pengguna')
@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-sm-12">
            <div class="page-sub-header">
                <h3 class="page-title">Tambah Pengguna</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Pengguna</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card comman-shadow">
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12"><h5 class="form-title"><span>Informasi Pengguna</span></h5></div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Nama Lengkap <span class="login-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Email <span class="login-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Password <span class="login-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Konfirmasi Password <span class="login-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Peran (Role) <span class="login-danger">*</span></label>
                                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="">Pilih Peran</option>
                                    <option value="staf_administrasi" {{ old('role') == 'staf_administrasi' ? 'selected' : '' }}>Staf Administrasi</option>
                                    <option value="bendahara" {{ old('role') == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                                    {{-- <option value="guru_mapel" {{ old('role') == 'guru_mapel' ? 'selected' : '' }}>Guru Mapel</option> --}}
                                    {{-- <option value="wali_kelas" {{ old('role') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option> --}}
                                    <option value="kepala_sekolah" {{ old('role') == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                    <option value="wakasek_kurikulum" {{ old('role') == 'wakasek_kurikulum' ? 'selected' : '' }}>Wakasek Kurikulum</option>
                                </select>
                                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="student-submit">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection