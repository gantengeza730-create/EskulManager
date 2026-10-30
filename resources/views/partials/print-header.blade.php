{{-- Kop surat untuk cetak: logo, nama & alamat sekolah, judul laporan, periode --}}
<div class="print-only print-head">
    @if ($school->logo())<img src="{{ $school->logo() }}" alt="Logo">@endif
    <div><h2>{{ $school->name() }}</h2><p>{{ $school->address() }}</p></div>
</div>
<div class="print-only print-title"><h3>{{ $title }}</h3><p>{{ $subtitle ?? '' }} &middot; Dicetak {{ now()->translatedFormat('d F Y H:i') }}</p></div>
