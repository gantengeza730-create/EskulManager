@extends('layouts.app')
@section('title', 'Laporan & Rekap')
@section('subtitle', 'Rekap kegiatan dan presensi seluruh ekskul')
@section('content')
<div class="head"><div><h2>Laporan Kegiatan & Rekap Presensi</h2><p>Ringkasan untuk pelaporan ke sekolah.</p></div>
    <div style="display:flex;gap:8px" class="no-print"><button class="btn btn-o" onclick="window.print()">🖨 Cetak</button><a class="btn btn-p" href="{{ route('admin.laporan.ekspor') }}">Unduh CSV (Excel)</a></div></div>
<div class="card"><div class="tw"><table><thead><tr><th>Ekskul</th><th>Pembina</th><th>Anggota</th><th>Sesi Selesai</th><th>Catatan Presensi</th><th>Kehadiran</th></tr></thead><tbody>
@foreach ($rows as $r)<tr><td class="nm">{{ $r['name'] }}</td><td>{{ $r['pembina'] }}</td><td>{{ $r['members'] }}</td><td>{{ $r['sessions'] }}</td><td>{{ $r['hadir'] }}/{{ $r['records'] }} hadir</td><td>{{ $r['pct'] !== null ? $r['pct'].'%' : '–' }}{!! \App\Support\Ui::bar($r['pct']) !!}</td></tr>@endforeach
</tbody></table></div></div>
@endsection
