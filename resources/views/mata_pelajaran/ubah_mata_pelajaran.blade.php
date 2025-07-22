@extends('layouts.app')
@section('title', 'Ubah Mata Pelajaran')
@section('content')

<div class="page-header">
    <h3 class="page-title">Ubah Mata Pelajaran</h3>
</div>

<div class="card comman-shadow">
    <div class="card-body">
        <form action="{{ route('mata-pelajaran.update', $mata_pelajaran->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group local-forms">
                <label>Kode <span class="login-danger">*</span></label>
                <input type="text" name="kode" class="form-control" value="{{ $mata_pelajaran->kode }}" required>
            </div>
            <div class="form-group local-forms">
                <label>Nama Mata Pelajaran <span class="login-danger">*</span></label>
                <input type="text" name="nama" class="form-control" value="{{ $mata_pelajaran->nama }}" required>
            </div>
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
