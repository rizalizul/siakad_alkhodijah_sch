@extends('layouts.app')
@section('title', 'Ubah Tahun Pelajaran')
@section('content')

<div class="page-header">
    <h3 class="page-title">Ubah Tahun Pelajaran</h3>
</div>

<div class="card comman-shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('tahun-pelajaran.update', $tahun_pelajaran->id) }}">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label>Nama Tahun Pelajaran</label>
                        <input type="text" name="nama" class="form-control" value="{{ $tahun_pelajaran->nama }}" required>
                    </div>
                </div>
                <div class="col-md-6 mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="aktif" id="aktif" {{ $tahun_pelajaran->aktif ? 'checked' : '' }}>
                        <label class="form-check-label" for="aktif">Tandai sebagai aktif</label>
                    </div>
                </div>
                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
