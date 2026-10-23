<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Masuk — Ekskul SMK</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}"></head>
<body>
<script>(function(){try{var t=localStorage.getItem('ekskul_theme');if(t)document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
<button class="theme-toggle" onclick="toggleTheme()" title="Ganti tampilan" id="themeBtn">🌙</button>
<div class="auth"><div class="box">
    <h2>Masuk ke Akun</h2><p class="sub">Pilih peranmu untuk melanjutkan</p>
    @include('partials.flash')
    <form method="POST" action="{{ route('login.post') }}">@csrf
        <input type="hidden" name="as" id="asRole" value="{{ old('as', 'siswa') }}">
        <div class="tabs3" id="tabs">
            <button type="button" data-role="siswa">Siswa</button>
            <button type="button" data-role="pembina">Pembina</button>
            <button type="button" data-role="admin">Admin</button>
        </div>
        <div class="f"><label>Email atau NIS</label><input type="text" name="email" value="{{ old('email') }}" required autofocus></div>
        <div class="f"><label>Kata Sandi</label><input type="password" name="password" required></div>
        <label class="small muted" style="display:flex;gap:8px;margin-bottom:14px"><input type="checkbox" name="remember" style="width:auto"> Ingat saya</label>
        <button class="btn btn-p btn-b">Masuk</button>
    </form>
    <p class="foot-link" id="regLink">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
    <p class="foot-link"><a href="{{ route('home') }}">← Kembali ke Beranda</a></p>
</div></div>
<script src="{{ asset('css/theme.js') }}"></script>
<script>
// Tab peran murni pilihan pengguna — tidak lagi dikunci berdasarkan perangkat,
// jadi siswa bisa masuk dari laptop dan pembina/admin bisa masuk dari HP.
const tabs=[...document.querySelectorAll('#tabs button')], input=document.getElementById('asRole');
function apply(){
  tabs.forEach(t=>t.classList.toggle('on', t.dataset.role===input.value));
  document.getElementById('regLink').style.display = input.value==='siswa' ? 'block' : 'none';
}
tabs.forEach(t=>t.addEventListener('click', ()=>{ input.value=t.dataset.role; apply(); }));
apply();
</script></body></html>
