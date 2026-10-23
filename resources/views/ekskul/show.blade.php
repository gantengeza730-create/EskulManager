@extends(auth()->check() ? 'layouts.app' : 'layouts.public')
@section('title', $ekskul->name)
@section('subtitle', 'Info, syarat, dan anggota ekstrakurikuler')
@section('content')
@php $wrap = auth()->check() ? '' : 'sec'; @endphp
<div class="{{ $wrap }}">
<div class="hero-mini" style="background:linear-gradient(120deg,{{ $ekskul->color }},#1D4ED8)">
    <h3>{{ $ekskul->name }}</h3><p>{{ $ekskul->category }} · Pembina: {{ $ekskul->pembina?->name ?? 'belum ditentukan' }}</p>
</div>
<div class="grid g21">
    <div style="display:flex;flex-direction:column;gap:16px">
        <div class="card"><h3>Info</h3><p class="muted" style="line-height:1.7;margin:0">{{ $ekskul->description ?: 'Belum ada deskripsi.' }}</p></div>
        <div class="card"><h3>Syarat Pendaftaran</h3>
            @forelse ($ekskul->requirementList() as $r)<div style="padding:6px 0">✔ {{ $r }}</div>@empty<p class="muted">Tidak ada syarat khusus.</p>@endforelse
        </div>
        <div class="card"><h3>Anggota ({{ $ekskul->memberCount() }})</h3>
            @auth
                @forelse ($members as $m)<span class="b b-info" style="margin:0 6px 6px 0">{{ $m->name }}</span>@empty<p class="muted">Belum ada anggota.</p>@endforelse
            @else
                <p class="muted">Masuk untuk melihat daftar anggota.</p>
            @endauth
        </div>
    </div>
    <div style="display:flex;flex-direction:column;gap:16px">
        <div class="card"><h3>Detail</h3><div class="kv">
            <div><span>Jadwal</span><span>{{ $ekskul->schedule_text ?: '-' }}</span></div>
            <div><span>Lokasi</span><span>{{ $ekskul->location ?: '-' }}</span></div>
            <div><span>Kuota</span><span>{{ $ekskul->memberCount() }} / {{ $ekskul->quota }}</span></div>
        </div></div>
        <div class="card">
            @auth
                @if (auth()->user()->isSiswa())
                    @if ($myReg)<div style="text-align:center">Status pendaftaran Anda:<br><br>{!! \App\Support\Ui::statusBadge($myReg->status) !!}</div>
                    @else<a class="btn btn-p btn-b" href="{{ route('siswa.ekskul.form', $ekskul) }}">Daftar Sekarang</a>@endif
                @else<p class="muted small" style="margin:0">Pendaftaran hanya untuk akun siswa.</p>@endif
            @else
                <a class="btn btn-p btn-b" href="{{ route('login') }}">Masuk untuk Mendaftar</a>
            @endauth
        </div>
    </div>
</div>
</div>
@endsection
