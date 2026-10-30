<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Pembina;
use App\Http\Controllers\SharedController;
use App\Http\Controllers\Siswa;
use Illuminate\Support\Facades\Route;

/* ---------- Publik ---------- */
Route::get('/', [LandingController::class, 'home'])->name('home');
Route::get('/ekskul/{ekskul}', [LandingController::class, 'show'])->name('ekskul.show');
Route::get('/sampai-jumpa', fn () => view('auth.logout-selesai'))->name('logout.selesai');

/* ---------- Autentikasi ---------- */
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk', [AuthController::class, 'login'])->name('login.post');
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register'])->name('register.post');
    Route::get('/verifikasi', [AuthController::class, 'showVerify'])->name('verify');
    Route::post('/verifikasi', [AuthController::class, 'verify'])->name('verify.post');
    Route::post('/verifikasi/kirim-ulang', [AuthController::class, 'resend'])->name('verify.resend');
});
Route::post('/keluar', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/* ---------- Area login (semua peran) ---------- */
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [SharedController::class, 'dashboardRedirect'])->name('dashboard');
    Route::get('/notifikasi', [SharedController::class, 'notifications'])->name('notifikasi.index');
    Route::get('/notifikasi/baca-semua', [SharedController::class, 'readAll'])->name('notifikasi.readall');
    Route::get('/notifikasi/{id}', [SharedController::class, 'readOne'])->name('notifikasi.read');
    Route::get('/profil', [SharedController::class, 'profile'])->name('profil.edit');
    Route::put('/profil', [SharedController::class, 'updateProfile'])->name('profil.update');
    Route::get('/jadwal', [SharedController::class, 'schedules'])->name('jadwal.index');
    Route::get('/kalender', [SharedController::class, 'calendar'])->name('kalender.index');
    Route::get('/pengumuman', [SharedController::class, 'announcements'])->name('pengumuman.index');
    Route::get('/galeri', [SharedController::class, 'gallery'])->name('galeri.index');
    Route::get('/sertifikat/{certificate}/cetak', [SharedController::class, 'printCertificate'])->name('sertifikat.cetak');

    Route::middleware('role:admin,pembina')->group(function () {
        Route::post('/pengumuman', [SharedController::class, 'storeAnnouncement'])->name('pengumuman.store');
        Route::delete('/pengumuman/{announcement}', [SharedController::class, 'destroyAnnouncement'])->name('pengumuman.destroy');
        Route::post('/galeri', [SharedController::class, 'storeGallery'])->name('galeri.store');
        Route::delete('/galeri/{gallery}', [SharedController::class, 'destroyGallery'])->name('galeri.destroy');
    });
});

/* ---------- Siswa ---------- */
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/', [Siswa\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/ekskul', [Siswa\EkskulController::class, 'index'])->name('ekskul.index');
    Route::get('/ekskul/{ekskul}/daftar', [Siswa\EkskulController::class, 'form'])->name('ekskul.form');
    Route::post('/ekskul/{ekskul}/daftar', [Siswa\EkskulController::class, 'register'])->name('ekskul.daftar');
    Route::get('/presensi', [Siswa\RecordController::class, 'attendance'])->name('presensi');
    Route::get('/nilai', [Siswa\RecordController::class, 'assessments'])->name('nilai');
    Route::get('/sertifikat', [Siswa\RecordController::class, 'certificates'])->name('sertifikat');
});

/* ---------- Pembina ---------- */
Route::middleware(['auth', 'role:pembina'])->prefix('pembina')->name('pembina.')->group(function () {
    Route::get('/', [Pembina\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pendaftar', [Pembina\RegistrationController::class, 'index'])->name('pendaftar.index');
    Route::patch('/pendaftar/{registration}', [Pembina\RegistrationController::class, 'update'])->name('pendaftar.update');
    Route::get('/presensi', [Pembina\AttendanceController::class, 'index'])->name('presensi.index');
    Route::get('/presensi/{schedule}', [Pembina\AttendanceController::class, 'edit'])->name('presensi.edit');
    Route::put('/presensi/{schedule}', [Pembina\AttendanceController::class, 'update'])->name('presensi.update');
    Route::get('/penilaian/{ekskul?}', [Pembina\AssessmentController::class, 'index'])->name('penilaian.index');
    Route::put('/penilaian/{ekskul}', [Pembina\AssessmentController::class, 'update'])->name('penilaian.update');
    Route::get('/laporan', [Pembina\ReportController::class, 'index'])->name('laporan');
});

/* ---------- Admin ---------- */
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('ekskul', Admin\EkskulController::class)->except('show');
    Route::resource('pengguna', Admin\UserController::class)->parameters(['pengguna' => 'user'])->except('show');
    Route::resource('ruangan', Admin\RoomController::class)->parameters(['ruangan' => 'room'])->except(['show', 'create']);
    Route::resource('jadwal', Admin\ScheduleController::class)->parameters(['jadwal' => 'schedule'])->except('show');
    Route::get('/laporan', [Admin\ReportController::class, 'index'])->name('laporan');
    Route::get('/laporan/ekspor', [Admin\ReportController::class, 'export'])->name('laporan.ekspor');
    Route::get('/sertifikat', [Admin\CertificateController::class, 'index'])->name('sertifikat.index');
    Route::post('/sertifikat', [Admin\CertificateController::class, 'store'])->name('sertifikat.store');
    Route::delete('/sertifikat/{certificate}', [Admin\CertificateController::class, 'destroy'])->name('sertifikat.destroy');
    Route::get('/sekolah', [Admin\SchoolController::class, 'edit'])->name('sekolah.edit');
    Route::put('/sekolah', [Admin\SchoolController::class, 'update'])->name('sekolah.update');
});
