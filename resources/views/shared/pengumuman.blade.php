@extends('layouts.app')
@section('title', 'Pengumuman & Berita')
@section('subtitle', 'Informasi ekstrakurikuler')
@section('content')
@php $canPost = auth()->user()->isAdmin() || auth()->user()->isPembina(); $isAdmin = auth()->user()->isAdmin(); @endphp
<div class="grid {{ $canPost ? 'g21' : '' }}">
<div>
    <form method="GET" class="filters">
        <div class="f"><label>Jenis</label><select class="inp" name="jenis" onchange="this.form.submit()"><option value="">Semua (Pengumuman &amp; Berita)</option><option value="pengumuman" @selected($type === 'pengumuman')>Pengumuman</option><option value="berita" @selected($type === 'berita')>Berita</option></select></div>
        <div class="f"><label>Tentang / Ditujukan untuk</label><select class="inp" name="tentang" onchange="this.form.submit()"><option value="">Semua</option><option value="sekolah" @selected($about === 'sekolah')>Sekolah (umum)</option>@foreach ($topics as $t)<option value="{{ $t->id }}" @selected((string) $about === (string) $t->id)>{{ $t->name }}</option>@endforeach</select></div>
        @if ($type || $about)<a class="btn btn-o" href="{{ route('pengumuman.index') }}">Reset</a>@endif
    </form>
    @forelse ($items as $a)
        <div class="ann"><div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap"><h4>{{ $a->title }}</h4>
            <span><span class="b {{ $a->type === 'berita' ? 'b-pur' : 'b-info' }}">{{ ucfirst($a->type) }}</span> <span class="b b-warn">{{ $a->type === 'berita' ? 'Tentang: ' : 'Untuk: ' }}{{ $a->aboutLabel() }}</span></span></div>
            <div class="faint small">{{ $a->author->name }} · {{ $a->created_at->translatedFormat('d M Y H:i') }}</div><p>{{ $a->body }}</p>
            @if ($isAdmin || $a->user_id === auth()->id())<form method="POST" action="{{ route('pengumuman.destroy', $a) }}" onsubmit="return confirm('Hapus?')" style="margin-top:8px">@csrf @method('DELETE')<button class="btn btn-d btn-s">Hapus</button></form>@endif</div>
    @empty<div class="card"><p class="muted" style="margin:0">Tidak ada data untuk filter ini.</p></div>@endforelse
    {{ $items->links('pagination.ekskul') }}
</div>
@if ($canPost)
<div class="card"><h3>Buat Pengumuman / Berita</h3>
<form method="POST" action="{{ route('pengumuman.store') }}" id="annForm">@csrf
    <div class="f"><label class="req">Jenis</label><select name="type" id="annType" required><option value="pengumuman" @selected(old('type') !== 'berita')>Pengumuman</option><option value="berita" @selected(old('type') === 'berita')>Berita</option></select></div>
    <div class="f" id="boxTargets"><label class="req">Ditujukan untuk (pilih satu atau lebih)</label>
        <div class="chk">@if ($isAdmin)<label><input type="checkbox" name="targets[]" value="all" @checked(in_array('all', old('targets', [])))> Seluruh sekolah</label>@endif
            @foreach ($ekskuls as $e)<label><input type="checkbox" name="targets[]" value="{{ $e->id }}" @checked(in_array((string) $e->id, array_map('strval', old('targets', []))))> {{ $e->name }}</label>@endforeach</div></div>
    <div class="f" id="boxAbout" style="display:none"><label class="req">Berita tentang</label><select name="about"><option value="">— pilih topik —</option>@if ($isAdmin)<option value="sekolah">Sekolah</option>@endif @foreach ($ekskuls as $e)<option value="{{ $e->id }}" @selected(old('about') == $e->id)>{{ $e->name }}</option>@endforeach</select></div>
    <div class="f"><label class="req">Judul</label><input name="title" value="{{ old('title') }}" required></div>
    <div class="f"><label class="req">Isi</label><textarea name="body" required>{{ old('body') }}</textarea></div>
    <button class="btn btn-p btn-b">Terbitkan (kirim notifikasi)</button>
</form></div>
@endif
</div>
@endsection
@push('scripts')
<script>
(function(){var t=document.getElementById('annType');if(!t)return;var tg=document.getElementById('boxTargets'),ab=document.getElementById('boxAbout'),sel=ab.querySelector('select');
function sync(){var b=t.value==='berita';tg.style.display=b?'none':'';ab.style.display=b?'':'none';sel.required=b;}
t.addEventListener('change',sync);sync();
document.getElementById('annForm').addEventListener('submit',function(e){if(t.value==='pengumuman'&&!tg.querySelector('input:checked')){e.preventDefault();alert('Pilih minimal satu tujuan pengumuman.');}});})();
</script>
@endpush
