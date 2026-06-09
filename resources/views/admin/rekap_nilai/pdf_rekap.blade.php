<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Nilai Siswa {{ $kelas->nama_kelas }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 15px; }
        .header h4, .header p { margin: 0; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .rekap-table { width: 100%; border-collapse: collapse; }
        .rekap-table th, .rekap-table td { border: 1px solid #000; padding: 5px; text-align: center; }
        .rekap-table th { background-color: #f2f2f2; }
        .rekap-table td.nama-siswa { text-align: left; }
        .vertical-text { writing-mode: vertical-rl; transform: rotate(180deg); white-space: nowrap; }
    </style>
</head>
<body>
    <div class="header">
        <h4>REKAP NILAI SISWA</h4>
        <p>AL KHODIJAH ELEMENTARY SCHOOL</p>
    </div>
    <table class="info-table">
        <tr>
            <td width="10%">Nama Sekolah</td><td width="40%">: Al Khodijah Elementary School</td>
            <td width="10%">Semester</td><td width="40%">: {{ $tahunAjaranAktif->semester }}</td>
        </tr>
        <tr>
            <td>Kelas</td><td>: {{ $kelas->nama_kelas }}</td>
            <td>Tahun Pelajaran</td><td>: {{ $tahunAjaranAktif->nama }}</td>
        </tr>
    </table>
    <table class="rekap-table">
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">NAMA SISWA</th>
                <th colspan="{{ $mataPelajaranList->count() }}">NILAI AKHIR</th>
                <th rowspan="2">JUMLAH</th>
                <th rowspan="2">RATA-RATA</th>
                <th rowspan="2">RANKING</th>
            </tr>
            <tr>
                @foreach($mataPelajaranList as $mapel)
                {{-- <th class="vertical-text">{{ $mapel->nama_mapel }}</th> --}}
                <th>{{ $mapel->nama_mapel }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($dataRekap as $rekap)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="nama-siswa">{{ $rekap['siswa']->nama }}</td>
                @foreach($mataPelajaranList as $mapel)
                <td>{{ $rekap['nilai_akhir'][$mapel->id] }}</td>
                @endforeach
                <td><strong>{{ $rekap['jumlah'] }}</strong></td>
                <td><strong>{{ number_format($rekap['rata_rata'], 2) }}</strong></td>
                <td><strong>{{ $rekap['ranking'] }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>