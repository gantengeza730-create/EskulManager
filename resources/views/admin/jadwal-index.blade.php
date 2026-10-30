@extends('layouts.app')
@section('title', 'Jadwal')
@section('subtitle', 'Manajemen jadwal & alokasi ruangan')
@section('content')
<div class="head"><div><h2>Jadwal Seluruh Ekskul</h2><p>Jadwal tetap berulang tiap minggu. Ruangan yang bentrok otomatis ditolak.</p></div><div style="display:flex;gap:8px"><a class="btn btn-o" href="{{ route('kalender.index') }}">Kalender</a><a class="btn btn-p" href="{{ route('admin.jadwal.create') }}">+ Buat Jadwal</a></div></div>
<div class="card">
    <form method="GET" class="filters">
        <div class="f"><label>Ekskul</label><select class="inp" name="ekskul" onchange="this.form.submit()"><option value="">Semua ekskul</option>@foreach ($ekskuls as $e)<option value="{{ $e->id }}" @selected($ekskulId == $e->id)>{{ $e->name }}</option>@endforeach</select></div>
        <div class="f"><label>Jenis jadwal</label><select class="inp" name="tipe" onchange="this.form.submit()"><option value="">Semua</option><option value="tetap" @selected($tipe === 'tetap')>Jadwal Tetap</option><option value="sekali" @selected($tipe === 'sekali')>Sekali (tidak berulang)</option></select></div></form>
    <div class="tw"><table><thead><tr><th>Tanggal</th><th>Ekskul</th><th>Kegiatan</th><th>Waktu</th><th>Ruangan</th><th>Status</th><th></th></tr></thead><tbody>
    @forelse ($items as $s)
    <tr><td class="nm">{{ $s->date->translatedFormat('D, d M Y') }}</td><td>{{ $s->ekskul->name }}</td><td>{{ $s->title }}<div class="small faint">{{ $s->typeLabel() }}</div></td><td>{{ $s->timeRange() }}</td><td>{{ $s->room?->name ?? '-' }}</td>
        <td>{!! \App\Support\Ui::statusBadge($s->displayStatus()) !!} {!! \App\Support\Ui::fixedBadge($s->is_fixed) !!}</td>
        <td style="white-space:nowrap"><a class="btn btn-o btn-s" href="{{ route('admin.jadwal.edit', $s) }}">Ubah</a>
            <form method="POST" action="{{ route('admin.jadwal.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Hapus jadwal ini?')">@csrf @method('DELETE')<button class="btn btn-d btn-s">Hapus</button></form>
            @if ($s->is_fixed && $s->series)<form method="POST" action="{{ route('admin.jadwal.destroy', $s) }}?seri=1" style="display:inline" onsubmit="return confirm('Hapus SELURUH jadwal tetap ini (semua minggu)?')">@csrf @method('DELETE')<button class="btn btn-d btn-s" title="Hapus semua sesi dalam rangkaian ini">Hapus Seri</button></form>@endif</td></tr>
    @empty<tr><td colspan="7" class="muted">Belum ada jadwal.</td></tr>@endforelse</tbody></table></div>
    <div class="mt">{{ $items->links('pagination.ekskul') }}</div></div>
@endsection
