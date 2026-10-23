@extends('layouts.app')
@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan kegiatan ekstrakurikulermu')
@section('content')
<div class="head"><div><h2>Halo, {{ explode(' ', auth()->user()->name)[0] }} 👋</h2><p>{{ auth()->user()->kelas }} · NIS {{ auth()->user()->nis }}</p></div>
    <a class="btn btn-p" href="{{ route('siswa.ekskul.index') }}">+ Daftar Ekskul Baru</a></div>
<div class="grid g4" style="margin-bottom:16px">
    <div class="card stat"><div class="l">Ekskul Diikuti</div><div class="v">{{ $joined->count() }}</div><div class="s">{{ $joined->pluck('name')->join(', ') ?: 'Belum bergabung' }}</div></div>
    <div class="card stat"><div class="l">Kehadiran Saya</div><div class="v">{{ $attPct !== null ? $attPct.'%' : '–' }}</div><div class="s">{{ $attPct !== null ? 'Dari semua sesi tercatat' : 'Belum ada data presensi' }}</div></div>
    <div class="card stat"><div class="l">Rata-rata Nilai</div><div class="v">{{ $avg ?? '–' }}</div><div class="s">{{ $avg ? 'Dari 4 aspek penilaian' : 'Belum ada penilaian' }}</div></div>
    <div class="card stat"><div class="l">Sertifikat</div><div class="v">{{ $certCount }}</div><div class="s"><a class="link" href="{{ route('siswa.sertifikat') }}">Lihat sertifikat</a></div></div>
</div>
@if ($pending->count())<div class="flash" style="background:var(--warn-soft);color:var(--warn)">Menunggu persetujuan pembina: {{ $pending->pluck('ekskul.name')->join(', ') }}</div>@endif
<div class="grid g21">
    <div style="display:flex;flex-direction:column;gap:16px">
        <div class="card"><div class="ch"><h3>Jadwal Terdekat</h3><a class="small" href="{{ route('jadwal.index') }}">Lihat semua</a></div>
            @forelse ($upcoming as $s)
                <div class="li"><div class="d">{{ $s->date->format('d') }}<small>{{ $s->date->translatedFormat('M') }}</small></div>
                    <div><div class="nm">{{ $s->title }}</div><div class="muted small">{{ $s->ekskul->name }} · {{ $s->timeRange() }} · {{ $s->room?->name ?? '-' }}</div></div></div>
            @empty<p class="muted">Belum ada jadwal mendatang.</p>@endforelse
        </div>
        <div class="card"><div class="ch"><h3>Pengumuman Terbaru</h3><a class="small" href="{{ route('pengumuman.index') }}">Lihat semua</a></div>
            @forelse ($announcements as $a)<div class="ann"><h4>{{ $a->title }}</h4><p>{{ \Illuminate\Support\Str::limit($a->body, 120) }}</p></div>@empty<p class="muted">Belum ada pengumuman.</p>@endforelse
        </div>
    </div>
    <div class="card"><h3>Ekskul Saya</h3>
        @forelse ($joined as $e)
            <div class="li"><div class="ava" style="background:{{ $e->color }}">{{ strtoupper(substr($e->name,0,1)) }}</div>
                <div><div class="nm"><a href="{{ route('ekskul.show', $e) }}">{{ $e->name }}</a></div><div class="muted small">{{ $e->schedule_text }}</div><div class="muted small">{{ $e->location }}</div></div></div>
        @empty<p class="muted">Belum ada ekskul. <a class="link" href="{{ route('siswa.ekskul.index') }}">Jelajahi ekskul</a></p>@endforelse
    </div>
</div>
@endsection
