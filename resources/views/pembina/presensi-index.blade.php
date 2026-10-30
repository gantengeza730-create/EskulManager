@extends('layouts.app')
@section('title', 'Presensi')
@section('subtitle', 'Pilih tanggal sesi untuk mengisi kehadiran')
@section('content')
<form method="GET" class="filters">
    <div class="f"><label>Dari tanggal</label><input class="inp" type="date" name="dari" value="{{ $dari }}"></div>
    <div class="f"><label>Sampai tanggal</label><input class="inp" type="date" name="sampai" value="{{ $sampai }}"></div>
    <button class="btn btn-p">Terapkan</button><a class="btn btn-o" href="{{ route('pembina.presensi.index') }}">Reset</a>
</form>
<div class="card"><h3>Tanggal Presensi</h3><div class="tw"><table><thead><tr><th>Tanggal</th><th>Ekskul</th><th>Kegiatan</th><th>Waktu</th><th>Presensi</th><th></th></tr></thead><tbody>
@forelse ($schedules as $s)
<tr><td class="nm">{{ $s->date->translatedFormat('l, d F Y') }}</td><td>{{ $s->ekskul->name }}</td><td>{{ $s->title }} {!! \App\Support\Ui::fixedBadge($s->is_fixed) !!}</td><td>{{ $s->timeRange() }}</td>
    <td>@if ($s->attendances_count)<span class="b b-ok">{{ $s->attendances_count }} tercatat</span>@else<span class="b b-warn">Belum diisi</span>@endif</td>
    <td><a class="btn btn-p btn-s" href="{{ route('pembina.presensi.edit', $s) }}">Isi / Ubah</a></td></tr>
@empty<tr><td colspan="6" class="muted">Belum ada sesi pada rentang ini.</td></tr>@endforelse</tbody></table></div>
<div class="mt">{{ $schedules->links('pagination.ekskul') }}</div></div>
@endsection
