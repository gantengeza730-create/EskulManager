@extends('layouts.app')
@section('title', 'Pengumuman & Berita')
@section('subtitle', 'Informasi ekstrakurikuler')
@section('content')
@php $canPost = auth()->user()->isAdmin() || auth()->user()->isPembina(); @endphp
<div class="grid {{ $canPost ? 'g21' : '' }}">
<div>
    @forelse ($items as $a)
        <div class="ann"><div style="display:flex;justify-content:space-between;gap:10px"><h4>{{ $a->title }}</h4>
            <span><span class="b {{ $a->type === 'berita' ? 'b-pur' : 'b-info' }}">{{ ucfirst($a->type) }}</span> <span class="b b-warn">{{ $a->ekskul?->name ?? 'Semua' }}</span></span></div>
            <div class="faint small">{{ $a->author->name }} · {{ $a->created_at->translatedFormat('d M Y H:i') }}</div><p>{{ $a->body }}</p>
            @if (auth()->user()->isAdmin() || $a->user_id === auth()->id())
                <form method="POST" action="{{ route('pengumuman.destroy', $a) }}" onsubmit="return confirm('Hapus?')" style="margin-top:8px">@csrf @method('DELETE')<button class="btn btn-d btn-s">Hapus</button></form>@endif
        </div>
    @empty<div class="card"><p class="muted" style="margin:0">Belum ada pengumuman.</p></div>@endforelse
    {{ $items->links('pagination.ekskul') }}
</div>
@if ($canPost)
<div class="card"><h3>Buat Pengumuman / Berita</h3>
<form method="POST" action="{{ route('pengumuman.store') }}">@csrf
    <div class="f"><label>Jenis</label><select name="type"><option value="pengumuman">Pengumuman</option><option value="berita">Berita</option></select></div>
    <div class="f"><label>Ditujukan untuk</label><select name="ekskul_id">@if (auth()->user()->isAdmin())<option value="">Seluruh sekolah</option>@endif @foreach ($ekskuls as $e)<option value="{{ $e->id }}">{{ $e->name }}</option>@endforeach</select></div>
    <div class="f"><label>Judul</label><input name="title" required></div>
    <div class="f"><label>Isi</label><textarea name="body" required></textarea></div>
    <button class="btn btn-p btn-b">Terbitkan (kirim notifikasi)</button>
</form></div>
@endif
</div>
@endsection
