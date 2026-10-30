<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><title>Sertifikat {{ $certificate->number }}</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
<style>
@page{size:A4 landscape;margin:0}*{box-sizing:border-box}body{margin:0;font-family:'Plus Jakarta Sans',sans-serif;background:#e8e8e8;-webkit-print-color-adjust:exact;print-color-adjust:exact}
.sheet{width:297mm;height:210mm;margin:12px auto;background:#fff;padding:10mm;position:relative}
.frame{border:2mm double #1D4ED8;height:100%;padding:10mm 16mm;text-align:center;display:flex;flex-direction:column;justify-content:space-between;color:#10162B}
.top img{height:20mm}.top h2{margin:2mm 0 0;font-size:16pt}.top p{margin:1mm 0 0;font-size:9.5pt;color:#555}
h1{font-size:34pt;letter-spacing:.14em;margin:0;color:#1D4ED8}.lbl{color:#555;font-size:11pt;margin:3mm 0 1mm}
.name{font-size:26pt;font-weight:800;border-bottom:.5mm solid #10162B;display:inline-block;padding:0 12mm 1mm}.title{font-size:15pt;font-weight:600;margin:2mm 0}
.sign{display:flex;justify-content:space-around}.sign div{width:70mm;font-size:10.5pt}.sign .sp{height:16mm}.foot{font-size:8.5pt;color:#666}
.no-print{text-align:center;margin:12px}@media print{body{background:#fff}.sheet{margin:0}.no-print{display:none}}
</style></head><body>
<div class="no-print"><button onclick="window.print()" style="padding:10px 22px;font-weight:700;cursor:pointer">🖨 Cetak / Simpan PDF</button> <span style="font-size:12px;color:#555">Pilih "Simpan sebagai PDF", ukuran A4 landscape.</span></div>
<div class="sheet"><div class="frame">
    <div class="top">@if ($school->logo())<img src="{{ $school->logo() }}" alt="Logo">@endif<h2>{{ $school->name() }}</h2><p>{{ $school->address() }}</p></div>
    <div><h1>SERTIFIKAT</h1><div class="lbl">Diberikan kepada</div><div><span class="name">{{ $certificate->user->name }}</span></div>
        <div class="lbl">Kelas {{ $certificate->user->kelas }} · atas partisipasi dan prestasinya dalam</div><div class="title">{{ $certificate->title }}</div><div>Ekstrakurikuler {{ $certificate->ekskul->name }}</div></div>
    <div class="sign"><div>Pembina Ekskul<div class="sp"></div><b>{{ $certificate->ekskul->pembina?->name ?? '________________' }}</b></div>
        <div>Kepala Sekolah<div class="sp"></div><b>{{ $school->principal() }}</b><br>NIP. {{ $school->principalNip() }}</div></div>
    <div class="foot">No. {{ $certificate->number }} · Diterbitkan {{ $certificate->issued_at->translatedFormat('d F Y') }}</div>
</div></div></body></html>
