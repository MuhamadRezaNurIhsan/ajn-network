<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])
    ->name('password.forgot');

Route::post('/forgot-password', [ForgotPasswordController::class, 'reset'])
    ->name('password.reset');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    // Dashboard - semua role bisa akses
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Laporan Keuangan - semua role bisa akses
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'cetakPDF'])->name('laporan.pdf');
    
    // ========== PEMBAYARAN (DIREKTUR & ADMIN BISA) ==========
    // Semua role bisa mengelola pembayaran (tambah, edit, hapus, lihat, cetak)
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('/pembayaran/cetak/{id}', [PembayaranController::class, 'cetakKwitansi'])->name('pembayaran.cetak');
    
    // ========== ROUTE KHUSUS ADMINISTRATOR ==========
    Route::middleware(['role:administrator'])->group(function () {
        
        // Manajemen Pelanggan (full)
        Route::resource('pelanggan', PelangganController::class);
        Route::get('/pelanggan/{id}/toggle', [PelangganController::class, 'toggleStatus'])->name('pelanggan.toggle');
        
        // Notifikasi Tagihan
        Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
        Route::post('/notifikasi/kirim', [NotifikasiController::class, 'kirim'])->name('notifikasi.kirim');
        
        // Log Aktivitas (full)
        Route::get('/log', [LogAktivitasController::class, 'index'])->name('log.index');
        Route::get('/log/add-dummy', [LogAktivitasController::class, 'addDummyLogs'])->name('log.addDummy');
        Route::get('/log/clear', [LogAktivitasController::class, 'clearLogs'])->name('log.clear');
    });
    
    // Routes untuk Language dan Theme - semua role bisa akses
    Route::get('/lang/{locale}', [SettingController::class, 'setLanguage'])->name('lang.switch');
    Route::get('/theme/{mode}', [SettingController::class, 'setTheme'])->name('theme.switch');
});