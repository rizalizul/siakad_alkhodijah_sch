@extends('layouts.app')
@section('title', 'Tambah Semester')
@section('content')

<div class="page-header">
    <h3 class="page-title">Tambah Semester</h3>
</div>

<div class="card comman-shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('semester.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Semester</label>
                        <select class="form-control select" name="nama" required>
                            <option value="">Pilih</option>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Tahun Pelajaran</label>
                        <select class="form-control select" name="tahun_pelajaran_id" required>
                            <option value="">Pilih Tahun</option>
                            @foreach ($tahun as $t)
                                <option value="{{ $t->id }}">{{ $t->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
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
