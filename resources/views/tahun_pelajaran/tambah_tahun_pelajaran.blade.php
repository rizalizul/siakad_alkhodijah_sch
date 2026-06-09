@extends('layouts.app')
@section('title', 'Tambah Tahun Pelajaran')
@section('content')

<div class="page-header">
    <h3 class="page-title">Tambah Tahun Pelajaran</h3>
</div>

<div class="card comman-shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('tahun-pelajaran.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label>Nama Tahun Pelajaran <span class="login-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: 2025/2026" required>
                    </div>
                </div>
                <div class="col-md-6 mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="aktif" id="aktif">
                        <label class="form-check-label" for="aktif">Tandai sebagai aktif</label>
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
