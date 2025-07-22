@extends('layouts.app')
@section('title', 'Ubah Semester')
@section('content')

<div class="page-header">
    <h3 class="page-title">Ubah Semester</h3>
</div>

<div class="card comman-shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('semester.update', $semester->id) }}">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Semester</label>
                        <select class="form-control select" name="nama" required>
                            <option value="1" {{ $semester->nama == '1' ? 'selected' : '' }}>Semester 1</option>
                            <option value="2" {{ $semester->nama == '2' ? 'selected' : '' }}>Semester 2</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Tahun Pelajaran</label>
                        <select class="form-control select" name="tahun_pelajaran_id" required>
                            @foreach ($tahun as $t)
                                <option value="{{ $t->id }}" {{ $semester->tahun_pelajaran_id == $t->id ? 'selected' : '' }}>{{ $t->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="aktif" id="aktif" {{ $semester->aktif ? 'checked' : '' }}>
                        <label class="form-check-label" for="aktif">Tandai sebagai aktif</label>
                    </div>
                </div>

                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
