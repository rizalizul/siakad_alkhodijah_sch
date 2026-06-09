<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rapor Siswa - {{ $rapor->kelasSiswa->siswa->nama }}</title>
    <style>
        @page {
            margin: 0; /* Menghilangkan margin default */
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            margin: 2.5cm 2cm 2cm 2cm; /* Margin: top, right, bottom, left */
        }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .header-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            line-height: 1.4;
        }
        .table-info {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .table-info td {
            padding: 2px 5px;
            vertical-align: top;
        }
        .table-nilai {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .table-nilai th, .table-nilai td {
            border: 1px solid black;
            padding: 5px;
            /* text-align: left; */
            vertical-align: top;
        }
        .table-nilai th {
            text-align: center;
            background-color: #f2f2f2;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .signature-section {
            margin-top: 40px;
            width: 100%;
        }
        .signature-box {
            width: 33%;
            float: left;
            text-align: center;
        }
        .signature-box.right { float: right; }
        .signature-box.left { float: left; }
        .signature-name {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="header-title">
        RAPOR PESERTA DIDIK<br>
        SEKOLAH DASAR (SD)<br>
        AL KHODIJAH ELEMENTARY SCHOOL
    </div>

    {{-- Informasi Siswa --}}
    <table class="table-info">
        <tr>
            <td width="20%">Nama Peserta Didik</td><td width="1%">:</td><td width="39%"  style="text-transform:uppercase; font-weight: bold;">{{ $rapor->kelasSiswa->siswa->nama }}</td>
            <td width="20%">Kelas</td><td width="1%">:</td><td width="19%">{{ $rapor->kelasSiswa->kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td>NISN/NIS</td><td>:</td><td>{{ $rapor->kelasSiswa->siswa->nisn }} / {{ $rapor->kelasSiswa->siswa->nis }}</td>
            <td>Semester</td><td>:</td><td>{{ $rapor->tahunAjaran->semester }}</td>
        </tr>
        <tr>
            <td>Nama Sekolah</td><td>:</td><td>Al Khodijah Elementary School</td>
            <td>Tahun Pelajaran</td><td>:</td><td>{{ $rapor->tahunAjaran->nama }}</td>
        </tr>
    </table>

    {{-- Tabel Nilai Akademik --}}
    <div class="section-title">A. NILAI AKADEMIK</div>
    <table class="table-nilai">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="25%">Mata Pelajaran</th>
                <th width="10%">Nilai Akhir</th>
                <th>Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilaiAkademik as $index => $nilai)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $nilai['mapel']->nama_mapel }}</td>
                <td class="text-center">{{ $nilai['nilai_akhir'] }}</td>
                <td>{{ $nilai['deskripsi'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tabel Ekstrakurikuler --}}
    <div class="section-title">B. EKSTRAKURIKULER</div>
    <table class="table-nilai">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="35%">Kegiatan Ekstrakurikuler</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rapor->nilaiEkstrakurikuler as $index => $ekskul)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $ekskul->nama_ekskul }}</td>
                <td>{{ $ekskul->keterangan }}</td>
            </tr>
            @empty
            <tr><td colspan="3" class="text-center">Tidak ada kegiatan ekstrakurikuler yang diikuti.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- Ketidakhadiran --}}
    <div class="section-title">C. KETIDAKHADIRAN</div>
    <table class="table-info" style="width: 40%; border: 1px solid black;">
        <tr style="border-bottom: 1px solid black;"><td width="40%">Sakit</td><td width="1%">:</td><td>{{ $rekapAbsensi->get('Sakit', 0) }} hari</td></tr>
        <tr style="border-bottom: 1px solid black;"><td>Izin</td><td>:</td><td>{{ $rekapAbsensi->get('Izin', 0) }} hari</td></tr>
        <tr><td>Tanpa Keterangan</td><td>:</td><td>{{ $rekapAbsensi->get('Tanpa Keterangan', 0) }} hari</td></tr>
    </table>

    {{-- Catatan Wali Kelas --}}
    <div class="section-title">D. CATATAN WALI KELAS</div>
    <table class="table-nilai">
        <tr><td style="height: 60px; vertical-align: top;">{{ $rapor->catatan_wali_kelas ?? '' }}</td></tr>
    </table>

    {{-- Keputusan Akhir Tahun (Hanya tampil di semester 2) --}}
    @if($rapor->tahunAjaran->semester == 2)
    <div class="section-title">E. KEPUTUSAN AKHIR TAHUN</div>
    <table class="table-nilai">
        <tr>
            <td>
                Berdasarkan hasil yang dicapai pada semester 1 dan 2, peserta didik ditetapkan: <br>
                <span class="text-bold" style="font-size: 14px; padding-left: 20px;">
                    @if($rapor->naik_kelas === 1) Naik Kelas
                    @elseif($rapor->naik_kelas === 0) Tinggal Kelas
                    @else Belum ditentukan
                    @endif
                </span>
            </td>
        </tr>
    </table>
    @endif

    {{-- Tanda Tangan --}}
    <div class="signature-section">
        <div class="signature-box left">
            Mengetahui,<br>
            Orang Tua/Wali,
            <div class="signature-name">
                '(.................................)'
            </div>
        </div>
        <div class="signature-box right">
            Mojokerto, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}<br>
            Wali Kelas,
            <div class="signature-name">
                {{ $rapor->kelasSiswa->kelas->waliKelas->nama ?? '(..............................)' }}
            </div>
            NIP. {{ $rapor->kelasSiswa->kelas->waliKelas->nip ?? '-' }}
        </div>
        <div class="clear"></div>
    </div>
    <div class="signature-section">
        <div class="signature-box" style="width:100%;">
            Mengetahui,<br>
            Kepala Sekolah,
            <div class="signature-name">
                AFIFATUR ROSIDAH, S.Si. M.Sc
            </div>
            NIP. -
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
