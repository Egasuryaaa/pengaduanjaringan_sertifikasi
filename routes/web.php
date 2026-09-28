<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\PengaduanController as UserPengaduanController;
use App\Http\Controllers\Admin\PengaduanVerificationController;
use App\Http\Controllers\Superadmin\UserController as SuperadminUserController;
use App\Http\Controllers\Superadmin\KategoriController as SuperadminKategoriController;

/*
|--------------------------------------------------------------------------
| Jalur Publik (Landing, Form Aduan, Tracking Tiket ID Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/', [UserPengaduanController::class, 'index'])->name('landing');
Route::post('/lapor', [UserPengaduanController::class, 'store'])->name('pengaduan.store.public');
Route::get('/tracking', [UserPengaduanController::class, 'tracking'])->name('pengaduan.tracking');

/*
|--------------------------------------------------------------------------
| Jalur Autentikasi Pengguna & Petugas (Login & Logout)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Jalur Panel Internal (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('panel')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 1. Modul Riwayat Mandiri (User OPD / Petugas)
    Route::middleware(['role:user,admin,superadmin'])->prefix('saya')->name('user.')->group(function () {
        Route::get('/pengaduan', [UserPengaduanController::class, 'riwayat'])->name('pengaduan.riwayat');
        Route::delete('/pengaduan/{pengaduan}', [UserPengaduanController::class, 'destroy'])->name('pengaduan.destroy');
    });

    // 2. Modul Admin & Superadmin (Verifikasi Tiket, ACC, Update Status, Upload Foto Tindak Lanjut)
    Route::middleware(['role:admin,superadmin'])->prefix('pengaduan')->name('admin.pengaduan.')->group(function () {
        Route::get('/', [PengaduanVerificationController::class, 'index'])->name('index');
        Route::get('/{pengaduan}', [PengaduanVerificationController::class, 'show'])->name('show');
        Route::patch('/{pengaduan}/status', [PengaduanVerificationController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{pengaduan}', [PengaduanVerificationController::class, 'destroy'])->name('destroy');
    });

    // 3. Modul Khusus Superadmin (Data Master Kategori & User)
    Route::middleware(['role:superadmin'])->prefix('master')->name('superadmin.')->group(function () {
        Route::resource('users', SuperadminUserController::class);
        Route::resource('kategori', SuperadminKategoriController::class)->except(['show']);
    });
});