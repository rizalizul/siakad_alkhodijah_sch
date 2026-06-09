@extends('layouts.app')
@section('title', 'Tambah Ekstrakurikuler')
@section('content')

<div class="page-header">
    <h3 class="page-title">Tambah Ekstrakurikuler</h3>
</div>

<div class="card comman-shadow">
    <div class="card-body">
        <form action="{{ route('ekstrakurikuler.store') }}" method="POST">
            @csrf
            <div class="form-group local-forms">
                <label>Nama Ekstrakurikuler <span class="login-danger">*</span></label>
                <input type="text" name="nama" class="form-control" placeholder="Contoh: Storytelling" required>
            </div>
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
