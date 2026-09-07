<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

// Landing Page & Pendaftaran
Route::get('/', [MainController::class, 'landing'])->name('landing');
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
    
    Route::post('/join/{id}', [MainController::class, 'joinEkskul'])->name('ekskul.join');
    Route::post('/cancel/{id}', [MainController::class, 'cancelEkskul'])->name('ekskul.cancel');

    // Siswa
    Route::middleware('role:siswa')->group(function () {
        Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard.siswa');
        Route::post('/dashboard/attendance/{registration}', [MainController::class, 'markAttendance'])->name('attendance.mark');
    });

    // Guru
    Route::middleware('role:guru')->group(function () {
        Route::get('/guru/dashboard', [MainController::class, 'dashboardGuru'])->name('dashboard.guru');
        Route::post('/guru/ekskul/store', [MainController::class, 'storeEkskul'])->name('ekskul.store');
        Route::put('/guru/ekskul/{id}', [MainController::class, 'updateEkskul'])->name('ekskul.update');
        Route::delete('/guru/ekskul/{id}', [MainController::class, 'deleteEkskul'])->name('ekskul.delete');
        Route::post('/guru/registration/{registration}/accept', [MainController::class, 'acceptRegistration'])->name('registration.accept');
        Route::post('/guru/registration/{registration}/reject', [MainController::class, 'rejectRegistration'])->name('registration.reject');
        Route::post('/guru/evaluation/{registration}', [MainController::class, 'storeEvaluation'])->name('evaluation.store');
    });

    // Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [MainController::class, 'dashboardAdmin'])->name('dashboard.admin');
    });

    // --- BISA DIAKSES SEMUA ROLE (Asal sudah login) ---
    Route::get('/profile/update', function () {
        $user = Auth::user();

        if ($user && $user->role === 'guru') {
            return redirect('/guru/dashboard#tab-profile');
        }

        if ($user && $user->role === 'siswa') {
            return redirect('/dashboard#tab-profile');
        }

        return redirect('/')->with('success', 'Silakan gunakan formulir profil untuk menyimpan perubahan.');
    });
    Route::post('/logout', [MainController::class, 'logout'])->name('logout');
    Route::post('/profile/update', [MainController::class, 'updateProfile'])->name('profile.update');
});