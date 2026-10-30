@extends('layouts.app')
@section('title', 'Isi Presensi')
@section('subtitle', $schedule->ekskul->name . ' · ' . $schedule->date->translatedFormat('l, d F Y'))
@section('content')
<form method="POST" action="{{ route('pembina.presensi.update', $schedule) }}">@csrf @method('PUT')
<div class="card"><div class="ch"><h3>{{ $schedule->title }} — {{ $schedule->date->translatedFormat('d F Y') }}</h3><div style="display:flex;gap:8px"><button type="button" class="btn btn-o btn-s" onclick="document.querySelectorAll('select.st').forEach(s=>s.value='hadir')">Semua Hadir</button><button class="btn btn-p btn-s">Simpan Presensi</button></div></div>
<div class="tw"><table><thead><tr><th>Nama Siswa</th><th>Kelas</th><th>Status</th></tr></thead><tbody>
@forelse ($members as $m)<tr><td class="nm">{{ $m->name }}</td><td>{{ $m->kelas }}</td><td><select class="inp st" style="width:150px" name="status[{{ $m->id }}]" required>@foreach (['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpha' => 'Alpha'] as $v => $l)<option value="{{ $v }}" @selected(($current[$m->id] ?? 'hadir') === $v)>{{ $l }}</option>@endforeach</select></td></tr>
@empty<tr><td colspan="3" class="muted">Belum ada anggota yang diterima.</td></tr>@endforelse</tbody></table></div></div></form>
@endsection
