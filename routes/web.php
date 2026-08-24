<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

// Landing Page & Pendaftaran
Route::get('/', [MainController::class, 'landing'])->name('landing');
Route::post('/join/{id}', [MainController::class, 'joinEkskul'])->name('ekskul.join');

// Auth Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function() { return view('auth.login'); })->name('login');
    Route::post('/login', [MainController::class, 'login']);
    Route::get('/register', function() { return view('auth.register'); })->name('register');
    Route::post('/register', [MainController::class, 'register']);
});

// Auth Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    Route::get('/guru/dashboard', function () { return view('dashboard_guru'); });
    Route::get('/admin/dashboard', function () { return view('dashboard_admin'); });
    Route::post('/logout', [MainController::class, 'logout'])->name('logout');
});