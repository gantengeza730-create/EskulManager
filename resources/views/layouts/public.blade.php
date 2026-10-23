<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal Ekstrakurikuler') — SMKN 1 Binong</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script>(function(){try{var t=localStorage.getItem('ekskul_theme');if(t)document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
</head>
<body>
<nav class="pnav">
    <a href="{{ route('home') }}">⚽ Ekskul <b>SMK</b></a>
    <div class="links"><a href="{{ route('home') }}#ekskul">Ekstrakurikuler</a><a href="{{ route('home') }}#cara">Cara Bergabung</a><a href="{{ route('home') }}#berita">Berita</a></div>
    <div class="act">
        <button class="theme-toggle inline" style="margin-right:4px" onclick="toggleTheme()" title="Ganti tampilan" id="themeBtn">🌙</button>
        @auth
            <a class="btn btn-p btn-s" href="{{ route('dashboard') }}">Buka Dashboard</a>
        @else
            <a class="btn btn-o btn-s" href="{{ route('login') }}">Masuk</a>
            <a class="btn btn-p btn-s" href="{{ route('register') }}">Daftar Akun</a>
        @endauth
    </div>
</nav>
@if (session('success'))<div class="flash ok" style="max-width:900px;margin:16px auto 0">{{ session('success') }}</div>@endif
@yield('content')
<footer class="pfoot">⚽ Ekskul SMK &middot; SMKN 1 Binong &middot; Sistem Informasi Ekstrakurikuler</footer>
<script src="{{ asset('css/theme.js') }}"></script>
<script src="{{ asset('js/stars.js') }}"></script>
</body>
</html>
