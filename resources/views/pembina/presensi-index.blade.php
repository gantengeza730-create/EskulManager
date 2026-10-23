@extends('layouts.app')
@section('title', 'Presensi')
@section('subtitle', 'Pilih sesi untuk mengisi kehadiran')
@section('content')
<div class="card"><h3>Daftar Sesi Kegiatan</h3><div class="tw"><table>
    <thead><tr><th>Tanggal</th><th>Ekskul</th><th>Kegiatan</th><th>Waktu</th><th>Presensi</th><th></th></tr></thead>
    <tbody>@forelse ($schedules as $s)
        <tr><td class="nm">{{ $s->date->translatedFormat('d M Y') }}</td><td>{{ $s->ekskul->name }}</td><td>{{ $s->title }}</td><td>{{ $s->timeRange() }}</td>
            <td>@if ($s->attendances_count)<span class="b b-ok">{{ $s->attendances_count }} tercatat</span>@else<span class="b b-warn">Belum diisi</span>@endif</td>
            <td><a class="btn btn-p btn-s" href="{{ route('pembina.presensi.edit', $s) }}">Isi / Ubah</a></td></tr>
    @empty<tr><td colspan="6" class="muted">Belum ada sesi. Admin membuat jadwal terlebih dahulu.</td></tr>@endforelse</tbody></table></div>
    <div class="mt">{{ $schedules->links('pagination.ekskul') }}</div></div>
@endsection
