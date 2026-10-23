@extends('layouts.app')
@section('title', 'Ruangan & Tempat')
@section('subtitle', 'Master data tempat latihan untuk alokasi jadwal')
@section('content')
<div class="grid g21">
<div class="card"><h3>Daftar Ruangan</h3><div class="tw"><table><thead><tr><th>Nama</th><th>Kapasitas</th><th>Dipakai di</th><th></th></tr></thead><tbody>
    @forelse ($items as $r)<tr><td class="nm">{{ $r->name }}</td><td>{{ $r->capacity }} orang</td><td>{{ $r->schedules_count }} jadwal</td>
        <td style="white-space:nowrap"><a class="btn btn-o btn-s" href="{{ route('admin.ruangan.edit', $r) }}">Ubah</a>
        <form method="POST" action="{{ route('admin.ruangan.destroy', $r) }}" style="display:inline" onsubmit="return confirm('Hapus ruangan?')">@csrf @method('DELETE')<button class="btn btn-d btn-s">Hapus</button></form></td></tr>
    @empty<tr><td colspan="4" class="muted">Belum ada ruangan.</td></tr>@endforelse</tbody></table></div></div>
<div class="card"><h3>{{ $editing ? 'Ubah' : 'Tambah' }} Ruangan</h3>
<form method="POST" action="{{ $editing ? route('admin.ruangan.update', $editing) : route('admin.ruangan.store') }}">@csrf @if ($editing) @method('PUT') @endif
    <div class="f"><label>Nama</label><input name="name" value="{{ old('name', $editing?->name) }}" required></div>
    <div class="f"><label>Kapasitas</label><input type="number" min="1" name="capacity" value="{{ old('capacity', $editing?->capacity ?? 30) }}" required></div>
    <button class="btn btn-p btn-b">Simpan</button>@if ($editing)<a class="btn btn-o btn-b mt" href="{{ route('admin.ruangan.index') }}">Batal</a>@endif
</form></div></div>
@endsection
