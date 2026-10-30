@extends('layouts.app')
@section('title', 'Manajemen Ekskul')
@section('subtitle', 'Master data ekstrakurikuler')
@section('content')
<div class="head"><div><h2>Master Data Ekstrakurikuler</h2><p>Ekskul diurutkan dari anggota terbanyak. Ekskul bertanda ★ mencapai batas "ekskul besar" ({{ $school->bigMin() }} anggota, bisa diubah di Pengaturan Sekolah).</p></div><a class="btn btn-p" href="{{ route('admin.ekskul.create') }}">+ Tambah Ekskul</a></div>
<div class="card"><div class="tw"><table><thead><tr><th>Ekskul</th><th>Kategori</th><th>Pembina</th><th>Anggota</th><th>Status</th><th></th></tr></thead><tbody>
@forelse ($items as $e)
<tr><td><div class="nm"><i style="display:inline-block;width:10px;height:10px;border-radius:50%;background:{{ $e->color }};margin-right:6px"></i>{{ $e->name }} {!! \App\Support\Ui::bigBadge($e->isBig($e->members_count)) !!}</div><div class="small faint">{{ $e->schedule_text }}</div></td>
    <td>{{ $e->category }}</td><td>{{ $e->pembina?->name ?? '—' }}</td><td>{{ $e->members_count }}/{{ $e->quota }}{!! \App\Support\Ui::bar((int) round($e->members_count / max(1, $e->quota) * 100)) !!}</td>
    <td>{!! $e->is_active ? '<span class="b b-ok">Aktif</span>' : '<span class="b b-bad">Nonaktif</span>' !!}</td>
    <td style="white-space:nowrap"><a class="btn btn-o btn-s" href="{{ route('admin.ekskul.edit', $e) }}">Ubah</a>
        <form method="POST" action="{{ route('admin.ekskul.destroy', $e) }}" style="display:inline" onsubmit="return confirm('Hapus ekskul beserta seluruh data terkait?')">@csrf @method('DELETE')<button class="btn btn-d btn-s">Hapus</button></form></td></tr>
@empty<tr><td colspan="6" class="muted">Belum ada ekskul.</td></tr>@endforelse</tbody></table></div></div>
@endsection
