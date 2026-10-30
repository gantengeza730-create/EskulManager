<button type="button" class="logout-btn" onclick="openLogout()" title="Keluar" aria-label="Keluar dari akun"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4H6a2 2 0 00-2 2v12a2 2 0 002 2h3"/><path d="M16 16l4-4-4-4"/><path d="M20 12H9"/></svg></button>
<form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display:none">@csrf</form>
<div class="lg-overlay" id="logoutModal" role="dialog" aria-modal="true" aria-labelledby="lgTitle">
    <div class="lg-card">
        <div class="lg-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4H6a2 2 0 00-2 2v12a2 2 0 002 2h3"/><path d="M16 16l4-4-4-4"/><path d="M20 12H9"/></svg></div>
        <h3 id="lgTitle">Keluar dari akun?</h3>
        <p>Sesi Anda akan diakhiri dan Anda kembali ke halaman utama.</p>
        <div class="lg-user"><span class="ava">{{ auth()->user()->initials() }}</span><span>{{ auth()->user()->name }}</span></div>
        <div class="lg-actions"><button type="button" class="btn btn-o lg-cancel" onclick="closeLogout()">Batal</button><button type="button" class="btn lg-confirm">Ya, Keluar</button></div>
    </div>
</div>
<script>
(function(){var m=document.getElementById('logoutModal');if(!m)return;document.body.appendChild(m);var f=document.getElementById('logoutForm');
window.openLogout=function(){m.classList.add('show');setTimeout(function(){m.querySelector('.lg-cancel').focus()},50)};window.closeLogout=function(){m.classList.remove('show')};
m.addEventListener('click',function(e){if(e.target===m)closeLogout()});document.addEventListener('keydown',function(e){if(e.key==='Escape')closeLogout()});
m.querySelector('.lg-confirm').addEventListener('click',function(){this.disabled=true;this.textContent='Keluar…';f.submit()});})();
</script>
