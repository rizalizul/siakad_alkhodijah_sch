<?php

namespace App\Http\Controllers;

use App\Models\GuruMapel;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class JadwalPelajaranController extends Controller
{
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
        if (!$tahunAjaranAktif) { return back()->with('error', 'Tidak ada tahun ajaran yang aktif.'); }
        
        $kelases = Kelas::where('tahun_ajaran_nama', $tahunAjaranAktif->nama)->orderBy('tingkat_kelas')->get();
        return view('admin.jadwal.index', compact('kelases', 'tahunAjaranAktif'));
    }

    public function show(Kelas $kela)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();
        
        $jamPelajaran = [
            '1' => ['jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'label' => 'Jam Pelajaran 1 (08.00 - 10.00)'],
            '2' => ['jam_mulai' => '10:30', 'jam_selesai' => '11:30', 'label' => 'Jam Pelajaran 2 (10.30 - 11.30)'],
            '3' => ['jam_mulai' => '12:00', 'jam_selesai' => '13:00', 'label' => 'Jam Pelajaran 3 (12.00 - 13.00)'],
        ];

        $penugasan = GuruMapel::with(['guru', 'mapel'])
            ->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)
            ->get();
        $jadwals = JadwalPelajaran::where('kelas_id', $kela->id)
            ->with(['mapel', 'guru'])
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        return view('admin.jadwal.show', compact('kela', 'penugasan', 'jadwals', 'hari', 'jamPelajaran'));
    }

    public function store(Request $request, Kelas $kela)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_pelajaran' => 'required',
            // 'jam_mulai' => 'required|date_format:H:i',
            // 'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'guru_mapel_id' => 'required|exists:guru_mapel,id',
        ]);

        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();
        $guruMapel = GuruMapel::findOrFail($request->guru_mapel_id);

        $jamPelajaran = [
            '1' => ['jam_mulai' => '08:00', 'jam_selesai' => '10:00'],
            '2' => ['jam_mulai' => '10:30', 'jam_selesai' => '11:30'],
            '3' => ['jam_mulai' => '12:00', 'jam_selesai' => '13:00'],
        ];

        // Ambil jam mulai dan jam selesai dari pilihan
        $jamMulai = $jamPelajaran[$request->jam_pelajaran]['jam_mulai'];
        $jamSelesai = $jamPelajaran[$request->jam_pelajaran]['jam_selesai'];

        $konflik = JadwalPelajaran::where('kelas_id', $kela->id)
            ->where('hari', $request->hari)
            ->where(function ($query) use ($jamMulai, $jamSelesai) {
                $query->where(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->where('jam_mulai', '<', $jamSelesai)
                      ->where('jam_selesai', '>', $jamMulai);
                });
            })->exists();

        if ($konflik) {
            return back()->with('error', 'menyimpan jadwal pelajaran! Sudah ada jadwal di jam tersebut.');
        }

        JadwalPelajaran::create([
            'kelas_id' => $kela->id,
            'mapel_id' => $guruMapel->mapel_id,
            'guru_id' => $guruMapel->guru_id,
            'hari' => $request->hari,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'tahun_ajaran_nama' => $tahunAjaranAktif->nama,
        ]);
        return redirect()->route('jadwal.show', $kela->id)->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function update(Request $request, JadwalPelajaran $jadwalPelajaran)
    {
        $request->validate([
            'guru_mapel_id' => 'required|exists:guru_mapel,id',
        ]);

        $guruMapel = GuruMapel::findOrFail($request->guru_mapel_id);

        $jadwalPelajaran->update([
            'mapel_id' => $guruMapel->mapel_id,
            'guru_id' => $guruMapel->guru_id,
        ]);

        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(JadwalPelajaran $jadwalPelajaran)
    {
        $kelasId = $jadwalPelajaran->kelas_id;
        $jadwalPelajaran->delete();
        return redirect()->route('jadwal.show', $kelasId)->with('success', 'Jadwal berhasil dihapus.');
    }

    public function cetak(Kelas $kela)
    {
        $jadwals = JadwalPelajaran::where('kelas_id', $kela->id)
            ->with(['mapel', 'guru'])
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $pdf = Pdf::loadView('admin.jadwal.pdf_jadwal', [
            'kelas' => $kela,
            'jadwals' => $jadwals,
            'hari' => $hari,
        ]);
        return $pdf->stream('jadwal-pelajaran-'.$kela->nama_kelas.'.pdf');
    }
}