<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\PengaduanController as PublicPengaduanController;
use App\Http\Controllers\Admin\PengaduanVerificationController;
use App\Http\Controllers\Superadmin\UserController as SuperadminUserController;
use App\Http\Controllers\Superadmin\KategoriController as SuperadminKategoriController;

/*
|--------------------------------------------------------------------------
| Jalur Publik (Lapor & Lacak Tiket Mandiri Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicPengaduanController::class, 'index'])->name('landing');
Route::post('/lapor', [PublicPengaduanController::class, 'store'])->name('pengaduan.store.public');
Route::get('/tracking', [PublicPengaduanController::class, 'tracking'])->name('pengaduan.tracking');

/*
|--------------------------------------------------------------------------
| Jalur Masuk Khusus Petugas & Administrator
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Panel Kontrol Internal (Wajib Login Petugas)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('panel')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 1. Verifikasi, Penugasan & Pengerjaan Teknis (Admin & Superadmin)
    Route::middleware(['role:admin,superadmin'])->prefix('pengaduan')->name('admin.pengaduan.')->group(function () {
        Route::get('/', [PengaduanVerificationController::class, 'index'])->name('index');
        Route::get('/{pengaduan}', [PengaduanVerificationController::class, 'show'])->name('show');
        Route::patch('/{pengaduan}/status', [PengaduanVerificationController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{pengaduan}', [PengaduanVerificationController::class, 'destroy'])->name('destroy');
    });

    // 2. Administrasi Master (Superadmin Saja)
    Route::middleware(['role:superadmin'])->prefix('master')->name('superadmin.')->group(function () {
        Route::resource('users', SuperadminUserController::class);
        Route::resource('kategori', SuperadminKategoriController::class)->except(['show']);
    });
});