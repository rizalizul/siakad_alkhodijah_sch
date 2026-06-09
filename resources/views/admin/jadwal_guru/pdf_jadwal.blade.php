<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Jadwal Mengajar - {{ $guru->nama }}</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h3, .header p { margin: 0; }
        .schedule-table { width: 100%; border-collapse: collapse; }
        .schedule-table th, .schedule-table td { border: 1px solid #000; padding: 8px; vertical-align: top; }
        .schedule-table th { background-color: #f2f2f2; text-align: center; }
        .entry { margin-bottom: 10px; border-bottom: 1px dashed #ccc; padding-bottom: 5px; }
        .entry:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .entry p { margin: 0; font-size: 12px; }
        .entry .time { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h3>JADWAL MENGAJAR GURU</h3>
        <p>TAHUN AJARAN {{ $tahunAjaranAktif->nama }}</p>
        <br>
        <p><strong>{{ strtoupper($guru->nama) }}</strong></p>
    </div>
    <table class="schedule-table">
        <thead>
            <tr>
                @foreach($hari as $h)
                <th width="16.66%">{{ $h }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach($hari as $h)
                <td>
                    @if(isset($jadwals[$h]))
                        @foreach($jadwals[$h] as $jadwal)
                        <div class="entry">
                            <p class="time">{{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}</p>
                            <p>{{ $jadwal->mapel->nama_mapel }}</p>
                            <p><i>Kelas: {{ $jadwal->kelas->nama_kelas }}</i></p>
                        </div>
                        <hr>
                        @endforeach
                    @endif
                </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</body>
</html>