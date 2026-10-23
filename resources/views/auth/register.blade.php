<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Daftar — Ekskul SMK</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}"></head>
<body>
<script>(function(){try{var t=localStorage.getItem('ekskul_theme');if(t)document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
<button class="theme-toggle" onclick="toggleTheme()" title="Ganti tampilan" id="themeBtn">🌙</button><div class="auth"><div class="box" style="max-width:460px">
    <h2>Daftar Akun Siswa</h2><p class="sub">Lengkapi data diri untuk membuat akun baru</p>
    @include('partials.flash')
    <form method="POST" action="{{ route('register.post') }}">@csrf
        <div class="frow"><div class="f"><label>Nama Lengkap</label><input name="name" value="{{ old('name') }}" required></div>
            <div class="f"><label>NIS</label><input name="nis" value="{{ old('nis') }}" required></div></div>
        <div class="frow"><div class="f"><label>Kelas</label><input name="kelas" value="{{ old('kelas') }}" placeholder="XI RPL 1" required></div>
            <div class="f"><label>No. HP</label><input name="phone" value="{{ old('phone') }}"></div></div>
        <div class="f"><label>Email Aktif</label><input type="email" name="email" value="{{ old('email') }}" required></div>
        <div class="frow"><div class="f"><label>Kata Sandi</label><input type="password" name="password" required></div>
            <div class="f"><label>Ulangi Kata Sandi</label><input type="password" name="password_confirmation" required></div></div>
        <button class="btn btn-p btn-b">Daftar Akun</button>
    </form>
    <p class="foot-link">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
</div></div><script src="{{ asset('css/theme.js') }}"></script>
</body></html>
