@extends('layouts.app')
@section('title', 'Data Guru')
@section('content')

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Guru</h3>
        </div>
    </div>
</div>

<div class="card card-table comman-shadow">
    <div class="card-body">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Data Guru</h3>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ route('guru.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Guru</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Jenis Kelamin</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $guru)
                    <tr>
                        {{-- @dd($guru->foto) --}}
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($guru->foto && file_exists(public_path('storage/' . $guru->foto)))
                                <img src="{{ asset('storage/' . $guru->foto) }}" width="40" height="40" style="object-fit: cover;" class="rounded-circle" alt="Foto Guru">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $guru->nama }}</td>
                        <td>{{ $guru->nip }}</td>
                        <td>{{ $guru->jenis_kelamin }}</td>
                        <td>{{ $guru->email }}</td>
                        <td>{{ $guru->no_hp }}</td>
                        <td class="text-end">
                            <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
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
