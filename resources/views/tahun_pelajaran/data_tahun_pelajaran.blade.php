@extends('layouts.app')
@section('title', 'Data Tahun Pelajaran')
@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Tahun Pelajaran</h3>
        </div>
    </div>
</div>

<div class="card card-table comman-shadow">
    <div class="card-body">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Data Tahun Pelajaran</h3>
                </div>
                <div class="col-auto text-end float-end ms-auto download-grp">
                    <a href="{{ route('tahun-pelajaran.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Tahun Pelajaran</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $tp)
                    <tr>
                        <td>{{ $tp->nama }}</td>
                        <td>{!! $tp->aktif ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Tidak Aktif</span>' !!}</td>
                        <td>{{ $tp->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('tahun-pelajaran.edit', $tp->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('tahun-pelajaran.destroy', $tp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
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
