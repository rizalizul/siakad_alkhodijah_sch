<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Blanko Absensi {{ $kelas->nama_kelas }}</title>
    <style>
        body { font-family: sans-serif; font-size: 9px; } .header { text-align: center; margin-bottom: 15px; } .header h4, .header p { margin: 0; } .info { margin-bottom: 15px; } .info table { width: 40%; } .report-table { width: 100%; border-collapse: collapse; } .report-table th, .report-table td { border: 1px solid #000; padding: 12px 4px; text-align: center; } .report-table th { background-color: #f2f2f2; } .report-table td.nama-siswa { text-align: left; padding-left: 5px; } .footer { margin-top: 30px; width: 100%; } .signature { float: right; width: 200px; text-align: center; }
    </style>
</head>
<body>
    <div class="header"><h4>DAFTAR ABSENSI SISWA AL-KHODIJAH ELEMENTARY SCHOOL</h4><p>TAHUN PELAJARAN {{ $kelas->tahun_ajaran_nama }}</p></div>
    <div class="info"><table><tr><td>BULAN</td><td>: {{ strtoupper($bulan->locale('id')->isoFormat('MMMM Y')) }}</td></tr><tr><td>KELAS</td><td>: {{ strtoupper($kelas->nama_kelas) }}</td></tr></table></div>
    <table class="report-table">
        <thead>
            <tr>
                <th rowspan="2">NO</th><th rowspan="2">NAMA SISWA</th><th colspan="{{ $bulan->daysInMonth }}">TANGGAL</th><th colspan="3">REKAP</th>
            </tr>
            <tr>
                @for ($i = 1; $i <= $bulan->daysInMonth; $i++)<th>{{ $i }}</th>@endfor
                <th>S</th><th>I</th><th>A</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daftarSiswa as $item)
            <tr>
                <td>{{ $loop->iteration }}</td><td class="nama-siswa">{{ $item->siswa->nama }}</td>
                @for ($i = 1; $i <= $bulan->daysInMonth; $i++)<td></td>@endfor
                <td></td><td></td><td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer"><div class="signature"><p>Mojokerto, {{ $bulan->endOfMonth()->isoFormat('D MMMM Y') }}</p><p>Wali Kelas,</p><br><br><br><p><strong>( {{ $kelas->waliKelas->nama ?? '____________________' }} )</strong></p></div></div>
</body>
</html>