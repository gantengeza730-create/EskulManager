@php
    $name = session('bye_name');
    $first = $name ? explode(' ', trim($name))[0] : null;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sampai Jumpa — Ekskul SMK</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0}html,body{height:100%}
body{font-family:'Plus Jakarta Sans',system-ui,sans-serif;color:#EEF1FF;background:radial-gradient(ellipse 90% 70% at 50% -10%,#1a2456 0%,#0c1130 45%,#05060f 100%);overflow:hidden;position:relative}
#sky{position:absolute;inset:0;pointer-events:none}.star{position:absolute;border-radius:50%;background:#fff;animation:tw linear infinite}
@keyframes tw{0%,100%{opacity:.15;transform:scale(.8)}50%{opacity:1;transform:scale(1.15)}}
.neb{position:absolute;border-radius:50%;filter:blur(70px);opacity:.55;pointer-events:none;animation:dr 22s ease-in-out infinite alternate}
.n1{width:380px;height:380px;left:-90px;top:-60px;background:radial-gradient(circle,#4338CA,transparent 70%)}.n2{width:420px;height:420px;right:-110px;bottom:-80px;background:radial-gradient(circle,#7C3AED,transparent 70%);animation-delay:4s}
@keyframes dr{from{transform:translate(0,0) scale(1)}to{transform:translate(34px,-26px) scale(1.12)}}
.orbits{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none}
.orb{position:absolute;border:1px dashed rgba(255,255,255,.13);border-radius:50%}.o1{width:460px;height:460px;animation:sp 36s linear infinite}.o2{width:680px;height:680px;animation:sp 58s linear infinite reverse}.o3{width:900px;height:900px;animation:sp 86s linear infinite}
.orb i{position:absolute;border-radius:50%;box-shadow:0 0 22px 4px currentColor}
.o1 i{top:-7px;left:50%;width:14px;height:14px;margin-left:-7px;background:radial-gradient(circle at 35% 30%,#FDE68A,#D97706);color:rgba(217,119,6,.55)}
.o2 i{top:50%;right:-6px;width:11px;height:11px;margin-top:-5px;background:radial-gradient(circle at 35% 30%,#93C5FD,#2563EB);color:rgba(37,99,235,.55)}
.o3 i{bottom:-5px;left:22%;width:9px;height:9px;background:radial-gradient(circle at 35% 30%,#FCA5A5,#DC2626);color:rgba(220,38,38,.5)}
@keyframes sp{to{transform:rotate(360deg)}}
.wrap{position:relative;z-index:2;min-height:100%;display:flex;align-items:center;justify-content:center;padding:24px}
.card{width:min(92vw,480px);text-align:center;padding:44px 34px 30px;border-radius:26px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);-webkit-backdrop-filter:blur(14px);backdrop-filter:blur(14px);box-shadow:0 30px 80px -24px rgba(0,0,0,.7);animation:rise .7s cubic-bezier(.2,.9,.3,1.1)}
@keyframes rise{from{opacity:0;transform:translateY(24px) scale(.96)}to{opacity:1;transform:none}}
.hand{font-size:64px;line-height:1;display:inline-block;transform-origin:70% 70%;animation:wave 2.2s ease-in-out .5s infinite}
@keyframes wave{0%,60%,100%{transform:rotate(0)}10%{transform:rotate(16deg)}20%{transform:rotate(-10deg)}30%{transform:rotate(16deg)}40%{transform:rotate(-6deg)}50%{transform:rotate(10deg)}}
h1{font-size:28px;font-weight:800;letter-spacing:-.02em;margin:18px 0 10px;background:linear-gradient(100deg,#fff,#C7D2FE 60%,#C4B5FD);-webkit-background-clip:text;background-clip:text;color:transparent}
p.sub{font-size:14.5px;line-height:1.7;color:rgba(226,232,255,.78);margin-bottom:26px}
.btns{display:flex;gap:10px;margin-bottom:26px}.btns a{flex:1;padding:13px 14px;border-radius:12px;font-size:14px;font-weight:700;text-decoration:none;text-align:center}
.b1{background:#2563EB;color:#fff}.b2{background:rgba(255,255,255,.08);color:#fff;border:1px solid rgba(255,255,255,.22)}
.bar{height:5px;border-radius:5px;background:rgba(255,255,255,.12);overflow:hidden;margin-bottom:10px}.bar span{display:block;height:100%;width:0;border-radius:5px;background:linear-gradient(90deg,#60A5FA,#A78BFA);animation:fill 6s linear forwards}
@keyframes fill{to{width:100%}}.count{font-size:12.5px;color:rgba(226,232,255,.62)}.count a{color:#93C5FD;font-weight:700;text-decoration:none}
@media (prefers-reduced-motion:reduce){.star,.neb,.orb,.hand,.card{animation:none!important}}
</style></head>
<body>
<div id="sky"></div><div class="neb n1"></div><div class="neb n2"></div>
<div class="orbits"><div class="orb o1"><i></i></div><div class="orb o2"><i></i></div><div class="orb o3"><i></i></div></div>
<main class="wrap"><div class="card">
    <div class="hand">👋</div>
    <h1>Sampai jumpa{{ $first ? ', '.$first : '' }}!</h1>
    <p class="sub">Anda telah keluar dengan aman.<br>Terima kasih sudah menggunakan portal Ekskul SMK.</p>
    <div class="btns"><a class="b1" href="{{ route('home') }}">Kembali ke Beranda</a><a class="b2" href="{{ route('login') }}">Masuk Lagi</a></div>
    <div class="count" id="count"><div class="bar"><span></span></div>Kembali ke beranda dalam <b id="cd">6</b> detik · <a href="#" id="stop">batalkan</a></div>
</div></main>
<script>
(function(){var h='';for(var i=0;i<(innerWidth<640?60:110);i++){var s=(Math.random()*2+1).toFixed(1);h+='<span class="star" style="width:'+s+'px;height:'+s+'px;top:'+(Math.random()*100).toFixed(2)+'%;left:'+(Math.random()*100).toFixed(2)+'%;animation-duration:'+(Math.random()*3+2).toFixed(2)+'s;animation-delay:'+(Math.random()*5).toFixed(2)+'s"></span>';}
document.getElementById('sky').innerHTML=h;var HOME=@json(route('home')),secs=6,cd=document.getElementById('cd');
var t=setInterval(function(){secs--;cd.textContent=Math.max(secs,0);if(secs<=0){clearInterval(t);location.href=HOME;}},1000);
document.getElementById('stop').addEventListener('click',function(e){e.preventDefault();clearInterval(t);document.getElementById('count').innerHTML='Pengalihan otomatis dibatalkan.';});})();
</script></body></html>
