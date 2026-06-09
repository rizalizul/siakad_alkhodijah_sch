<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Kwitansi - {{ $pembayaran->nomor_kwitansi }}</title>
    <style>
        body { 
            font-family: 'Helvetica', sans-serif; 
            margin: 0px; 
            font-size: 14px;
            color: #333;
        }
        .container { 
            border: 1px solid #ddd; 
            padding: 0px 30px 130px; 
            position: relative;
            
        }
        .header img {
            width: 100%;
        }
        .title {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .title h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .details-table { 
            width: 100%; 
            border-collapse: collapse;
        }
        .details-table td { 
            padding: 10px 0;
            vertical-align: top;
        }
        .details-table td:first-child {
            width: 25%;
        }
        .footer { 
            margin-top: 0px; 
            width: 100%;
        }
        .signature { 
            float: right; 
            width: 250px; 
            text-align: center; 
        }
        .lunas-stamp {
            position: absolute;
            top: 150px;
            right: 40px;
            font-size: 28px;
            font-weight: bold;
            color: #28a745;
            border: 4px solid #28a745;
            padding: 10px;
            transform: rotate(-15deg);
            opacity: 0.8;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        @if($isLunasSaatItu)
            <div class="lunas-stamp">LUNAS</div>
        @endif

        <div class="header">
            <img src="{{ public_path('assets/img/header-alkhodijah.png') }}" alt="Header Sekolah">
        </div>

        <div class="title">
            <h2><u>KWITANSI PEMBAYARAN</u></h2>
        </div>

        <table class="details-table">
            <tr>
                <td>No. Kwitansi</td>
                <td>: {{ $pembayaran->nomor_kwitansi }}</td>
            </tr>
            <tr>
                <td>Tahun Ajaran</td>
                <td>: {{ $pembayaran->tagihan->siswa->tahun_ajaran_ppdb }}</td>
            </tr>
             <tr>
                <td>Tanggal Bayar</td>
                <td>: {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->locale('id')->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td>Telah diterima dari</td>
                <td>: Orang Tua/Wali dari <strong>{{ $pembayaran->tagihan->siswa->nama }}</strong></td>
            </tr>
            <tr>
                <td>Uang Sejumlah</td>
                <td>: <strong>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td>Untuk Pembayaran</td>
                <td>
                    : {{ $pembayaran->tagihan->jenisPembayaran->nama_jenis }}
                    @if($pembayaran->termin_ke  && $pembayaran->tagihan->jumlah_tagihan > 1000000)
                        (Termin ke-{{ $pembayaran->termin_ke }})
                    @endif
                </td>
            </tr>
            @if(!$isLunasSaatItu && $sisaTagihanSaatItu > 0)
            <tr>
                <td>Sisa Tagihan</td>
                <td>: <strong>Rp {{ number_format($sisaTagihanSaatItu, 0, ',', '.') }}</strong></td>
            </tr>
            @endif
        </table>

        <div class="footer">
            <div class="signature">
                <p>Kota Mojokerto, {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->locale('id')->isoFormat('D MMMM Y') }}</p>
                <br><br><br>
                <p><strong>( {{ $pembayaran->user->name ?? 'Bendahara' }} )</strong></p>
            </div>
        </div>
    </div>
</body>
</html>
