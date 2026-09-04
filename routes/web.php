<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

// Landing Page & Pendaftaran
Route::get('/', [MainController::class, 'landing'])->name('landing');
Route::post('/join/{id}', [MainController::class, 'joinEkskul'])->name('ekskul.join');
Route::post('/cancel/{id}', [MainController::class, 'cancelEkskul'])->name('ekskul.cancel');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Auth Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function() { return view('auth.login'); })->name('login');
    Route::post('/login', [MainController::class, 'login']);
    Route::get('/register', function() { return view('auth.register'); })->name('register');
    // Route::post('/register', [MainController::class, 'register']);
});

// Auth Protected Routes
// Auth Protected Routes
Route::middleware('auth')->group(function () {
    
    // Siswa
    Route::middleware('role:siswa')->group(function () {
        Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard.siswa');
        Route::post('/dashboard/attendance/{registration}', [MainController::class, 'markAttendance'])->name('attendance.mark');
    });

    // Guru
    Route::middleware('role:guru')->group(function () {
        Route::get('/guru/dashboard', [MainController::class, 'dashboardGuru'])->name('dashboard.guru');
    });

    // Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [MainController::class, 'dashboardAdmin'])->name('dashboard.admin');
    });

    // --- BISA DIAKSES SEMUA ROLE (Asal sudah login) ---
    Route::post('/logout', [MainController::class, 'logout'])->name('logout');
    Route::post('/profile/update', [MainController::class, 'updateProfile'])->name('profile.update');
});