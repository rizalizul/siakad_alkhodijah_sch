@extends('layouts.app')
@section('title', 'Pembayaran PPDB')
@section('content')
<style>
    .btn-whatsapp {
        background-color: #25D366; 
        color: white;
        border: none;
    }
    .btn-whatsapp:hover {
        background-color: #1DA851; 
        color: white;
    }
</style>
<div class="page-header">
    <div class="row">
        <div class="col"><h3 class="page-title">Keuangan</h3><ul class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Pembayaran PPDB</li></ul></div>
    </div>
</div>
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Sukses!</strong> {{ session('success') }}
    @if (session('print_url'))
        <a href="{{ session('print_url') }}" target="_blank" class="btn btn-sm btn-success ms-3"><i class="fas fa-print"></i> Cetak Kwitansi Sekarang</a>
    @endif
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Gagal!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if ($errors->any())<div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="row">
    <div class="col-md-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header"><div class="row align-items-center"><div class="col"><h3 class="page-title">Siswa Menunggu Pembayaran Formulir</h3></div></div></div>
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0 datatable">
                        <thead><tr><th>#</th><th>Nama Calon Siswa</th><th>Nama Ayah</th><th>No. WA Ortu</th><th class="text-end">Aksi</th></tr></thead>
                        <tbody>
                            @foreach ($siswaMenungguPembayaran as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>{{ $siswa->nama_ayah }}</td>
                                <td>{{ $siswa->no_wa_ortu }}</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        @php
                                            $no_wa = preg_replace('/^0/', '62', $siswa->no_wa_ortu);
                                            $biayaFormatted = number_format($biayaFormulir, 0, ',', '.');
                                            $pesan = "Yth. Orang Tua/Wali dari calon siswa *{$siswa->nama}*,\n\n";
                                            $pesan .= "Kami informasikan bahwa data pendaftaran ananda telah kami verifikasi. Tahap selanjutnya adalah pembayaran biaya formulir pendaftaran sebesar *Rp {$biayaFormatted}*.\n\n";
                                            $pesan .= "Pembayaran dapat dilakukan melalui transfer ke rekening berikut:\n";
                                            $pesan .= "Bank: *Bank Syariah Indonesia (BSI)*\n";
                                            $pesan .= "No. Rekening: *7168088404*\n";
                                            $pesan .= "Atas Nama: *Al Khodijah Elementary School*\n\n";
                                            $pesan .= "Mohon untuk mengirimkan bukti transfer setelah pembayaran dilakukan. Terima kasih atas perhatiannya.\n\n";
                                            $pesan .= "Hormat kami,\nBendahara Al Khodijah Elementary School";
                                            $whatsappUrl = 'https://wa.me/' . $no_wa . '?text=' . urlencode($pesan);
                                        @endphp
                                        <a href="{{ $whatsappUrl ?? '#' }}" target="_blank" class="btn btn-sm btn-whatsapp">
                                            <i class="fab fa-whatsapp me-1"></i> Informasikan Tagihan
                                        </a>

                                        <button type="button" class="btn btn-sm bg-info-light" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $siswa->id }}">
                                            <i class="fas fa-dollar-sign me-1"></i> Catat Pembayaran
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            {{-- Modal Pembayaran --}}
                            <div class="modal fade" id="paymentModal{{ $siswa->id }}" tabindex="-1" aria-labelledby="paymentModalLabel{{ $siswa->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header"><h5 class="modal-title" id="paymentModalLabel{{ $siswa->id }}">Pembayaran Formulir: {{ $siswa->nama }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                                        
                                        <form action="{{ route('keuangan.ppdb.bayar', $siswa->id) }}" method="POST" enctype="multipart/form-data" 
                                              onsubmit="document.getElementById('submitBtn{{ $siswa->id }}').innerHTML = 'Menyimpan...'; document.getElementById('submitBtn{{ $siswa->id }}').disabled = true;">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group"><label>Jumlah Bayar <span class="login-danger">*</span></label><input type="number" name="jumlah_bayar" class="form-control" value="{{ $biayaFormulir > 0 ? $biayaFormulir : '' }}" placeholder="Masukkan jumlah pembayaran" required></div>
                                                <div class="form-group"><label>Tanggal Bayar <span class="login-danger">*</span></label><input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required></div>
                                                <div class="form-group"><label>Metode Bayar <span class="login-danger">*</span></label><select name="metode_bayar" class="form-control" required><option value="Tunai">Tunai</option><option value="Transfer">Transfer</option></select></div>
                                                <div class="form-group">
                                                    <label>Upload Bukti Pembayaran (Opsional)</label>
                                                    <input type="file" name="bukti_pembayaran" class="form-control">
                                                    <small class="form-text text-muted">Format: JPG, PNG, PDF. Maksimal 2MB.</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success" id="submitBtn{{ $siswa->id }}">Simpan & Kirim WA</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('whatsapp_url'))
            window.open("{{ session('whatsapp_url') }}", '_blank');
        @endif
    });
</script>
@endpush