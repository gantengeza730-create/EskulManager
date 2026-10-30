@extends('layouts.app')
@section('title', 'Jadwal')
@section('subtitle', 'Jadwal latihan dan kegiatan ekskul')
@section('content')
<div class="head"><div><h2>Jadwal Kegiatan</h2><p>Jadwal dari ekskul yang kamu ikuti/bina.</p></div><a class="btn btn-o" href="{{ route('kalender.index') }}">Lihat Kalender</a></div>
<div class="card" style="margin-bottom:16px"><h3>Akan Datang</h3><div class="tw"><table><thead><tr><th>Tanggal</th><th>Ekskul</th><th>Kegiatan</th><th>Waktu</th><th>Lokasi</th><th>Status</th></tr></thead><tbody>
@forelse ($upcoming as $s)<tr><td class="nm">{{ $s->date->translatedFormat('D, d M Y') }}</td><td>{{ $s->ekskul->name }}</td><td>{{ $s->title }} <span class="small faint">({{ $s->typeLabel() }})</span></td><td>{{ $s->timeRange() }}</td><td>{{ $s->room?->name ?? '-' }}</td><td>{!! \App\Support\Ui::statusBadge($s->displayStatus()) !!} {!! \App\Support\Ui::fixedBadge($s->is_fixed) !!}</td></tr>
@empty<tr><td colspan="6" class="muted">Belum ada jadwal mendatang.</td></tr>@endforelse</tbody></table></div></div>
<div class="card"><h3>Riwayat Terakhir</h3><div class="tw"><table><thead><tr><th>Tanggal</th><th>Ekskul</th><th>Kegiatan</th><th>Status</th></tr></thead><tbody>
@forelse ($past as $s)<tr><td class="nm">{{ $s->date->translatedFormat('d M Y') }}</td><td>{{ $s->ekskul->name }}</td><td>{{ $s->title }}</td><td>{!! \App\Support\Ui::statusBadge($s->displayStatus()) !!} {!! \App\Support\Ui::fixedBadge($s->is_fixed) !!}</td></tr>
@empty<tr><td colspan="4" class="muted">Belum ada riwayat.</td></tr>@endforelse</tbody></table></div></div>
@endsection
