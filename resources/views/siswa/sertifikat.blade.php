@extends('layouts.app')
@section('title', 'Sertifikat')
@section('subtitle', 'Piagam dan sertifikat keikutsertaan')
@section('content')
<div class="card"><h3>Sertifikat Saya</h3>
@forelse ($items as $c)<div class="li"><div class="ava" style="background:var(--purple)">✪</div><div style="flex:1"><div class="nm">{{ $c->title }}</div><div class="muted small">{{ $c->ekskul->name }} · No. {{ $c->number }} · {{ $c->issued_at->translatedFormat('d M Y') }}</div></div><a class="btn btn-o btn-s" target="_blank" href="{{ route('sertifikat.cetak', $c) }}">Lihat / Cetak</a></div>
@empty<p class="muted">Belum ada sertifikat.</p>@endforelse</div>
@endsection
