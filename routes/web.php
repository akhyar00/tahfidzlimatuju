<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\HafalanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/santri/{id}/progres', [PublicController::class, 'showSantriProgress'])->name('santri.progres.publik');

// RUTE SEMENTARA UNTUK MIGRASI DATABASE (HAPUS SETELAH DIGUNAKAN)
Route::get('/setup-database', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
        return 'SUCCESS: Database has been reset and seeded.';
    } catch (\Exception $e) { 
        return 'ERROR: ' . $e->getMessage(); 
    }
});

/*
|--------------------------------------------------------------------------
| Rute Autentikasi Admin (Login & Logout)
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');

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
    Route::post('/absensi/hapus-semua', [AbsensiController::class, 'hapusSemua'])->name('absensi.hapus_semua');
    
    // Fitur Hafalan
    Route::get('/hafalan/input', [HafalanController::class, 'pilihSesi'])->name('hafalan.input');
    Route::get('/hafalan/input/{sesi}', [HafalanController::class, 'formInput'])->name('hafalan.input.form');
    Route::post('/hafalan/input', [HafalanController::class, 'store'])->name('hafalan.store');
    Route::get('/hafalan/riwayat', [HafalanController::class, 'riwayat'])->name('hafalan.riwayat');
    Route::post('/hafalan/hapus-semua', [HafalanController::class, 'hapusSemua'])->name('hafalan.hapus_semua');

    // Fitur Laporan
    Route::get('/laporan-rekap', [LaporanController::class, 'rekapHarian'])->name('laporan.rekap');
    Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
    
});