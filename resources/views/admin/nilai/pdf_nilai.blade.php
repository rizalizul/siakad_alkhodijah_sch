<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Nilai {{ $mapel->nama_mapel }}</title>
    <style>
        body { font-family: sans-serif; font-size: 8px; }
        .header { text-align: center; margin-bottom: 15px; }
        .header h4, .header p { margin: 0; }
        .info-table { width: 100%; margin-bottom: 15px; font-size: 10px; }
        .nilai-table { width: 100%; border-collapse: collapse; }
        .nilai-table th, .nilai-table td { border: 1px solid #000; padding: 4px; text-align: center; }
        .nilai-table th { background-color: #f2f2f2; }
        .nilai-table td.nama-siswa { text-align: left; }
        .footer { margin-top: 30px; width: 100%; } .signature { float: right; width: 200px; text-align: center; font-size: 10px;}
    </style>
</head>
<body>
    <div class="header">
        <h4>DAFTAR NILAI SEMESTER {{ $tahunAjaranAktif->semester }}</h4>
        <p>AL KHODIJAH ELEMENTARY SCHOOL</p>
    </div>
    <table class="info-table">
        <tr>
            <td width="15%">KELAS</td><td>: {{ $kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td>MATA PELAJARAN</td><td>: {{ $mapel->nama_mapel }}</td>
        </tr>
        <tr>
            <td>TAHUN PELAJARAN</td><td>: {{ $tahunAjaranAktif->nama }}</td>
        </tr>
    </table>
    <table class="nilai-table">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Siswa</th>
                <th colspan="16">Nilai Tujuan Pembelajaran (TP)</th>
                <th rowspan="2">STS</th>
                <th rowspan="2">SAS</th>
                <th rowspan="2">Nilai Akhir</th>
            </tr>
            <tr>
                @for($i = 1; $i <= 16; $i++) <th>TP{{$i}}</th> @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($dataNilaiSiswa as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="nama-siswa">{{ $data['item']->siswa->nama }}</td>
                @for($i = 1; $i <= 16; $i++)
                <td>{{ $data['nilai_tp']->get('TP'.$i) }}</td>
                @endfor
                {{-- PERBAIKAN: Mengakses properti yang benar (nilai_sts dan nilai_sas) --}}
                <td>{{ $data['nilai_sts']->nilai_sts ?? '' }}</td>
                <td>{{ $data['nilai_sas']->nilai_sas ?? '' }}</td>
                <td><strong>{{ $data['nilai_akhir'] }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <div class="signature">
            <p>Mojokerto, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
            <p>Guru Mata Pelajaran,</p>
            <br><br><br>
            <p><strong>( {{ Auth::user()->name }} )</strong></p>
        </div>
    </div>
</body>
</html>
