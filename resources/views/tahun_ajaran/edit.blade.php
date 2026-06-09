@extends('layouts.app')

@section('title', 'Edit Tahun Ajaran')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-sm-12">
            <div class="page-sub-header">
                <h3 class="page-title">Edit Tahun Ajaran</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('tahun-ajaran.index') }}">Tahun Ajaran</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card comman-shadow">
            <div class="card-body">
                <form action="{{ route('tahun-ajaran.update', $tahunAjaran->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <h5 class="form-title"><span>Informasi Tahun Ajaran</span></h5>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Nama Tahun Ajaran <span class="login-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $tahunAjaran->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Semester <span class="login-danger">*</span></label>
                                <select name="semester" class="form-control @error('semester') is-invalid @enderror" required>
                                    <option value="1" {{ old('semester', $tahunAjaran->semester) == '1' ? 'selected' : '' }}>1 (Ganjil)</option>
                                    <option value="2" {{ old('semester', $tahunAjaran->semester) == '2' ? 'selected' : '' }}>2 (Genap)</option>
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="student-submit">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('tahun-ajaran.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection