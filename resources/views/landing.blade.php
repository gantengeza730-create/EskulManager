@extends('layouts.public')
@section('title', 'Beranda')
@section('content')
<section class="hero-space">
    <div class="starfield" id="starfield"></div>
    <div class="nebula n1"></div><div class="nebula n2"></div><div class="nebula n3"></div>
    <span class="shoot" style="top:12%"></span><span class="shoot" style="top:32%;animation-delay:2.4s"></span>
    <div class="hcontent">
        <span class="eb"><span class="dotpulse"></span> {{ $school->name() }} · Tahun Ajaran {{ now()->year }}/{{ now()->year + 1 }}</span>
        <h1>Satu Portal untuk <span class="grad">Semua Kegiatan</span> Ekstrakurikuler</h1>
        <p>Daftar ekskul, pantau jadwal, cek presensi, lihat nilai, dan unduh sertifikat — semua dalam satu tempat untuk siswa, pembina, dan admin sekolah.</p>
        <div class="cta"><a class="btn btn-p" href="{{ route('register') }}">+ Daftar Sebagai Siswa</a><a class="btn btn-o" href="{{ route('login') }}">Sudah Punya Akun? Masuk →</a></div>
        <div class="stats"><div><b>{{ $stats['ekskul'] }}</b><span>Cabang Ekskul</span></div><div><b>{{ $stats['siswa'] }}</b><span>Siswa Bergabung</span></div><div><b>{{ $stats['pembina'] }}</b><span>Guru Pembina</span></div></div>
    </div>
</section>

<section class="sec" id="ekskul">
    <div class="sh"><h2>Temukan Ekskul yang Cocok Untukmu</h2><p>Pilih sesuai minat dan bakatmu. Ekskul bertanda ★ adalah ekskul besar dengan anggota terbanyak.</p></div>
    <div class="ekgrid">
        @foreach ($ekskuls as $e)
            <a class="ek" href="{{ route('ekskul.show', $e) }}">
                <div class="dot" style="background:{{ $e->color }}">{{ strtoupper(substr($e->name, 0, 1)) }}</div>
                <h4>{{ $e->name }}</h4>
                <div class="muted small">{{ $e->schedule_text }}</div><div class="muted small">Pembina: {{ $e->pembina?->name ?? '—' }}</div>
                <div style="display:flex;justify-content:space-between;align-items:center;gap:6px;flex-wrap:wrap"><span class="small faint">{{ $e->members_count }}/{{ $e->quota }} anggota</span><span>{!! \App\Support\Ui::bigBadge($e->isBig($e->members_count)) !!} <span class="b b-info">{{ $e->category }}</span></span></div>
            </a>
        @endforeach
    </div>
</section>

<section class="sec" id="cara">
    <div class="sh"><h2>Cara Bergabung, Hanya 4 Langkah</h2><p>Mudah dan cepat — dari pendaftaran akun sampai resmi jadi anggota.</p></div>
    <div class="steps">
        <div class="step"><div class="n">1</div><h4>Buat Akun Siswa</h4><p>Daftar dengan data diri dan email aktif, lalu verifikasi dengan kode 6 digit.</p></div>
        <div class="step"><div class="n">2</div><h4>Pilih Ekstrakurikuler</h4><p>Baca info, syarat, dan jadwal di halaman detail ekskul.</p></div>
        <div class="step"><div class="n">3</div><h4>Isi Formulir Pendaftaran</h4><p>Kirim formulir dan tunggu persetujuan dari pembina.</p></div>
        <div class="step"><div class="n">4</div><h4>Mulai Berkegiatan</h4><p>Ikuti latihan, pantau presensi dan nilai, kumpulkan sertifikat.</p></div>
    </div>
</section>

@if ($berita->count())
<section class="sec" id="berita">
    <div class="sh"><h2>Berita &amp; Prestasi</h2><p>Filter berita berdasarkan topiknya.</p></div>
    <div class="pills" style="justify-content:center" data-filter-group="berita">
        <button class="pill on" data-f="all">Semua</button><button class="pill" data-f="sekolah">Sekolah</button>
        @foreach ($ekskuls as $e)<button class="pill" data-f="{{ $e->id }}">{{ $e->name }}</button>@endforeach
    </div>
    <div class="grid g3">
        @foreach ($berita as $b)
            <div class="card" data-topic-of="berita" data-topic="{{ $b->ekskul_id ?? 'sekolah' }}"><span class="b b-pur">{{ $b->ekskul?->name ?? 'Sekolah' }}</span><h3 style="margin:12px 0 8px">{{ $b->title }}</h3>
                <p class="muted small" style="line-height:1.6;margin:0 0 10px">{{ \Illuminate\Support\Str::limit($b->body, 140) }}</p><span class="faint small">{{ $b->created_at->translatedFormat('d M Y') }}</span></div>
        @endforeach
    </div>
</section>
@endif

@if ($galeri->count())
<section class="sec">
    <div class="sh"><h2>Dokumentasi Kegiatan</h2></div>
    <div class="pills" style="justify-content:center" data-filter-group="galeri">
        <button class="pill on" data-f="all">Semua</button><button class="pill" data-f="sekolah">Sekolah</button>
        @foreach ($ekskuls as $e)<button class="pill" data-f="{{ $e->id }}">{{ $e->name }}</button>@endforeach
    </div>
    <div class="gal">
        @foreach ($galeri as $g)
            <div class="it" data-topic-of="galeri" data-topic="{{ $g->ekskul_id ?? 'sekolah' }}"><img src="{{ asset('storage/'.$g->image_path) }}" alt="{{ $g->title }}"><div class="cap">{{ $g->title }}<div class="faint small" style="font-weight:500">{{ $g->ekskul?->name ?? 'Sekolah' }}</div></div></div>
        @endforeach
    </div>
</section>
@endif

<div class="cta-band"><h2>Siap Bergabung dengan Ekstrakurikuler Favoritmu?</h2><p>Buat akun sekarang, hanya butuh dua menit.</p><a class="btn btn-p" href="{{ route('register') }}">+ Daftar Sekarang</a></div>
@endsection
