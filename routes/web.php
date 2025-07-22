<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthOrangtuaController;
use App\Http\Controllers\CalonSiswaController;
use App\Http\Controllers\TahunPelajaranController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;

Route::get('/', function () {
    return view('welcome');
});

// Login/Logout
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
// ortu
Route::get('/login-orangtua', [AuthOrangtuaController::class, 'showLoginForm'])->name('login.orangtua');
Route::post('/login-orangtua', [AuthOrangtuaController::class, 'login']);
Route::middleware('auth:guardian')->group(function () {
    Route::get('/dashboard-orangtua', function () {
        return view('orangtua.dashboard');
    });
});

// PPDB
Route::get('ppdb', [CalonSiswaController::class, 'formulir'])->name('ppdb.formulir');
Route::post('ppdb', [CalonSiswaController::class, 'simpan'])->name('ppdb.store');
Route::get('ppdb/data', [CalonSiswaController::class, 'index'])->name('ppdb.index');
Route::get('ppdb/verifikasi/{id}', [CalonSiswaController::class, 'verifikasiForm'])->name('ppdb.verifikasi');
Route::post('ppdb/verifikasi/{id}', [CalonSiswaController::class, 'prosesVerifikasi'])->name('ppdb.verifikasi.submit');

Route::get('siswa/data', [SiswaController::class, 'index'])->name('siswa.index');
Route::resource('siswa', SiswaController::class)->only(['index', 'show', 'edit', 'update']);

// Superadmin
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/dashboard-superadmin', function () {
        return view('dashboard.dashboard_superadmin');
    })->name('dashboard.superadmin');
    Route::resource('tahun-pelajaran', TahunPelajaranController::class);
    Route::resource('semester', SemesterController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('mata-pelajaran', MataPelajaranController::class);
    Route::resource('ekstrakurikuler', EkstrakurikulerController::class);
    Route::resource('kelas', KelasController::class);

    // Route::get('/test-role', fn () => 'Anda Superadmin')->middleware('role:superadmin');
});

// guru
// Route::middleware(['auth', 'role:guru_mapel'])->group(function () {
//     Route::get('/dashboard-guru', [GuruController::class, 'index'])->name('dashboard.guru');
// });

