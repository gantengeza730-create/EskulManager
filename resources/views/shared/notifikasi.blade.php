@extends('layouts.app')
@section('title', 'Notifikasi')
@section('subtitle', 'Pengingat jadwal dan pengumuman')
@section('content')
<div class="head"><div><h2>Notifikasi</h2><p>Jadwal kegiatan, pengumuman, dan status terbaru untukmu.</p></div><a class="btn btn-o btn-s" href="{{ route('notifikasi.readall') }}">Tandai semua dibaca</a></div>
@forelse ($items as $n)
    <a class="ntf {{ $n->read_at ? '' : 'un' }}" href="{{ route('notifikasi.read', $n->id) }}" style="display:block">
        <b>{{ $n->title }}</b><div class="muted small" style="margin-top:2px">{{ $n->message }}</div><div class="faint small" style="margin-top:4px">{{ $n->created_at->diffForHumans() }}</div></a>
@empty<div class="card"><p class="muted" style="margin:0">Belum ada notifikasi.</p></div>@endforelse
{{ $items->links('pagination.ekskul') }}
@endsection
