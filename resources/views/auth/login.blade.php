@extends('layouts.app')

@section('content')
<div class="split-container">
    <!-- Panel Kiri: Hero & Graphic -->
    <div class="panel-navy">
        <div class="brand-logo">
            <div class="brand-icon">🎓</div>
            <span>EkskulSMK</span>
        </div>
        
        <div class="hero-content">
            <h1 class="hero-title">Gali Potensi, Tunjukkan Prestasi Terbaikmu!</h1>
            <p class="hero-desc">Portal manajemen ekstrakurikuler terintegrasi untuk siswa SMK. Kelola pendaftaran, pantau presensi latihan, dan raih sertifikat digital dengan mudah.</p>
            
            <div class="widget-card">
                <div class="profile-row">
                    <div class="user-info">
                        <div class="avatar"></div>
                        <div>
                            <strong style="font-size: 14px; display: block;">Muhe Alya</strong>
                            <span style="font-size: 11px; color: #94a3b8;">XII RPL 1</span>
                        </div>
                    </div>
                    <span class="badge-active">Aktif</span>
                </div>
                <div class="progress-item">
                    <div class="progress-label"><span>Futsal</span><span>95%</span></div>
                    <div class="progress-bar"><div class="progress-fill" style="width: 95%;"></div></div>
                </div>
                <div class="progress-item">
                    <div class="progress-label"><span>Coding</span><span>100%</span></div>
                    <div class="progress-bar"><div class="progress-fill" style="width: 100%;"></div></div>
                </div>
            </div>
        </div>
        
        <div style="font-size: 12px; color: #64748b;">&copy; 2026 EkskulSMK</div>
    </div>

    <!-- Panel Kanan: Form Login -->
    <div class="panel-white">
        <div class="form-box">
            <h2 class="form-title">Masuk ke Akun Anda</h2>
            <p class="form-subtitle">Selamat datang kembali! Silakan masukkan kredensial Anda.</p>

            <form action="/login" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email Sekolah</label>
                    <input type="email" name="email" required class="form-input" placeholder="muhealyaa@gmail.com">
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" required class="form-input" placeholder="rahasia123">
                </div>

                <div class="form-flex">
                    <label><input type="checkbox" name="remember" checked> Ingat Saya</label>
                    <a href="#" style="color: #2563eb; text-decoration: none; font-weight: 600;">Lupa Password?</a>
                </div>

                <button type="submit" class="btn-blue">Masuk</button>
            </form>

            <div class="divider"><span>atau masuk dengan</span></div>

            <div class="sso-grid">
                <button class="sso-btn">❌ Google</button>
                <button class="sso-btn">❌ Microsoft</button>
            </div>

            <p class="footer-text">
                Belum punya akun? <a href="/register">Daftar Sekarang</a>
            </p>
        </div>
    </div>
</div>
@endsection