<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Siswa Kelas {{ $kelas->nama_kelas }}</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h3, .header p { margin: 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h3>DAFTAR SISWA KELAS {{ strtoupper($kelas->nama_kelas) }}</h3>
        <p>Tahun Ajaran {{ $tahunAjaranAktif->nama }}</p>
        <p>Wali Kelas: {{ $kelas->waliKelas->nama ?? '-' }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Jenis Kelamin</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($daftarSiswa as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->siswa->nis ?? '-' }}</td>
                <td>{{ $item->siswa->nama }}</td>
                <td>{{ $item->siswa->jenis_kelamin }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Belum ada siswa di kelas ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>