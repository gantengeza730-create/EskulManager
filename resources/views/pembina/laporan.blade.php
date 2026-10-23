@extends('layouts.app')
@section('title', 'Laporan')
@section('subtitle', 'Rekap presensi ekskul binaan')
@section('content')
<div class="no-print" style="text-align:right;margin-bottom:12px"><button class="btn btn-o btn-s" onclick="window.print()">🖨 Cetak</button></div>
@forelse ($report as $r)
<div class="card" style="margin-bottom:16px"><div class="ch"><h3>{{ $r['ekskul']->name }}</h3><span class="b b-info">{{ $r['sessions'] }} sesi selesai</span></div>
<div class="tw"><table><thead><tr><th>Nama</th><th>Kelas</th><th>Hadir</th><th>Total Sesi Tercatat</th><th>Kehadiran</th></tr></thead><tbody>
    @foreach ($r['members'] as $m)<tr><td class="nm">{{ $m['name'] }}</td><td>{{ $m['kelas'] }}</td><td>{{ $m['hadir'] }}</td><td>{{ $m['total'] }}</td><td>{{ $m['pct'] !== null ? $m['pct'].'%' : '–' }}{!! \App\Support\Ui::bar($m['pct']) !!}</td></tr>@endforeach
</tbody></table></div></div>
@empty<div class="card"><p class="muted" style="margin:0">Belum ada ekskul binaan.</p></div>@endforelse
@endsection
