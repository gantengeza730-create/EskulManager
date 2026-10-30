<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Daftar — Ekskul SMK</title>@include('partials.head')</head>
<body>
<button class="theme-toggle" onclick="toggleTheme()" title="Ganti tampilan">🌙</button>
<div class="auth"><div class="box" style="max-width:460px">
    <div class="logo">@include('partials.brand')</div>
    <h2>Daftar Akun Siswa</h2><p class="sub">Semua kolom wajib diisi</p>
    @include('partials.flash')
    <form method="POST" action="{{ route('register.post') }}">@csrf
        <div class="frow"><div class="f"><label class="req">Nama Lengkap</label><input name="name" value="{{ old('name') }}" required></div><div class="f"><label class="req">NIS</label><input name="nis" value="{{ old('nis') }}" required></div></div>
        <div class="frow"><div class="f"><label class="req">Kelas</label><input name="kelas" value="{{ old('kelas') }}" placeholder="XI RPL 1" required></div><div class="f"><label class="req">No. HP</label><input name="phone" value="{{ old('phone') }}" required></div></div>
        <div class="f"><label class="req">Email Aktif</label><input type="email" name="email" value="{{ old('email') }}" required></div>
        <div class="frow"><div class="f"><label class="req">Kata Sandi</label><input type="password" name="password" minlength="8" required></div><div class="f"><label class="req">Ulangi Kata Sandi</label><input type="password" name="password_confirmation" required></div></div>
        <button class="btn btn-p btn-b">Daftar Akun</button>
    </form>
    <p class="foot-link">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
</div></div>
<script src="{{ asset('css/theme.js') }}"></script></body></html>
