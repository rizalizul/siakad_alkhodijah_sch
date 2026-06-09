@extends('layouts.app')
@section('title', 'Ubah Ekstrakurikuler')
@section('content')

<div class="page-header">
    <h3 class="page-title">Ubah Ekstrakurikuler</h3>
</div>

<div class="card comman-shadow">
    <div class="card-body">
        <form action="{{ route('ekstrakurikuler.update', $ekstrakurikuler->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group local-forms">
                <label>Nama Ekstrakurikuler <span class="login-danger">*</span></label>
                <input type="text" name="nama" class="form-control" value="{{ $ekstrakurikuler->nama }}" required>
            </div>
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
