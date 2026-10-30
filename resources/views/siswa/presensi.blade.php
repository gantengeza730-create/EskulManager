@extends('layouts.app')
@section('title', 'Presensi Saya')
@section('subtitle', 'Riwayat kehadiran kegiatan ekskul')
@section('content')
<div class="grid g4" style="margin-bottom:16px">
    <div class="card stat"><div class="l">Persentase Hadir</div><div class="v">{{ $pct !== null ? $pct.'%' : '–' }}</div></div>
    <div class="card stat"><div class="l">Hadir</div><div class="v">{{ $summary['hadir'] }}</div></div>
    <div class="card stat"><div class="l">Izin / Sakit</div><div class="v">{{ $summary['izin'] + $summary['sakit'] }}</div></div>
    <div class="card stat"><div class="l">Alpha</div><div class="v">{{ $summary['alpha'] }}</div></div>
</div>
<div class="card"><h3>Riwayat Kehadiran</h3><div class="tw"><table><thead><tr><th>Tanggal</th><th>Ekskul</th><th>Kegiatan</th><th>Status</th></tr></thead><tbody>
@forelse ($rows as $r)<tr><td class="nm">{{ $r->schedule->date->translatedFormat('l, d M Y') }}</td><td>{{ $r->schedule->ekskul->name }}</td><td>{{ $r->schedule->title }}</td><td>{!! \App\Support\Ui::statusBadge($r->status) !!}</td></tr>
@empty<tr><td colspan="4" class="muted">Belum ada data presensi. Data muncul setelah pembina menyimpan kehadiran.</td></tr>@endforelse</tbody></table></div></div>
@endsection
