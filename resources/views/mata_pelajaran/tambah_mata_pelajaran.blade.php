@extends('layouts.app')
@section('title', 'Tambah Mata Pelajaran')
@section('content')

<div class="page-header">
    <h3 class="page-title">Tambah Mata Pelajaran</h3>
</div>

<div class="card comman-shadow">
    <div class="card-body">
        <form action="{{ route('mata-pelajaran.store') }}" method="POST">
            @csrf
            <div class="form-group local-forms">
                <label>Kode <span class="login-danger">*</span></label>
                <input type="text" name="kode" class="form-control" placeholder="Contoh: BINDO01" required>
            </div>
            <div class="form-group local-forms">
                <label>Nama Mata Pelajaran <span class="login-danger">*</span></label>
                <input type="text" name="nama" class="form-control" placeholder="Contoh: Bahasa Indonesia" required>
            </div>
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
