<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><title>Sertifikat {{ $certificate->number }}</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
<style>
@page{size:A4 landscape;margin:0}body{margin:0;font-family:'Plus Jakarta Sans',sans-serif;background:#eee}
.sheet{width:1123px;height:794px;margin:20px auto;background:#fff;position:relative;padding:50px;box-sizing:border-box}
.frame{border:6px double #1D4ED8;height:100%;padding:44px;box-sizing:border-box;text-align:center;display:flex;flex-direction:column;justify-content:center}
h1{font-size:44px;letter-spacing:.12em;margin:0;color:#1D4ED8}.lbl{color:#6B7280;margin:18px 0 6px}.name{font-size:38px;font-weight:800;border-bottom:2px solid #10162B;display:inline-block;padding:0 30px 6px;margin:0 auto}
.title{font-size:20px;font-weight:600;margin:14px 0}.sign{display:flex;justify-content:space-around;margin-top:46px}.sign div{width:240px}.sign hr{border:0;border-top:1px solid #10162B;margin:56px 0 6px}
.no-print{text-align:center;margin:16px}@media print{body{background:#fff}.sheet{margin:0}.no-print{display:none}}
</style></head><body>
<div class="no-print"><button onclick="window.print()" style="padding:10px 20px;font-weight:700;cursor:pointer">🖨 Cetak / Simpan PDF</button></div>
<div class="sheet"><div class="frame">
    <h1>SERTIFIKAT</h1><div class="lbl">Diberikan kepada</div>
    <div><span class="name">{{ $certificate->user->name }}</span></div>
    <div class="lbl">Kelas {{ $certificate->user->kelas }} · atas partisipasi dan prestasinya dalam</div>
    <div class="title">{{ $certificate->title }}</div>
    <div>Ekstrakurikuler {{ $certificate->ekskul->name }} — SMKN 1 Binong</div>
    <div class="sign"><div><hr>Pembina Ekskul<br><b>{{ $certificate->ekskul->pembina?->name ?? '________' }}</b></div>
        <div><hr>Kepala Sekolah<br><b>________________</b></div></div>
    <div style="margin-top:22px;font-size:12px;color:#6B7280">No. {{ $certificate->number }} · Diterbitkan {{ $certificate->issued_at->translatedFormat('d F Y') }}</div>
</div></div></body></html>
