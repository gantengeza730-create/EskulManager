@extends('layouts.app')
@section('title', $ekskul->exists ? 'Ubah Ekskul' : 'Tambah Ekskul')
@section('content')
<div class="card" style="max-width:720px"><h3>{{ $ekskul->exists ? 'Ubah' : 'Tambah' }} Ekstrakurikuler <span class="small muted">(semua kolom wajib diisi)</span></h3>
<form method="POST" action="{{ $ekskul->exists ? route('admin.ekskul.update', $ekskul) : route('admin.ekskul.store') }}">@csrf @if ($ekskul->exists) @method('PUT') @endif
    <div class="frow"><div class="f"><label class="req">Nama Ekskul</label><input name="name" value="{{ old('name', $ekskul->name) }}" required></div>
        <div class="f"><label class="req">Kategori</label><input name="category" list="cats" value="{{ old('category', $ekskul->category ?? 'Olahraga') }}" required><datalist id="cats"><option>Olahraga</option><option>Seni</option><option>Akademik</option><option>Kepramukaan</option><option>Sosial</option></datalist></div></div>
    <div class="f"><label class="req">Deskripsi</label><textarea name="description" required>{{ old('description', $ekskul->description) }}</textarea></div>
    <div class="f"><label class="req">Syarat pendaftaran (satu syarat per baris)</label><textarea name="requirements" required>{{ old('requirements', $ekskul->requirements) }}</textarea></div>
    <div class="frow"><div class="f"><label class="req">Jadwal (teks)</label><input name="schedule_text" value="{{ old('schedule_text', $ekskul->schedule_text) }}" placeholder="Selasa, 15.00–17.30" required></div><div class="f"><label class="req">Lokasi</label><input name="location" value="{{ old('location', $ekskul->location) }}" required></div></div>
    <div class="frow"><div class="f"><label class="req">Pembina</label><select name="pembina_id" required><option value="">— pilih pembina —</option>@foreach ($pembinas as $p)<option value="{{ $p->id }}" @selected(old('pembina_id', $ekskul->pembina_id) == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
        <div class="f"><label class="req">Kuota Anggota</label><input type="number" name="quota" min="1" value="{{ old('quota', $ekskul->quota) }}" required></div></div>
    <div class="frow"><div class="f"><label class="req">Warna (kalender & kartu)</label><input type="color" name="color" value="{{ old('color', $ekskul->color) }}" style="height:42px" required></div>
        <div class="f"><label>Status</label><label class="small" style="display:flex;gap:8px;align-items:center;padding-top:10px"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $ekskul->exists ? $ekskul->is_active : true)) style="width:auto"> Aktif (tampil di landing & bisa didaftar)</label>
            <label class="small" style="display:flex;gap:8px;align-items:center;padding-top:10px"><input type="checkbox" name="is_big" value="1" @checked(old('is_big', $ekskul->is_big ?? false)) style="width:auto"> Tandai sebagai Ekskul Besar</label></div></div>
    <div style="display:flex;gap:10px"><a class="btn btn-o" href="{{ route('admin.ekskul.index') }}">Batal</a><button class="btn btn-p">Simpan</button></div>
</form></div>
@endsection
