@extends('layouts.app')
@section('title', $ekskul->exists ? 'Ubah Ekskul' : 'Tambah Ekskul')
@section('content')
<div class="card" style="max-width:720px"><h3>{{ $ekskul->exists ? 'Ubah' : 'Tambah' }} Ekstrakurikuler</h3>
<form method="POST" action="{{ $ekskul->exists ? route('admin.ekskul.update', $ekskul) : route('admin.ekskul.store') }}">@csrf @if ($ekskul->exists) @method('PUT') @endif
    <div class="frow"><div class="f"><label>Nama Ekskul</label><input name="name" value="{{ old('name', $ekskul->name) }}" required></div>
        <div class="f"><label>Kategori</label><input name="category" list="cats" value="{{ old('category', $ekskul->category ?? 'Olahraga') }}" required><datalist id="cats"><option>Olahraga</option><option>Seni</option><option>Akademik</option><option>Kepramukaan</option><option>Sosial</option></datalist></div></div>
    <div class="f"><label>Deskripsi</label><textarea name="description">{{ old('description', $ekskul->description) }}</textarea></div>
    <div class="f"><label>Syarat pendaftaran (satu syarat per baris)</label><textarea name="requirements">{{ old('requirements', $ekskul->requirements) }}</textarea></div>
    <div class="frow"><div class="f"><label>Jadwal (teks)</label><input name="schedule_text" value="{{ old('schedule_text', $ekskul->schedule_text) }}" placeholder="Selasa & Kamis, 15.00–17.30"></div>
        <div class="f"><label>Lokasi</label><input name="location" value="{{ old('location', $ekskul->location) }}"></div></div>
    <div class="frow"><div class="f"><label>Pembina</label><select name="pembina_id"><option value="">— belum ditentukan —</option>@foreach ($pembinas as $p)<option value="{{ $p->id }}" @selected(old('pembina_id', $ekskul->pembina_id) == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
        <div class="f"><label>Kuota Anggota</label><input type="number" name="quota" min="1" value="{{ old('quota', $ekskul->quota) }}" required></div></div>
    <div class="frow"><div class="f"><label>Warna (kalender & kartu)</label><input type="color" name="color" value="{{ old('color', $ekskul->color) }}" style="height:42px"></div>
        <div class="f"><label>Status</label><label class="small" style="display:flex;gap:8px;align-items:center;padding-top:10px"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $ekskul->exists ? $ekskul->is_active : true)) style="width:auto"> Aktif (tampil di landing & bisa didaftar)</label></div></div>
    <div style="display:flex;gap:10px"><a class="btn btn-o" href="{{ route('admin.ekskul.index') }}">Batal</a><button class="btn btn-p">Simpan</button></div>
</form></div>
@endsection
