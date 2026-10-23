@extends('layouts.app')
@section('title', 'Galeri')
@section('subtitle', 'Dokumentasi kegiatan ekstrakurikuler')
@section('content')
@php $canPost = auth()->user()->isAdmin() || auth()->user()->isPembina(); @endphp
@if ($canPost)
<div class="card" style="margin-bottom:16px"><h3>Unggah Dokumentasi</h3>
<form method="POST" action="{{ route('galeri.store') }}" enctype="multipart/form-data">@csrf
    <div class="frow"><div class="f"><label>Judul</label><input name="title" required></div>
        <div class="f"><label>Ekskul</label><select name="ekskul_id">@if (auth()->user()->isAdmin())<option value="">Umum</option>@endif @foreach ($ekskuls as $e)<option value="{{ $e->id }}">{{ $e->name }}</option>@endforeach</select></div></div>
    <div class="frow"><div class="f"><label>Keterangan</label><input name="description"></div><div class="f"><label>Foto (maks 4 MB)</label><input type="file" name="image" accept="image/*" required></div></div>
    <button class="btn btn-p">Unggah</button>
</form></div>
@endif
<div class="gal">
@forelse ($items as $g)
    <div class="it"><img src="{{ asset('storage/'.$g->image_path) }}" alt="{{ $g->title }}">
        <div class="cap">{{ $g->title }}<div class="faint small" style="font-weight:500">{{ $g->ekskul?->name ?? 'Umum' }} · {{ $g->created_at->translatedFormat('d M Y') }}</div>
        @if (auth()->user()->isAdmin() || $g->user_id === auth()->id())<form method="POST" action="{{ route('galeri.destroy', $g) }}" onsubmit="return confirm('Hapus foto?')" style="margin-top:6px">@csrf @method('DELETE')<button class="btn btn-d btn-s">Hapus</button></form>@endif</div></div>
@empty<div class="card" style="grid-column:1/-1"><p class="muted" style="margin:0">Belum ada foto dokumentasi.</p></div>@endforelse
</div>
<div class="mt">{{ $items->links('pagination.ekskul') }}</div>
@endsection
