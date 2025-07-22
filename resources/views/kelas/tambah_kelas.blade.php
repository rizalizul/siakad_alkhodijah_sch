@extends('layouts.app')
@section('title', 'Tambah Kelas')
@section('content')

<div class="page-header">
    <h3 class="page-title">Tambah Kelas</h3>
</div>

<div class="card comman-shadow">
    <div class="card-body">
        <form action="{{ route('kelas.store') }}" method="POST">
            @csrf
            <div class="form-group local-forms">
                <label>Nama Kelas <span class="login-danger">*</span></label>
                <input type="text" name="nama" class="form-control" placeholder="Contoh: 5A" required>
            </div>
            <div class="form-group local-forms">
                <label>Wali Kelas</label>
                <select name="wali_kelas_id" class="form-control select">
                    <option value="">-- Pilih Guru --</option>
                    @foreach ($guru as $g)
                        <option value="{{ $g->id }}">{{ $g->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
