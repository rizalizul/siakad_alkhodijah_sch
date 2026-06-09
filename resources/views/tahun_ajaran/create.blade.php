@extends('layouts.app')
@section('title', 'Tambah Tahun Ajaran')
@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-sm-12">
            <div class="page-sub-header">
                <h3 class="page-title">Tambah Tahun Ajaran</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('tahun-ajaran.index') }}">Tahun Ajaran</a></li>
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
                <form action="{{ route('tahun-ajaran.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <h5 class="form-title"><span>Informasi Tahun Ajaran</span></h5>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Nama Tahun Ajaran <span class="login-danger">*</span></label>
                                <input type="text" name="nama" id="tahun-ajaran-mask" class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: 2025/2026" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Semester <span class="login-danger">*</span></label>
                                <select name="semester" class="form-control @error('semester') is-invalid @enderror" required>
                                    <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>1 (Ganjil)</option>
                                    <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>2 (Genap)</option>
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="d-flex">
                                <a href="{{ route('tahun-ajaran.index') }}" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-success">Simpan</button>
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

<script src="https://unpkg.com/imask"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Cari input field berdasarkan ID yang sudah kita tambahkan
        var element = document.getElementById('tahun-ajaran-mask');
        
        // Definisikan format mask yang diinginkan
        var maskOptions = {
            mask: '0000/0000', // '0' berarti hanya angka yang diizinkan
            // lazy: false
        };

        // Terapkan mask ke input field
        var mask = IMask(element, maskOptions);
    });
</script>
@endpush
