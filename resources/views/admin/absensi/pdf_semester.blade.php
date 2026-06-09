<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi Semester {{ $kelas->nama_kelas }}</title>
    <style>
        body { font-family: sans-serif; } .header { text-align: center; margin-bottom: 20px; } .header h4, .header p { margin: 0; } .report-table { width: 100%; border-collapse: collapse; margin-top: 20px; } .report-table th, .report-table td { border: 1px solid #000; padding: 8px; text-align: center; } .report-table th { background-color: #f2f2f2; } .report-table td.nama-siswa { text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h4>REKAPITULASI ABSENSI SISWA</h4>
        <p>TAHUN PELAJARAN {{ $tahunAjaranAktif->nama }} - SEMESTER {{ $tahunAjaranAktif->semester }}</p>
        <p>KELAS: {{ $kelas->nama_kelas }}</p>
    </div>
    <table class="report-table">
        <thead><tr><th>No</th><th>NIS</th><th>Nama Siswa</th><th>Sakit (S)</th><th>Izin (I)</th><th>Tanpa Keterangan (A)</th></tr></thead>
        <tbody>
            @foreach($report as $data)
            <tr>
                <td>{{ $loop->iteration }}</td><td>{{ $data['siswa']->nis }}</td><td class="nama-siswa">{{ $data['siswa']->nama }}</td><td>{{ $data['S'] }}</td><td>{{ $data['I'] }}</td><td>{{ $data['A'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>