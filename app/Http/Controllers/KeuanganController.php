<?php

namespace App\Http\Controllers;

use App\Models\JenisPembayaran;
use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Throwable;

class KeuanganController extends Controller
{
    public function ppdbIndex()
    {
        $siswaMenungguPembayaran = Siswa::where('status', 'diverifikasi')->latest()->get();
        $tahunAjaranPpdb = TahunAjaran::where('is_ppdb_open', true)->first();
        $biayaFormulir = 0;
        
        if ($tahunAjaranPpdb) {
            $jenisPembayaranFormulir = JenisPembayaran::firstOrCreate(
                [
                    'nama_jenis' => 'Formulir Pendaftaran',
                    'tahun_ajaran_nama' => $tahunAjaranPpdb->nama,
                ],
                ['jumlah_default' => 300000] 
            );
            $biayaFormulir = $jenisPembayaranFormulir->jumlah_default ?? 0;
        }

        return view('admin.keuangan.ppdb_index', compact('siswaMenungguPembayaran', 'biayaFormulir'));
    }


    public function ppdbStorePayment(Request $request, Siswa $siswa)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1',
            'tanggal_bayar' => 'required|date',
            'metode_bayar' => 'required|string',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $tahunAjaranNamaPpdb = $siswa->tahun_ajaran_ppdb;
        if (!$tahunAjaranNamaPpdb) {
            return back()->with('error', 'Tahun ajaran pendaftaran untuk siswa ini tidak ditemukan.');
        }

