<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Verifikasi — Ekskul SMK</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}"></head>
<body>
<script>(function(){try{var t=localStorage.getItem('ekskul_theme');if(t)document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
<button class="theme-toggle" onclick="toggleTheme()" title="Ganti tampilan" id="themeBtn">🌙</button><div class="auth"><div class="box">
    <h2>Verifikasi Email</h2><p class="sub">Masukkan 6 digit kode yang dikirim ke email Anda</p>
    @include('partials.flash')
    @if ($devCode)<div class="note">Mode pengembangan — kode Anda: <b>{{ $devCode }}</b> (juga tercatat di storage/logs/laravel.log)</div>@endif
    <form method="POST" action="{{ route('verify.post') }}">@csrf
        <div class="f"><label>Email</label><input type="email" name="email" value="{{ $email }}" required></div>
        <div class="f"><label>Kode Verifikasi</label><input name="code" maxlength="6" inputmode="numeric" style="letter-spacing:.4em;text-align:center;font-size:20px;font-weight:800" required></div>
        <button class="btn btn-p btn-b">Verifikasi Akun</button>
    </form>
    <form method="POST" action="{{ route('verify.resend') }}" class="foot-link">@csrf
        <input type="hidden" name="email" value="{{ $email }}">Tidak menerima kode? <button style="background:none;border:0;color:var(--accent);font-weight:700;cursor:pointer">Kirim ulang</button>
    </form>
</div></div><script src="{{ asset('css/theme.js') }}"></script>
</body></html>
