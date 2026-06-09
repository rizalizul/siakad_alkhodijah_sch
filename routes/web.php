<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\GuruMapelController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\RekapNilaiController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\JadwalGuruController;
use App\Http\Controllers\WaliKelasSiswaController;
use App\Http\Controllers\SiswaController;

// Halaman utama, langsung arahkan ke login
Route::get('/', fn() => redirect()->route('login'));

// Routes untuk Otentikasi
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// == ROUTES PUBLIK UNTUK PPDB ==
Route::get('/pendaftaran-siswa-baru', [PpdbController::class, 'create'])->name('ppdb.create');
Route::post('/pendaftaran-siswa-baru', [PpdbController::class, 'store'])->name('ppdb.store');
Route::get('/pendaftaran-sukses', [PpdbController::class, 'success'])->name('ppdb.success');

// Group routes yang memerlukan login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route untuk Profil Saya
    Route::get('/profil-saya', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profil-saya/details', [ProfileController::class, 'updateDetails'])->name('profile.update.details');
    Route::put('/profil-saya/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    
    // == Staf Administrasi ==
    Route::middleware(['role:staf_administrasi'])->group(function () {
        Route::resource('users', UserController::class);
        // Route::resource('guru', GuruController::class); -- ada di admin+wakasek
        Route::get('/admin/ppdb', [PpdbController::class, 'adminIndex'])->name('admin.ppdb.index');
        Route::get('/admin/ppdb/{siswa}', [PpdbController::class, 'adminShow'])->name('admin.ppdb.show');
        Route::patch('/admin/ppdb/{siswa}/verifikasi', [PpdbController::class, 'updateStatus'])->name('admin.ppdb.verifikasi');
        Route::get('/admin/ppdb/{siswa}/edit', [PpdbController::class, 'adminEdit'])->name('admin.ppdb.edit');
        Route::put('/admin/ppdb/{siswa}/update', [PpdbController::class, 'adminUpdate'])->name('admin.ppdb.update');
    });
    
    // == Bendahara  ==
    Route::middleware(['role:bendahara'])->group(function () {
        // Pembayaran PPDB
        Route::get('/keuangan/ppdb', [KeuanganController::class, 'ppdbIndex'])->name('keuangan.ppdb.index');
        Route::post('/keuangan/ppdb/{siswa}/bayar', [KeuanganController::class, 'ppdbStorePayment'])->name('keuangan.ppdb.bayar');

        // CRUD Jenis Pembayaran
        Route::get('/keuangan/jenis-pembayaran', [KeuanganController::class, 'jenisPembayaranIndex'])->name('keuangan.jenis-pembayaran.index');
        Route::get('/keuangan/jenis-pembayaran/create', [KeuanganController::class, 'jenisPembayaranCreate'])->name('keuangan.jenis-pembayaran.create');
        Route::post('/keuangan/jenis-pembayaran', [KeuanganController::class, 'jenisPembayaranStore'])->name('keuangan.jenis-pembayaran.store');
        Route::get('/keuangan/jenis-pembayaran/{jenisPembayaran}/edit', [KeuanganController::class, 'jenisPembayaranEdit'])->name('keuangan.jenis-pembayaran.edit');
        Route::put('/keuangan/jenis-pembayaran/{jenisPembayaran}', [KeuanganController::class, 'jenisPembayaranUpdate'])->name('keuangan.jenis-pembayaran.update');
        Route::delete('/keuangan/jenis-pembayaran/{jenisPembayaran}', [KeuanganController::class, 'jenisPembayaranDestroy'])->name('keuangan.jenis-pembayaran.destroy');

        // Pengelolaan Tagihan & Pembayaran
        Route::get('/keuangan/tagihan', [KeuanganController::class, 'tagihanIndex'])->name('keuangan.tagihan.index');
        Route::get('/keuangan/tagihan', [KeuanganController::class, 'tagihanIndex'])->name('keuangan.tagihan.index');
        Route::get('/keuangan/tagihan/{siswa}/detail', [KeuanganController::class, 'tagihanDetail'])->name('keuangan.tagihan.detail');
        Route::post('/keuangan/tagihan/{siswa}/store', [KeuanganController::class, 'tagihanStore'])->name('keuangan.tagihan.store');
        Route::post('/keuangan/pembayaran/{tagihan}/store', [KeuanganController::class, 'pembayaranStore'])->name('keuangan.pembayaran.store');
        Route::get('/keuangan/kwitansi/{pembayaran}/cetak', [KeuanganController::class, 'cetakKwitansi'])->name('keuangan.kwitansi.cetak');
    });

    // == Wakasek Kurikulum ==
    Route::middleware(['role:wakasek_kurikulum'])->group(function () {
        // Manajemen Kelas
        Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
        Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
        Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
        Route::get('/kelas/{kela}', [KelasController::class, 'show'])->name('kelas.show');
        Route::delete('/kelas/{kela}', [KelasController::class, 'destroy'])->name('kelas.destroy');
        Route::post('/kelas/{kela}/update-siswa', [KelasController::class, 'updateSiswa'])->name('kelas.updateSiswa');
        Route::get('/kelas/{kela}/cetak-siswa', [KelasController::class, 'cetakSiswa'])->name('kelas.cetakSiswa');
        Route::get('/api/kelas/{kelas}/get-siswa', [KelasController::class, 'fetchSiswaFromKelas'])->name('api.kelas.getSiswa');
        
        // Penugasan Guru Mengajar
        Route::get('/guru-mapel', [GuruMapelController::class, 'index'])->name('guru-mapel.index');
        Route::get('/guru-mapel/create', [GuruMapelController::class, 'create'])->name('guru-mapel.create');
        Route::post('/guru-mapel', [GuruMapelController::class, 'store'])->name('guru-mapel.store');
        Route::delete('/guru-mapel/{guruMapel}', [GuruMapelController::class, 'destroy'])->name('guru-mapel.destroy');

        // Pembuatan Jadwal Pelajaran
        Route::get('/jadwal', [JadwalPelajaranController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/{kela}', [JadwalPelajaranController::class, 'show'])->name('jadwal.show');
        Route::post('/jadwal/{kela}', [JadwalPelajaranController::class, 'store'])->name('jadwal.store');
        Route::delete('/jadwal/{jadwalPelajaran}', [JadwalPelajaranController::class, 'destroy'])->name('jadwal.destroy');
        Route::get('/jadwal/{kela}/cetak', [JadwalPelajaranController::class, 'cetak'])->name('jadwal.cetak');
        Route::put('/jadwal/{jadwalPelajaran}', [JadwalPelajaranController::class, 'update'])->name('jadwal.update');
    });

    // == Wali Kelas
    Route::middleware(['role:wali_kelas'])->group(function () {
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/absensi/manage', [AbsensiController::class, 'manage'])->name('absensi.manage');
        Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');
        Route::get('/absensi/monthly', [AbsensiController::class, 'monthlyReport'])->name('absensi.monthly');
        Route::get('/absensi/cetak-blanko', [AbsensiController::class, 'cetakBlanko'])->name('absensi.cetakBlanko');
        Route::get('/absensi/cetak-semester', [AbsensiController::class, 'cetakSemester'])->name('absensi.cetakSemester');
        Route::get('/rekap-nilai', [RekapNilaiController::class, 'index'])->name('rekap-nilai.index');
        Route::get('/rekap-nilai/cetak', [RekapNilaiController::class, 'cetak'])->name('rekap-nilai.cetak');
        Route::get('/wali-kelas/siswa', [WaliKelasSiswaController::class, 'index'])->name('wali-kelas.siswa.index');

        // Rapor
        Route::get('/rapor', [RaporController::class, 'index'])->name('rapor.index');
        Route::get('/rapor/proses/{kelasSiswa}', [RaporController::class, 'proses'])->name('rapor.proses');
        Route::put('/rapor/update/{rapor}', [RaporController::class, 'update'])->name('rapor.update');
        Route::get('/rapor/cetak/{rapor}', [RaporController::class, 'cetak'])->name('rapor.cetak');
    });

    // Kepala Sekolah
    Route::middleware(['role:kepala_sekolah'])->group(function () {
        Route::get('/persetujuan-rapor', [RaporController::class, 'kepsekIndex'])->name('rapor.kepsek.index');
        Route::patch('/persetujuan-rapor/{rapor}/approve', [RaporController::class, 'kepsekApprove'])->name('rapor.kepsek.approve');
    });

    // == wali_kelas & wakasek_kurikulum (ROUTES SCREENING) ==
    Route::middleware(['role:wali_kelas,wakasek_kurikulum'])->group(function () {
        Route::get('/screening', [PpdbController::class, 'screeningIndex'])->name('screening.index');
        Route::patch('/screening/{siswa}/update', [PpdbController::class, 'screeningUpdate'])->name('screening.update');
    });

    // == Staf Administrasi & Wakasek Kurikulum ==
    Route::middleware(['role:staf_administrasi,wakasek_kurikulum'])->group(function () {
        Route::resource('tahun-ajaran', TahunAjaranController::class)->except(['show']);
        Route::patch('tahun-ajaran/{id}/set-active', [TahunAjaranController::class, 'setActive'])->name('tahun-ajaran.setActive');
        Route::patch('tahun-ajaran/{id}/set-ppdb', [TahunAjaranController::class, 'setPpdbOpen'])->name('tahun-ajaran.setPpdb');
        Route::patch('tahun-ajaran/{id}/close-ppdb', [TahunAjaranController::class, 'closePpdbOpen'])->name('tahun-ajaran.closePpdb');
        Route::resource('mata-pelajaran', MataPelajaranController::class);
        Route::resource('guru', GuruController::class);
        Route::resource('siswa', SiswaController::class)->except(['create', 'store']);
        Route::resource('ekstrakurikuler', EkstrakurikulerController::class)->except(['show']);
    });

    // == Guru Mapel & Wali Kelas ==
    Route::middleware(['role:guru_mapel,wali_kelas'])->group(function () {
        Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::get('/nilai/manage', [NilaiController::class, 'manage'])->name('nilai.manage');
        Route::post('/nilai/store', [NilaiController::class, 'store'])->name('nilai.store');
        Route::get('/nilai/cetak', [NilaiController::class, 'cetak'])->name('nilai.cetak');
        Route::post('/nilai/store-tp', [NilaiController::class, 'storeTp'])->name('nilai.store.tp');
        Route::put('/nilai/update-tp', [NilaiController::class, 'updateTp'])->name('nilai.update.tp');
        Route::get('/jadwal-mengajar', [JadwalGuruController::class, 'index'])->name('jadwal-guru.index');
        Route::get('/jadwal-mengajar/cetak', [JadwalGuruController::class, 'cetak'])->name('jadwal-guru.cetak');
    });
});

// == ROUTES PORTAL ORANG TUA ==
Route::prefix('portal-orang-tua')->name('ortu.')->middleware('web')->group(function () {
    Route::get('/login', [OrtuController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [OrtuController::class, 'login'])->name('login.submit');
    Route::post('/logout', [OrtuController::class, 'logout'])->name('logout');

    // Grup route yang dilindungi middleware
    Route::middleware('ortu.auth')->group(function () {
        Route::get('/dashboard', [OrtuController::class, 'dashboard'])->name('dashboard');
        Route::get('/absensi-detail', [OrtuController::class, 'detailAbsensi'])->name('absensi.detail');
        Route::get('/jadwal/cetak', [OrtuController::class, 'cetakJadwal'])->name('jadwal.cetak');
    });
});