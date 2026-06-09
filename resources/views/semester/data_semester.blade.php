@extends('layouts.app')
@section('title', 'Data Semester')
@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Semester</h3>
        </div>
    </div>
</div>

<div class="card card-table comman-shadow">
    <div class="card-body">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Data Semester</h3>
                </div>
                <div class="col-auto text-end float-end ms-auto download-grp">
                    <a href="{{ route('semester.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Semester</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Semester</th>
                        <th>Tahun Pelajaran</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $s)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>Semester {{ $s->nama }}</td>
                        <td>{{ $s->tahunPelajaran->nama ?? '-' }}</td>
                        <td>{!! $s->aktif ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Tidak Aktif</span>' !!}</td>
                        <td>{{ $s->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('semester.edit', $s->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('semester.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
