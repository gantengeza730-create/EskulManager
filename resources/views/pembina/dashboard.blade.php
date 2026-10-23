@extends('layouts.app')
@section('title', 'Dashboard Pembina')
@section('subtitle', 'Ringkasan ekskul yang Anda bina')
@section('content')
<div class="head"><div><h2>Selamat datang, {{ auth()->user()->name }}</h2><p>Kelola pendaftar, presensi, dan penilaian anggota.</p></div></div>
<div class="grid g4" style="margin-bottom:16px">
    <div class="card stat"><div class="l">Ekskul Dibina</div><div class="v">{{ $ekskuls->count() }}</div><div class="s">{{ $ekskuls->pluck('name')->join(', ') ?: '-' }}</div></div>
    <div class="card stat"><div class="l">Total Anggota</div><div class="v">{{ $totalMembers }}</div></div>
    <div class="card stat"><div class="l">Pendaftar Menunggu</div><div class="v">{{ $pendingCount }}</div><div class="s"><a class="link" href="{{ route('pembina.pendaftar.index', ['status' => 'pending']) }}">Tinjau sekarang</a></div></div>
    <div class="card stat"><div class="l">Rata-rata Kehadiran</div><div class="v">{{ $attPct !== null ? $attPct.'%' : '–' }}</div></div>
</div>
<div class="grid g2">
    <div class="card"><div class="ch"><h3>Pendaftar Terbaru</h3><a class="small" href="{{ route('pembina.pendaftar.index') }}">Semua</a></div>
        @forelse ($pendingList as $r)<div class="li"><div style="flex:1"><div class="nm">{{ $r->user->name }}</div><div class="muted small">{{ $r->user->kelas }} · {{ $r->ekskul->name }}</div></div>{!! \App\Support\Ui::statusBadge($r->status) !!}</div>@empty<p class="muted">Tidak ada pendaftar menunggu.</p>@endforelse</div>
    <div class="card"><div class="ch"><h3>Jadwal Terdekat</h3><a class="small" href="{{ route('pembina.presensi.index') }}">Isi presensi</a></div>
        @forelse ($upcoming as $s)<div class="li"><div class="d">{{ $s->date->format('d') }}<small>{{ $s->date->translatedFormat('M') }}</small></div><div><div class="nm">{{ $s->title }}</div><div class="muted small">{{ $s->ekskul->name }} · {{ $s->timeRange() }} · {{ $s->room?->name ?? '-' }}</div></div></div>@empty<p class="muted">Belum ada jadwal.</p>@endforelse</div>
</div>
@endsection
