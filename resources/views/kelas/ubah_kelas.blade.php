@extends('layouts.app')
@section('title', 'Ubah Kelas')
@section('content')

<div class="page-header">
    <h3 class="page-title">Ubah Kelas</h3>
</div>

<div class="card comman-shadow">
    <div class="card-body">
        <form action="{{ route('kelas.update', $kela->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group local-forms">
                <label>Nama Kelas <span class="login-danger">*</span></label>
                <input type="text" name="nama" class="form-control" value="{{ $kela->nama }}" required>
            </div>
            <div class="form-group local-forms">
                <label>Wali Kelas</label>
                <select name="wali_kelas_id" class="form-control select">
                    <option value="">-- Pilih Guru --</option>
                    @foreach ($guru as $g)
                        <option value="{{ $g->id }}" @if($kela->wali_kelas_id == $g->id) selected @endif>{{ $g->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
