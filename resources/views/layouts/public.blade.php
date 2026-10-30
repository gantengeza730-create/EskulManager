<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal Ekstrakurikuler') — {{ $school->name() }}</title>
    @include('partials.head')
</head>
<body>
<nav class="pnav">
    <a href="{{ route('home') }}" class="brandl">@include('partials.brand') <span>Ekskul <b>SMK</b></span></a>
    <div class="links"><a href="{{ route('home') }}#ekskul">Ekstrakurikuler</a><a href="{{ route('home') }}#cara">Cara Bergabung</a><a href="{{ route('home') }}#berita">Berita</a></div>
    <div class="act">
        <button class="theme-toggle inline" onclick="toggleTheme()" title="Ganti tampilan">🌙</button>
        @auth<a class="btn btn-p btn-s" href="{{ route('dashboard') }}">Buka Dashboard</a>
        @else<a class="btn btn-o btn-s" href="{{ route('login') }}">Masuk</a><a class="btn btn-p btn-s" href="{{ route('register') }}">Daftar Akun</a>@endauth
    </div>
</nav>
@include('partials.toast')
@yield('content')
<footer class="pfoot"><b>{{ $school->name() }}</b><br>{{ $school->address() }}<br>Kepala Sekolah: {{ $school->principal() }}</footer>
<script src="{{ asset('css/theme.js') }}"></script>
<script src="{{ asset('js/stars.js') }}"></script>
</body>
</html>
