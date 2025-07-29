<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\HafalanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| Konfigurasi URL
|--------------------------------------------------------------------------
| Memaksa Laravel untuk menggunakan URL yang benar dari file .env.
*/
URL::forceRootUrl(config('app.url'));
URL::forceScheme('https');
/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/santri/{id}/progres', [PublicController::class, 'showSantriProgress'])->name('santri.progres.publik');

/*
|--------------------------------------------------------------------------
| Rute Autentikasi Admin (Login & Logout)
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::get('/logout-manual', function () {
    Session::flush();
    return 'Sesi Anda telah dihapus. Silakan kembali ke halaman login.';
});

/*
|--------------------------------------------------------------------------
| Rute Admin (Dilindungi oleh Middleware 'admin.auth')
|--------------------------------------------------------------------------
*/
Route::middleware('admin.auth')->group(function () {
    
    // Dashboard & Logout
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin', fn() => redirect()->route('admin.dashboard'))->name('admin.index');
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Fitur Manajemen Santri (CRUD)
    Route::resource('santri', SantriController::class);

    // Fitur Absensi
    Route::get('/absensi', [AbsensiController::class, 'riwayat'])->name('absensi.index');
    Route::get('/absensi/input', [AbsensiController::class, 'pilihSesi'])->name('absensi.input');
    Route::get('/absensi/input/{sesi}', [AbsensiController::class, 'formInput'])->name('absensi.input.form');
    Route::post('/absensi/input', [AbsensiController::class, 'store'])->name('absensi.store');
    
    // Fitur Hafalan
    Route::get('/hafalan/input', [HafalanController::class, 'pilihSesi'])->name('hafalan.input');
    Route::get('/hafalan/input/{sesi}', [HafalanController::class, 'formInput'])->name('hafalan.input.form');
    Route::post('/hafalan/input', [HafalanController::class, 'store'])->name('hafalan.store');
    Route::get('/hafalan/riwayat', [HafalanController::class, 'riwayat'])->name('hafalan.riwayat');

    // Fitur Laporan
    Route::get('/laporan-rekap', [LaporanController::class, 'rekapHarian'])->name('laporan.rekap');
    Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
    
    // ... route absensi lainnya
    Route::post('/absensi/hapus-semua', [AbsensiController::class, 'hapusSemua'])->name('absensi.hapus_semua');
    Route::post('/hafalan/hapus-semua', [HafalanController::class, 'hapusSemua'])->name('hafalan.hapus_semua');
});