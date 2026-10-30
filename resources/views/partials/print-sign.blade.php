{{-- Tanda tangan di akhir cetakan: pembina/admin dan kepala sekolah --}}
<div class="print-only print-sign">
    <div>{{ $leftTitle ?? 'Pembina Ekskul' }}<div class="sp"></div><b>{{ $leftName ?? '________________' }}</b></div>
    <div>Mengetahui,<br>Kepala Sekolah<div class="sp"></div><b>{{ $school->principal() }}</b><br>NIP. {{ $school->principalNip() }}</div>
</div>
