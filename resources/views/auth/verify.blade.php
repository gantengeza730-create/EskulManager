<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Verifikasi — Ekskul SMK</title>@include('partials.head')</head>
<body>
<button class="theme-toggle" onclick="toggleTheme()" title="Ganti tampilan">🌙</button>
<div class="auth"><div class="box">
    <h2>Verifikasi Email</h2><p class="sub">Masukkan 6 digit kode yang dikirim ke email Anda</p>
    @include('partials.flash')
    @if (session('status'))<div class="flash ok">{{ session('status') }}</div>@endif
    @if ($devCode)<div class="note">Mode pengembangan — kode Anda: <b>{{ $devCode }}</b> (juga tercatat di storage/logs/laravel.log)</div>@endif
    <form method="POST" action="{{ route('verify.post') }}">@csrf
        <div class="f"><label class="req">Email</label><input type="email" name="email" value="{{ $email }}" required></div>
        <div class="f"><label class="req">Kode Verifikasi</label><input name="code" maxlength="6" inputmode="numeric" style="letter-spacing:.4em;text-align:center;font-size:20px;font-weight:800" required></div>
        <button class="btn btn-p btn-b">Verifikasi Akun</button>
    </form>
    <form method="POST" action="{{ route('verify.resend') }}" class="foot-link">@csrf<input type="hidden" name="email" value="{{ $email }}">Tidak menerima kode? <button style="background:none;border:0;color:var(--accent);font-weight:700;cursor:pointer">Kirim ulang</button></form>
</div></div>
<script src="{{ asset('css/theme.js') }}"></script></body></html>
