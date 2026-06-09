@extends('layouts.app')
@section('title', 'Detail Tagihan Siswa')
@push('styles')
<style>
    .card-header .badge {
        /* Mengatur ulang ukuran agar pas dengan konten */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: auto;
        height: auto;
        min-height: unset;

        /* Menyesuaikan padding dan ukuran font agar proporsional */
        padding: 0.4em 0.7em;
        font-size: 0.8rem;
        font-weight: 600;
        line-height: 1;

        /* Memastikan teks selalu di tengah */
        text-align: center;
        vertical-align: middle;
    }
</style>
@endpush
@section('content')
<div class="page-header"><div class="row"><div class="col-sm-12"><div class="page-sub-header"><h3 class="page-title">Detail Tagihan: {{ $siswa->nama }}</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('keuangan.tagihan.index') }}">Tagihan Siswa</a></li><li class="breadcrumb-item active">Detail</li></ul></div></div></div></div>
@if (session('success'))<div class="alert alert-success alert-dismissible fade show"><strong>Sukses!</strong> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
@if (session('error'))<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal!</strong> {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
<div class="row">
    <div class="col-sm-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header"><div class="row align-items-center"><div class="col"><h3 class="page-title">Daftar Tagihan</h3></div><div class="col-auto text-end float-end ms-auto"><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTagihanModal"><i class="fas fa-plus"></i> Tambah Tagihan Manual</button></div></div></div>
                @forelse($tagihans as $tagihan)
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between bg-light">
                        <div>
                            <strong>{{ $tagihan->jenisPembayaran->nama_jenis }}</strong>
                            <small class="text-muted d-block">T.A. {{ $tagihan->jenisPembayaran->tahun_ajaran_nama }}</small>
                        </div>
                        <span class="badge {{ $tagihan->status == 'Lunas' ? 'bg-success' : ($tagihan->status == 'Cicilan' ? 'bg-warning' : 'bg-danger') }}">{{ $tagihan->status }}</span>
                    </div>
                    <div class="card-body">
                        <p>Total Tagihan: <strong>Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</strong></p>
                        <p>Sisa Tagihan: <strong>Rp {{ number_format($tagihan->sisa_tagihan, 0, ',', '.') }}</strong></p>
                        @if($tagihan->status != 'Lunas')
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $tagihan->id }}">Bayar/Cicil</button>
                        @endif
                        <hr>
                        <h6>Riwayat Pembayaran:</h6>
                        @if($tagihan->pembayaran->isEmpty())
                        <p class="text-muted">Belum ada pembayaran.</p>
                        @else
                        <ul>
                            @foreach($tagihan->pembayaran->sortByDesc('tanggal_bayar') as $p)
                            <li>
                                @if($p->termin_ke) Termin {{ $p->termin_ke }}: @endif
                                Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }} 
                                ({{ \Carbon\Carbon::parse($p->tanggal_bayar)->locale('id')->isoFormat('D MMM Y') }}) 
                                <a href="{{ route('keuangan.kwitansi.cetak', $p->id) }}" target="_blank"><i class="fas fa-print"></i></a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
                {{-- Modal Pembayaran Cicilan --}}
                <div class="modal fade" id="paymentModal{{ $tagihan->id }}" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
                    <div class="modal-header"><h5 class="modal-title">Pembayaran: {{ $tagihan->jenisPembayaran->nama_jenis }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <form action="{{ route('keuangan.pembayaran.store', $tagihan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <p>Sisa Tagihan: Rp {{ number_format($tagihan->sisa_tagihan, 0, ',', '.') }}</p>
                            <div class="form-group">
                                <label>Jumlah Bayar</label>
                                <input type="text" class="form-control input-uang" placeholder="Masukkan Jumlah Bayar" required>
                                <input type="hidden" name="jumlah_bayar" class="input-uang-real" max="{{ $tagihan->sisa_tagihan }}">
                            </div>
                            <div class="form-group"><label>Tanggal Bayar</label><input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required></div>
                            <div class="form-group"><label>Metode Bayar</label><select name="metode_bayar" class="form-control" required><option value="Tunai">Tunai</option><option value="Transfer">Transfer</option></select></div>
                            <div class="form-group"><label>Bukti Pembayaran (Opsional)</label><input type="file" name="bukti_pembayaran" class="form-control"></div>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-success">Simpan</button></div>
                    </form>
                </div></div></div>
                @empty
                <!-- PERUBAHAN 3: Ubah pesan kosong -->
                <p class="text-center">Belum ada tagihan untuk siswa ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
{{-- Modal Tambah Tagihan Manual --}}
<div class="modal fade" id="addTagihanModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Tambah Tagihan Manual</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form action="{{ route('keuangan.tagihan.store', $siswa->id) }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group"><label>Jenis Pembayaran</label>
                <!-- PERUBAHAN 4: Gunakan optgroup untuk mengelompokkan -->
                <select name="jenis_pembayaran_id" class="form-control" required>
                    <option value="">Pilih...</option>
                    @foreach($jenisPembayaranTersedia as $tahun => $jenis)
                        <optgroup label="Tahun Ajaran {{ $tahun }}">
                            @foreach($jenis as $jp)
                                <option value="{{$jp->id}}">{{$jp->nama_jenis}} (Rp {{number_format($jp->jumlah_default,0,',','.')}})</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Tambah</button></div>
    </form>
</div></div></div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cari semua input dengan kelas 'input-uang'
    document.querySelectorAll('.input-uang').forEach(inputDisplay => {
        
        // Cari elemen input 'real' yang berpasangan
        const inputReal = inputDisplay.nextElementSibling; 

        inputDisplay.addEventListener('input', function(e) {
            // 1. Ambil nilai mentah & hapus semua karakter selain angka
            let rawValue = e.target.value.replace(/[^0-9]/g, '');
            
            // 2. Simpan nilai mentah ke input tersembunyi
            inputReal.value = rawValue;

            // 3. Format nilai untuk ditampilkan ke pengguna
            if (rawValue) {
                const formattedValue = new Intl.NumberFormat('id-ID').format(rawValue);
                e.target.value = formattedValue;
            } else {
                e.target.value = ''; // Kosongkan jika tidak ada angka
            }
        });
    });
});
</script>
@endpush