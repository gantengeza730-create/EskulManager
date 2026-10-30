@extends('layouts.app')
@section('title', 'Galeri & Dokumentasi')
@section('subtitle', 'Dokumentasi kegiatan ekstrakurikuler')
@section('content')
@php $canPost = auth()->user()->isAdmin() || auth()->user()->isPembina(); @endphp
@if ($canPost)
<div class="card" style="margin-bottom:16px"><h3>Unggah Dokumentasi (semua kolom wajib diisi)</h3>
<form method="POST" action="{{ route('galeri.store') }}" enctype="multipart/form-data">@csrf
    <div class="frow"><div class="f"><label class="req">Judul</label><input name="title" value="{{ old('title') }}" required></div>
        <div class="f"><label class="req">Dokumentasi tentang</label><select name="about" required><option value="">— pilih —</option>@if (auth()->user()->isAdmin())<option value="sekolah">Sekolah</option>@endif @foreach ($ekskuls as $e)<option value="{{ $e->id }}">{{ $e->name }}</option>@endforeach</select></div></div>
    <div class="frow"><div class="f"><label class="req">Keterangan</label><input name="description" value="{{ old('description') }}" required></div><div class="f"><label class="req">Foto (maks 4 MB)</label><input type="file" name="image" accept="image/*" required></div></div>
    <button class="btn btn-p">Unggah</button></form></div>
@endif
<form method="GET" class="filters"><div class="f"><label>Dokumentasi tentang</label><select class="inp" name="tentang" onchange="this.form.submit()"><option value="">Semua</option><option value="sekolah" @selected($about === 'sekolah')>Sekolah</option>@foreach ($topics as $t)<option value="{{ $t->id }}" @selected((string) $about === (string) $t->id)>{{ $t->name }}</option>@endforeach</select></div>@if ($about)<a class="btn btn-o" href="{{ route('galeri.index') }}">Reset</a>@endif</form>
<div class="gal">
@forelse ($items as $g)<div class="it"><img src="{{ asset('storage/'.$g->image_path) }}" alt="{{ $g->title }}"><div class="cap">{{ $g->title }}<div class="faint small" style="font-weight:500">{{ $g->ekskul?->name ?? 'Sekolah' }} · {{ $g->created_at->translatedFormat('d M Y') }}</div><div class="muted small" style="font-weight:500">{{ $g->description }}</div>
    @if (auth()->user()->isAdmin() || $g->user_id === auth()->id())<form method="POST" action="{{ route('galeri.destroy', $g) }}" onsubmit="return confirm('Hapus foto?')" style="margin-top:6px">@csrf @method('DELETE')<button class="btn btn-d btn-s">Hapus</button></form>@endif</div></div>
@empty<div class="card" style="grid-column:1/-1"><p class="muted" style="margin:0">Belum ada foto dokumentasi.</p></div>@endforelse
</div>
<div class="mt">{{ $items->links('pagination.ekskul') }}</div>
@endsection
