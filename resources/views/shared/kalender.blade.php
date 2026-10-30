@extends('layouts.app')
@section('title', 'Kalender Kegiatan')
@section('subtitle', 'Semua jadwal ekstrakurikuler dalam satu kalender')
@section('content')
<div class="grid g21"><div class="card">
    <div class="ch"><a class="btn btn-o btn-s" href="?bulan={{ $prev }}">← Sebelumnya</a><h3>{{ $cursor->translatedFormat('F Y') }}</h3><a class="btn btn-o btn-s" href="?bulan={{ $next }}">Berikutnya →</a></div>
    <div class="cal">@foreach (['Sen','Sel','Rab','Kam','Jum','Sab','Min'] as $d)<div class="dow">{{ $d }}</div>@endforeach
    @for ($i = 0; $i < $offset; $i++)<div class="day blank"></div>@endfor
    @for ($d = 1; $d <= $cursor->daysInMonth; $d++)@php $key = $cursor->copy()->day($d)->format('Y-m-d'); @endphp
        <div class="day {{ $key === now()->format('Y-m-d') ? 'today' : '' }}">{{ $d }}@foreach ($events[$key] ?? [] as $ev)<span class="ev" style="background:{{ $ev->ekskul->color }}" title="{{ $ev->title }} · {{ $ev->timeRange() }}">{{ $ev->ekskul->name }}</span>@endforeach</div>
    @endfor</div></div>
<div class="card"><h3>Legenda Ekskul</h3>@forelse ($legend as $l)<div style="display:flex;align-items:center;gap:8px;padding:5px 0;font-size:13px;font-weight:600"><i style="width:10px;height:10px;border-radius:50%;background:{{ $l->color }}"></i>{{ $l->name }}</div>@empty<p class="muted">Belum ada ekskul.</p>@endforelse</div></div>
@endsection
