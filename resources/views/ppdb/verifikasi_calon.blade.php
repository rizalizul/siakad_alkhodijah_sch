@extends('layouts.app')
@section('title', 'Verifikasi Calon Siswa')
@section('content')

<div class="card">
    <div class="card-body">
        <h4>Verifikasi Calon Siswa</h4>
        <p><strong>Nama:</strong> {{ $calon->nama_lengkap }}</p>
        <p><strong>NISN:</strong> {{ $calon->nisn }}</p>
        <form action="{{ route('ppdb.verifikasi.submit', $calon->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Status Verifikasi</label>
                <select name="status" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-success">Simpan Verifikasi</button>
            </div>
        </form>
    </div>
</div>

@endsection
