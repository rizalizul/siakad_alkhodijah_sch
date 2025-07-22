@extends('layouts.app')
@section('title', 'Data Kelas')
@section('content')

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Data Kelas</h3>
        </div>
    </div>
</div>

<div class="card card-table comman-shadow">
    <div class="card-body">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Data Kelas</h3>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ route('kelas.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kelas</th>
                        <th>Wali Kelas</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->wali->nama ?? 'Belum ditentukan' }}</td>
                        <td class="text-end">
                            <a href="{{ route('kelas.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('kelas.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
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