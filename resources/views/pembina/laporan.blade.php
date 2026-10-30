@extends('layouts.app')
@section('title', 'Laporan')
@section('subtitle', 'Rekap presensi ekskul binaan')
@section('content')
@include('partials.print-header', ['title' => 'Laporan Kehadiran Ekstrakurikuler', 'subtitle' => 'Periode ' . $label])
<div class="no-print">@include('shared.filter-rentang', ['route' => 'pembina.laporan', 'key' => $key, 'from' => $from, 'to' => $to])
<div style="text-align:right;margin-bottom:12px"><button class="btn btn-o btn-s" onclick="window.print()">🖨 Cetak Laporan</button></div></div>
<p class="muted small no-print">Periode: <b>{{ $label }}</b></p>
@forelse ($report as $r)
<div class="card" style="margin-bottom:16px"><div class="ch"><h3>{{ $r['ekskul']->name }}</h3><span class="b b-info">{{ $r['sessions'] }} sesi sudah berlangsung</span></div>
<div class="tw"><table><thead><tr><th>Nama</th><th>Kelas</th><th>Hadir</th><th>Izin/Sakit</th><th>Alpha</th><th>Total</th><th>Kehadiran</th></tr></thead><tbody>
@foreach ($r['members'] as $m)<tr><td class="nm">{{ $m['name'] }}</td><td>{{ $m['kelas'] }}</td><td>{{ $m['hadir'] }}</td><td>{{ $m['izin'] }}</td><td>{{ $m['alpha'] }}</td><td>{{ $m['total'] }}</td><td>{{ $m['pct'] !== null ? $m['pct'].'%' : '–' }}{!! \App\Support\Ui::bar($m['pct']) !!}</td></tr>@endforeach</tbody></table></div></div>
@empty<div class="card"><p class="muted" style="margin:0">Belum ada ekskul binaan.</p></div>@endforelse
@include('partials.print-sign', ['leftTitle' => 'Pembina Ekskul', 'leftName' => auth()->user()->name])
@endsection
