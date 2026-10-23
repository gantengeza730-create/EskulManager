@extends('layouts.app')
@section('title', $schedule->exists ? 'Ubah Jadwal' : 'Buat Jadwal')
@section('content')
<div class="card" style="max-width:720px"><h3>{{ $schedule->exists ? 'Ubah' : 'Buat' }} Jadwal & Alokasi Ruangan</h3>
<form method="POST" action="{{ $schedule->exists ? route('admin.jadwal.update', $schedule) : route('admin.jadwal.store') }}">@csrf @if ($schedule->exists) @method('PUT') @endif
    <div class="frow"><div class="f"><label>Ekskul</label><select name="ekskul_id" required>@foreach ($ekskuls as $e)<option value="{{ $e->id }}" @selected(old('ekskul_id', $schedule->ekskul_id) == $e->id)>{{ $e->name }}</option>@endforeach</select></div>
        <div class="f"><label>Ruangan / Tempat</label><select name="room_id"><option value="">— tanpa ruangan —</option>@foreach ($rooms as $r)<option value="{{ $r->id }}" @selected(old('room_id', $schedule->room_id) == $r->id)>{{ $r->name }} ({{ $r->capacity }})</option>@endforeach</select></div></div>
    <div class="f"><label>Nama Kegiatan</label><input name="title" value="{{ old('title', $schedule->title) }}" required></div>
    <div class="frow"><div class="f"><label>Tanggal</label><input type="date" name="date" value="{{ old('date', $schedule->date?->format('Y-m-d')) }}" required></div>
        <div class="f"><label>Jenis</label><select name="type">@foreach (['latihan' => 'Latihan', 'uji_tanding' => 'Uji Tanding', 'lainnya' => 'Lainnya'] as $k => $l)<option value="{{ $k }}" @selected(old('type', $schedule->type) === $k)>{{ $l }}</option>@endforeach</select></div></div>
    <div class="frow"><div class="f"><label>Mulai</label><input type="time" name="start_time" value="{{ old('start_time', $schedule->start_time ? substr($schedule->start_time, 0, 5) : '15:00') }}" required></div>
        <div class="f"><label>Selesai</label><input type="time" name="end_time" value="{{ old('end_time', $schedule->end_time ? substr($schedule->end_time, 0, 5) : '17:00') }}" required></div></div>
    <div class="frow"><div class="f"><label>Status</label><select name="status">@foreach (['terjadwal' => 'Terjadwal', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'] as $k => $l)<option value="{{ $k }}" @selected(old('status', $schedule->status) === $k)>{{ $l }}</option>@endforeach</select></div>
        <div class="f"><label>Catatan</label><input name="notes" value="{{ old('notes', $schedule->notes) }}"></div></div>
    <div style="display:flex;gap:10px"><a class="btn btn-o" href="{{ route('admin.jadwal.index') }}">Batal</a><button class="btn btn-p">Simpan & Beri Notifikasi</button></div>
</form></div>
@endsection
