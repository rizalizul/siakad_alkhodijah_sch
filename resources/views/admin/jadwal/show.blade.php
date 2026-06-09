@extends('layouts.app')
@section('title', 'Jadwal Kelas ' . $kela->nama_kelas)
@section('content')
<div class="page-header"><div class="row align-items-center"><div class="col-sm-12"><div class="page-sub-header"><h3 class="page-title">Jadwal Pelajaran Kelas: {{ $kela->nama_kelas }}</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('jadwal.index') }}">Jadwal Pelajaran</a></li><li class="breadcrumb-item active">Kelola Jadwal</li></ul></div></div></div></div>
@if (session('success'))<div class="alert alert-success alert-dismissible fade show"><strong>Sukses!</strong> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
@if (session('error'))<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal!</strong> {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col"></div>
                        <div class="col-auto text-end float-end ms-auto">
                            <a href="{{ route('jadwal.cetak', $kela->id) }}" target="_blank" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Cetak Jadwal</a>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addJadwalModal"><i class="fas fa-plus"></i> Tambah Jadwal</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table border-0 star-student table-hover table-center table-borderless table-striped">
                        <thead class="thead-light"><tr>@foreach($hari as $h)<th>{{ $h }}</th>@endforeach</tr></thead>
                        <tbody>
                            <tr>
                                @foreach($hari as $h)
                                <td class="p-2">
                                    @if(isset($jadwals[$h]))
                                        @foreach($jadwals[$h] as $jadwal)
                                        <div class="card shadow-sm mb-2 border">
                                            <div class="card-body p-2">
                                                <p class="font-weight-bold mb-0">{{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}</p>
                                                <p class="mb-0">{{ $jadwal->mapel->nama_mapel }}</p>
                                                <p class="text-muted small mb-1">{{ $jadwal->guru->nama }}</p>
                                                <div class="position-grid">
                                                    <button type="button" class="btn btn-sm btn-warning p-0 px-1 me-1 edit-btn" 
                                                            data-bs-toggle="modal" data-bs-target="#editJadwalModal"
                                                            data-id="{{ $jadwal->id }}"
                                                            data-guru-mapel-id="{{ $jadwal->guruMapel->id ?? '' }}">
                                                        <i class="far fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus jadwal ini?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger p-0 px-1"><i class="far fa-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal Tambah Jadwal --}}
<div class="modal fade" id="addJadwalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Tambah Jadwal Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <form action="{{ route('jadwal.store', $kela->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group"><label>Hari</label><select name="hari" class="form-control" required><option value="">Pilih Hari</option>@foreach($hari as $h)<option value="{{$h}}">{{$h}}</option>@endforeach</select></div>
                    <div class="form-group">
                        <label>Jam Pelajaran</label>
                        <select name="jam_pelajaran" class="form-control" required>
                            <option value="">Pilih Jam Pelajaran</option>
                            @foreach($jamPelajaran as $key => $slot)
                                <option value="{{ $key }}">{{ $slot['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label>Mata Pelajaran & Guru</label><select name="guru_mapel_id" class="form-control" required><option value="">Pilih Mapel & Guru</option>@foreach($penugasan as $tugas)<option value="{{$tugas->id}}">{{$tugas->mapel->nama_mapel}} - {{$tugas->guru->nama}}</option>@endforeach</select></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-success">Simpan Jadwal</button></div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Jadwal --}}
<div class="modal fade" id="editJadwalModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Ubah Jadwal</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form id="editJadwalForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <p>Anda hanya dapat mengubah Mata Pelajaran & Guru untuk slot waktu ini.</p>
            <div class="form-group"><label>Mata Pelajaran & Guru Baru</label><select id="edit_guru_mapel_id" name="guru_mapel_id" class="form-control" required><option value="">Pilih Mapel & Guru</option>@foreach($penugasan as $tugas)<option value="{{$tugas->id}}">{{$tugas->mapel->nama_mapel}} - {{$tugas->guru->nama}}</option>@endforeach</select></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-success">Ubah Jadwal</button></div>
    </form>
</div></div></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editJadwalModal = document.getElementById('editJadwalModal');
    editJadwalModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const jadwalId = button.getAttribute('data-id');
        const guruMapelId = button.getAttribute('data-guru-mapel-id');
        
        const actionUrl = `{{ url('jadwal') }}/${jadwalId}`;
        const form = editJadwalModal.querySelector('#editJadwalForm');
        form.setAttribute('action', actionUrl);
        
        const selectElement = editJadwalModal.querySelector('#edit_guru_mapel_id');
        if (guruMapelId) {
            selectElement.value = guruMapelId;
        }
    });
});
</script>
@endpush