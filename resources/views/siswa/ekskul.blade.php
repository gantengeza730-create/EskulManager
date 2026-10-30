@extends('layouts.app')
@section('title', 'Ekstrakurikuler')
@section('subtitle', 'Jelajahi dan daftar ekstrakurikuler sekolah')
@section('content')
<div class="head"><div><h2>Jelajahi Ekstrakurikuler</h2><p>Lihat info, syarat, dan anggota sebelum mendaftar.</p></div></div>
<div class="pills"><a class="pill {{ !$cat ? 'on' : '' }}" href="{{ route('siswa.ekskul.index') }}">Semua</a>@foreach ($categories as $c)<a class="pill {{ $cat === $c ? 'on' : '' }}" href="?kategori={{ $c }}">{{ $c }}</a>@endforeach</div>
<div class="ekgrid">
@foreach ($ekskuls as $e)
    @php $reg = $mine[$e->id] ?? null; @endphp
    <div class="ek">
        <div class="dot" style="background:{{ $e->color }}">{{ strtoupper(substr($e->name,0,1)) }}</div>
        <h4>{{ $e->name }}</h4>
        <div class="muted small">Pembina: {{ $e->pembina?->name ?? '—' }}</div><div class="muted small">{{ $e->schedule_text }}</div>
        <div style="display:flex;justify-content:space-between;align-items:center;gap:6px;flex-wrap:wrap"><span class="small faint">{{ $e->members_count }}/{{ $e->quota }} anggota</span>
            <span>{!! \App\Support\Ui::bigBadge($e->isBig($e->members_count)) !!} @if ($reg){!! \App\Support\Ui::statusBadge($reg->status) !!}@else<span class="b b-info">{{ $e->category }}</span>@endif</span></div>
        @if ($reg && $reg->status === 'rejected' && $reg->reject_reason)<div class="small" style="color:var(--bad)">Alasan ditolak: {{ $reg->reject_reason }}</div>@endif
        <div style="display:flex;gap:8px;margin-top:4px"><a class="btn btn-o btn-s" style="flex:1" href="{{ route('ekskul.show', $e) }}">Detail</a>@if (!$reg)<a class="btn btn-p btn-s" style="flex:1" href="{{ route('siswa.ekskul.form', $e) }}">Daftar</a>@endif</div>
    </div>
@endforeach
</div>
@endsection