        // --- PERUBAHAN UTAMA ADA DI SINI ---
        try {
            $pembayaranSelesai = DB::transaction(function () use ($request, $siswa, $tahunAjaranNamaPpdb) {
                // 1. Proses pembayaran formulir
                $jenisPembayaranFormulir = JenisPembayaran::firstOrCreate(
                    ['nama_jenis' => 'Formulir Pendaftaran', 'tahun_ajaran_nama' => $tahunAjaranNamaPpdb],
                    ['jumlah_default' => $request->jumlah_bayar]
                );
                if ($jenisPembayaranFormulir->jumlah_default != $request->jumlah_bayar) {
                    $jenisPembayaranFormulir->update(['jumlah_default' => $request->jumlah_bayar]);
                }

                $tagihanFormulir = Tagihan::create([
                    'siswa_id' => $siswa->id,
                    'jenis_pembayaran_id' => $jenisPembayaranFormulir->id,
                    'jumlah_tagihan' => $request->jumlah_bayar,
                    'sisa_tagihan' => 0,
                    'status' => 'Lunas',
                ]);
                
                $nomorKwitansi = 'KW' . date('Ymd') . $tagihanFormulir->id . $siswa->id;
                $buktiPath = $request->hasFile('bukti_pembayaran') ? $request->file('bukti_pembayaran')->store('bukti_pembayaran/ppdb', 'public') : null;

                $pembayaran = Pembayaran::create([
                    'tagihan_id' => $tagihanFormulir->id,
                    'nomor_kwitansi' => $nomorKwitansi,
                    'jumlah_bayar' => $request->jumlah_bayar,
                    'tanggal_bayar' => $request->tanggal_bayar,
                    'metode_bayar' => $request->metode_bayar,
                    'bukti_pembayaran' => $buktiPath,
                    'dicatat_oleh_user_id' => Auth::id(),
                    'keterangan' => 'Pembayaran Formulir PPDB',
                ]);

                // 2. Buat tagihan biaya masuk otomatis
                $jenisBiayaMasuk = JenisPembayaran::where('nama_jenis', 'like', '%Biaya Masuk%')
                    ->where('tahun_ajaran_nama', $tahunAjaranNamaPpdb)
                    ->first();

                if ($jenisBiayaMasuk) {
                    Tagihan::firstOrCreate(
                        ['siswa_id' => $siswa->id, 'jenis_pembayaran_id' => $jenisBiayaMasuk->id],
                        [
                            'jumlah_tagihan' => $jenisBiayaMasuk->jumlah_default,
                            'sisa_tagihan' => $jenisBiayaMasuk->jumlah_default,
                            'status' => 'Belum Lunas',
                        ]
                    );
                }
                
                // 3. Kembalikan data pembayaran yang sudah dibuat
                return $pembayaran;
            });

            // Jika transaksi berhasil, lanjutkan proses
            $siswa->update(['status' => 'menunggu_screening']);

            $linkKwitansi = route('keuangan.kwitansi.cetak', $pembayaranSelesai->id);
            $no_wa = preg_replace('/^0/', '62', $siswa->no_wa_ortu);
            $pesan = "Terima kasih. Pembayaran formulir pendaftaran untuk ananda *{$siswa->nama}* di Al Khodijah Elementary School telah kami terima.\n\nBerikut adalah link untuk melihat kwitansi pembayaran:\n{$linkKwitansi}\n\nSelanjutnya, ananda dijadwalkan untuk mengikuti proses screening. Informasi jadwal akan kami sampaikan lebih lanjut.\n\nHormat kami,\nBendahara Al Khodijah";
            $whatsappUrl = 'https://wa.me/' . $no_wa . '?text=' . urlencode($pesan);

            return redirect()->route('keuangan.ppdb.index')
                             ->with('success', 'Pembayaran formulir ' . $siswa->nama . ' berhasil! Tagihan Biaya Masuk Sekolah telah dibuat otomatis.')
                             ->with('whatsapp_url', $whatsappUrl)
                             ->with('print_url', $linkKwitansi);

        } catch (Throwable $e) {
            // Jika terjadi error di dalam transaksi, kembalikan dengan pesan error
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan saat menyimpan data. Error: ' . $e->getMessage())
                             ->withInput();
        }
    }

    // ==== CRUD Jenis Pembayaran ====
    public function jenisPembayaranIndex()
    {
        $jenisPembayarans = JenisPembayaran::latest()->get();
        return view('admin.keuangan.jenis_pembayaran.index', compact('jenisPembayarans'));
    }

    public function jenisPembayaranCreate()
    {
        // PERBAIKAN: Ambil nama tahun ajaran yang unik
        $tahunAjarans = TahunAjaran::select('nama')->distinct()->orderBy('nama', 'desc')->get();
        return view('admin.keuangan.jenis_pembayaran.create', compact('tahunAjarans'));
    }

    public function jenisPembayaranStore(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
            'jumlah_default' => 'required|numeric',
            'tahun_ajaran_nama' => 'required|string|exists:tahun_ajaran,nama',
        ]);
        JenisPembayaran::create($request->all());
        return redirect()->route('keuangan.jenis-pembayaran.index')->with('success', 'Jenis pembayaran berhasil ditambahkan.');
    }

    // --- Menampilkan form edit jenis pembayaran.
    public function jenisPembayaranEdit(JenisPembayaran $jenisPembayaran)
    {
        $tahunAjarans = TahunAjaran::select('nama')->distinct()->orderBy('nama', 'desc')->get();
        return view('admin.keuangan.jenis_pembayaran.edit', compact('jenisPembayaran', 'tahunAjarans'));
    }

    // --- Memproses update jenis pembayaran.
    public function jenisPembayaranUpdate(Request $request, JenisPembayaran $jenisPembayaran)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
            'jumlah_default' => 'required|numeric',
            'tahun_ajaran_nama' => 'required|string|exists:tahun_ajaran,nama',
        ]);
        $jenisPembayaran->update($request->all());
        return redirect()->route('keuangan.jenis-pembayaran.index')->with('success', 'Jenis pembayaran berhasil diperbarui.');
    }

    // --- Menghapus jenis pembayaran.
    public function jenisPembayaranDestroy(JenisPembayaran $jenisPembayaran)
    {
        // Cek apakah jenis pembayaran ini sudah digunakan di tagihan
        $isUsed = Tagihan::where('jenis_pembayaran_id', $jenisPembayaran->id)->exists();
        if ($isUsed) {
            return back()->with('error', 'Gagal menghapus! Jenis pembayaran ini sudah digunakan dalam tagihan siswa.');
        }

        $jenisPembayaran->delete();
        return redirect()->route('keuangan.jenis-pembayaran.index')->with('success', 'Jenis pembayaran berhasil dihapus.');
    }

    // --- Pengelolaan Tagihan & Pembayaran Siswa ---
    public function tagihanIndex(Request $request)
    {
        $searchTerm = $request->input('search');

        // --- PERUBAHAN 2: TAMPILKAN SISWA AKTIF & CALON SISWA ---
        $statuses = ['aktif', 'menunggu_screening', 'diverifikasi'];
        $query = Siswa::with('kelasSiswa.kelas')->whereIn('status', $statuses);

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', "%{$searchTerm}%")
                  ->orWhere('nis', 'like', "%{$searchTerm}%")
                  ->orWhere('no_pendaftaran', 'like', "%{$searchTerm}%");
            });
        }

        $siswas = $query->orderBy('nama')->get();
        return view('admin.keuangan.tagihan.index', compact('siswas', 'searchTerm'));
    }

    public function tagihanDetail(Siswa $siswa)
    {
        $tagihans = Tagihan::with(['jenisPembayaran', 'pembayaran'])
            ->where('siswa_id', $siswa->id)
            ->orderBy('id', 'desc') // Mengurutkan dari yang terbaru
            ->get();
            
        
        $jenisPembayaranTersedia = JenisPembayaran::orderBy('tahun_ajaran_nama', 'desc')
            ->get()
            ->groupBy('tahun_ajaran_nama');

        return view('admin.keuangan.tagihan.detail', compact('siswa', 'tagihans', 'jenisPembayaranTersedia'));
    }

    public function tagihanStore(Request $request, Siswa $siswa)
    {
        $request->validate(['jenis_pembayaran_id' => 'required|exists:jenis_pembayaran,id']);
        $jenisPembayaran = JenisPembayaran::find($request->jenis_pembayaran_id);

        $exists = Tagihan::where('siswa_id', $siswa->id)
            ->where('jenis_pembayaran_id', $jenisPembayaran->id)
            ->exists();
        if ($exists) {
            return back()->with('error', 'Siswa ini sudah memiliki tagihan tersebut.');
        }

        Tagihan::create([
            'siswa_id' => $siswa->id,
            'jenis_pembayaran_id' => $jenisPembayaran->id,
            'jumlah_tagihan' => $jenisPembayaran->jumlah_default,
            'sisa_tagihan' => $jenisPembayaran->jumlah_default,
            'status' => 'Belum Lunas',
        ]);
        return back()->with('success', 'Tagihan berhasil ditambahkan untuk siswa.');
    }
    
    public function pembayaranStore(Request $request, Tagihan $tagihan)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1|max:' . $tagihan->sisa_tagihan,
            'tanggal_bayar' => 'required|date',
            'metode_bayar' => 'required|string',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::transaction(function () use ($request, $tagihan) {
            $buktiPath = $request->hasFile('bukti_pembayaran')
                ? $request->file('bukti_pembayaran')->store('bukti_pembayaran/tahunan', 'public')
                : null;
            
            $isOneTimeFullPayment = ($request->jumlah_bayar >= $tagihan->jumlah_tagihan) && ($tagihan->pembayaran()->count() == 0);
            $terminKe = $isOneTimeFullPayment ? null : ($tagihan->pembayaran()->count() + 1);
            $nomorKwitansi = 'KW' . date('Ymd') . $tagihan->id . $terminKe;
            Pembayaran::create([
                'tagihan_id' => $tagihan->id,
                'nomor_kwitansi' => $nomorKwitansi,
                'jumlah_bayar' => $request->jumlah_bayar,
                'tanggal_bayar' => $request->tanggal_bayar,
                'metode_bayar' => $request->metode_bayar,
                'bukti_pembayaran' => $buktiPath,
                'termin_ke' => $terminKe,
                'dicatat_oleh_user_id' => Auth::id(),
            ]);
            $sisaBaru = $tagihan->sisa_tagihan - $request->jumlah_bayar;
            $statusBaru = $sisaBaru <= 0 ? 'Lunas' : 'Cicilan';
            $tagihan->update(['sisa_tagihan' => $sisaBaru, 'status' => $statusBaru]);
        });

        return back()->with('success', 'Pembayaran berhasil dicatat.');
    }
    
    public function cetakKwitansi(Pembayaran $pembayaran)
    {
        // --- PERUBAHAN LOGIKA DIMULAI DI SINI ---

        // 1. Ambil semua pembayaran untuk tagihan ini, termasuk pembayaran saat ini
        $semuaPembayaranTerkait = Pembayaran::where('tagihan_id', $pembayaran->tagihan_id)
            ->orderBy('tanggal_bayar', 'asc')
            ->orderBy('id', 'asc') // Urutkan berdasarkan ID jika tanggal sama
            ->get();

        $totalPembayaranHinggaSaatIni = 0;
        $sisaTagihanSaatItu = $pembayaran->tagihan->jumlah_tagihan;

        // 2. Hitung total pembayaran HANYA sampai pembayaran yang sedang dicetak
        foreach ($semuaPembayaranTerkait as $p) {
            $totalPembayaranHinggaSaatIni += $p->jumlah_bayar;
            // Berhenti menghitung jika sudah mencapai pembayaran yang dicetak
            if ($p->id == $pembayaran->id) {
                break;
            }
        }

        // 3. Hitung sisa tagihan pada saat transaksi ini terjadi
        $sisaTagihanSaatItu = $pembayaran->tagihan->jumlah_tagihan - $totalPembayaranHinggaSaatIni;

        // 4. Tentukan apakah pembayaran ini yang melunasi tagihan
        $isLunasSaatItu = $sisaTagihanSaatItu <= 0;

        // --- AKHIR PERUBAHAN LOGIKA ---

        // Kirim data yang sudah dihitung ke view
        $pdf = Pdf::loadView('admin.keuangan.kwitansi', [
            'pembayaran' => $pembayaran,
            'sisaTagihanSaatItu' => $sisaTagihanSaatItu,
            'isLunasSaatItu' => $isLunasSaatItu,
        ]);
        
        return $pdf->stream('kwitansi-'.$pembayaran->nomor_kwitansi.'.pdf');
    }
}