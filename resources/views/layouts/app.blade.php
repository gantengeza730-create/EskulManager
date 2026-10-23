<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — Ekskul SMK</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script>(function(){try{var t=localStorage.getItem('ekskul_theme');if(t)document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
</head>
<body class="dash">
<div class="app">
    @include('partials.sidebar')
    <div class="main">
        <header class="topbar">
            <button class="burger" onclick="document.getElementById('sidebar').classList.toggle('open')">☰</button>
            <div><h1>@yield('title', 'Dashboard')</h1><p>@yield('subtitle', now()->translatedFormat('l, d F Y'))</p></div>
            <div class="sp"></div>
            <button class="theme-toggle inline" onclick="toggleTheme()" title="Ganti tampilan" id="themeBtn">🌙</button>
            <a href="{{ route('notifikasi.index') }}" class="bell">🔔@if (($c = auth()->user()->unreadCount()) > 0)<i>{{ $c }}</i>@endif</a>
            <div class="ava">{{ auth()->user()->initials() }}</div>
        </header>
        <main class="content">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>
</div>
<script src="{{ asset('css/theme.js') }}"></script>
<script src="{{ asset('js/stars.js') }}"></script>
@stack('scripts')
</body>
</html>
