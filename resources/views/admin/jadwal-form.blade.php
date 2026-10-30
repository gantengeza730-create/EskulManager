@extends('layouts.app')
@section('title', $schedule->exists ? 'Ubah Jadwal' : 'Buat Jadwal')
@section('content')
<div class="card" style="max-width:720px"><h3>{{ $schedule->exists ? 'Ubah' : 'Buat' }} Jadwal & Alokasi Ruangan <span class="small muted">(semua kolom wajib diisi)</span></h3>
<form method="POST" action="{{ $schedule->exists ? route('admin.jadwal.update', $schedule) : route('admin.jadwal.store') }}">@csrf @if ($schedule->exists) @method('PUT') @endif
    <div class="frow"><div class="f"><label class="req">Ekskul</label><select name="ekskul_id" required>@foreach ($ekskuls as $e)<option value="{{ $e->id }}" @selected(old('ekskul_id', $schedule->ekskul_id) == $e->id)>{{ $e->name }}</option>@endforeach</select></div>
        <div class="f"><label class="req">Ruangan / Tempat</label><select name="room_id" required><option value="">— pilih ruangan —</option>@foreach ($rooms as $r)<option value="{{ $r->id }}" @selected(old('room_id', $schedule->room_id) == $r->id)>{{ $r->name }} ({{ $r->capacity }})</option>@endforeach</select></div></div>
    <div class="f"><label class="req">Nama Kegiatan</label><input name="title" value="{{ old('title', $schedule->title) }}" required></div>
    <div class="frow"><div class="f"><label class="req">{{ $schedule->exists ? 'Tanggal' : 'Tanggal mulai' }}</label><input type="date" name="date" value="{{ old('date', $schedule->date?->format('Y-m-d')) }}" required></div>
        <div class="f"><label class="req">Jenis</label><select name="type" required>@foreach (['latihan' => 'Latihan', 'uji_tanding' => 'Uji Tanding', 'lainnya' => 'Lainnya'] as $k => $l)<option value="{{ $k }}" @selected(old('type', $schedule->type) === $k)>{{ $l }}</option>@endforeach</select></div></div>
    <div class="frow"><div class="f"><label class="req">Mulai</label><input type="time" name="start_time" value="{{ old('start_time', $schedule->start_time ? substr($schedule->start_time, 0, 5) : '15:00') }}" required></div>
        <div class="f"><label class="req">Selesai</label><input type="time" name="end_time" value="{{ old('end_time', $schedule->end_time ? substr($schedule->end_time, 0, 5) : '17:00') }}" required></div></div>
    @unless ($schedule->exists)
    <div class="f"><label class="chk" style="display:inline-flex"><span style="display:flex;gap:8px;align-items:center"><input type="checkbox" name="is_fixed" id="fixedChk" value="1" @checked(old('is_fixed'))> <b>Jadwal Tetap</b> — ulangi setiap minggu pada hari yang sama</span></label></div>
    <div class="f" id="untilBox" style="display:none"><label class="req">Berulang sampai tanggal</label><input type="date" name="repeat_until" id="untilIn" value="{{ old('repeat_until') }}"><span class="small muted">Sistem membuat satu sesi per minggu (maks. 60 sesi). Ruangan dicek bentrok untuk setiap sesi.</span></div>
    @else
    <p class="small muted">{!! \App\Support\Ui::fixedBadge($schedule->is_fixed) !!} {{ $schedule->is_fixed ? 'Perubahan hanya berlaku untuk sesi ini.' : '' }}</p>
    @endunless
    <div class="frow"><div class="f"><label class="req">Status</label><select name="status" required>@foreach (['terjadwal' => 'Terjadwal', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'] as $k => $l)<option value="{{ $k }}" @selected(old('status', $schedule->status) === $k)>{{ $l }}</option>@endforeach</select></div>
        <div class="f"><label class="req">Catatan</label><input name="notes" value="{{ old('notes', $schedule->notes) }}" required></div></div>
    <div style="display:flex;gap:10px"><a class="btn btn-o" href="{{ route('admin.jadwal.index') }}">Batal</a><button class="btn btn-p">Simpan & Beri Notifikasi</button></div>
</form></div>
@endsection
@push('scripts')<script>(function(){var c=document.getElementById('fixedChk');if(!c)return;var b=document.getElementById('untilBox'),i=document.getElementById('untilIn');function s(){b.style.display=c.checked?'':'none';i.required=c.checked;}c.addEventListener('change',s);s();})();</script>@endpush
