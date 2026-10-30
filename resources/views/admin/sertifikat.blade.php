@extends('layouts.app')
@section('title', 'Sertifikat')
@section('subtitle', 'Generate piagam / sertifikat keikutsertaan')
@section('content')
<div class="grid g21">
<div class="card"><h3>Sertifikat Diterbitkan</h3><div class="tw"><table><thead><tr><th>Penerima</th><th>Ekskul</th><th>Judul</th><th>No.</th><th></th></tr></thead><tbody>
    @forelse ($items as $c)<tr><td class="nm">{{ $c->user->name }}</td><td>{{ $c->ekskul->name }}</td><td>{{ $c->title }}<div class="small faint">{{ $c->issued_at->translatedFormat('d M Y') }}</div></td><td class="small">{{ $c->number }}</td>
        <td style="white-space:nowrap"><a class="btn btn-o btn-s" target="_blank" href="{{ route('sertifikat.cetak', $c) }}">Cetak</a><form method="POST" action="{{ route('admin.sertifikat.destroy', $c) }}" style="display:inline" onsubmit="return confirm('Hapus sertifikat?')">@csrf @method('DELETE')<button class="btn btn-d btn-s">Hapus</button></form></td></tr>
    @empty<tr><td colspan="5" class="muted">Belum ada sertifikat.</td></tr>@endforelse</tbody></table></div><div class="mt">{{ $items->links('pagination.ekskul') }}</div></div>
<div class="card"><h3>Terbitkan Sertifikat</h3>
<form method="POST" action="{{ route('admin.sertifikat.store') }}">@csrf
    <div class="f"><label class="req">Ekskul</label><select name="ekskul_id" id="ekSel" required>@foreach ($ekskuls as $e)<option value="{{ $e->id }}">{{ $e->name }}</option>@endforeach</select></div>
    <div class="f"><label class="req">Penerima</label><select name="user_id" id="userSel" required><option value="all">Seluruh anggota ekskul</option></select></div>
    <div class="f"><label class="req">Judul Sertifikat</label><input name="title" value="Sertifikat Keikutsertaan" required></div>
    <div class="f"><label class="req">Tanggal Terbit</label><input type="date" name="issued_at" value="{{ now()->format('Y-m-d') }}" required></div>
    <p class="small muted">Nama kepala sekolah pada sertifikat diambil dari <a href="{{ route('admin.sekolah.edit') }}">Pengaturan Sekolah</a>: <b>{{ $school->principal() }}</b>.</p>
    <button class="btn btn-p btn-b">Generate Sertifikat</button></form></div></div>
@endsection
@push('scripts')<script>
const members=@json($ekskuls->mapWithKeys(fn ($e) => [$e->id => $e->members->map(fn ($m) => ['id' => $m->id, 'name' => $m->name])->values()]));
const ek=document.getElementById('ekSel'),us=document.getElementById('userSel');
function fill(){us.innerHTML='<option value="all">Seluruh anggota ekskul</option>'+(members[ek.value]||[]).map(m=>`<option value="${m.id}">${m.name}</option>`).join('');}
ek.addEventListener('change',fill);fill();
</script>@endpush
