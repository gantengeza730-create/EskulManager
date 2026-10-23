@extends('layouts.app')
@section('title', 'Penilaian')
@section('subtitle', 'Evaluasi kemampuan anggota ekskul')
@section('content')
@if (!$ekskul)<div class="card"><p class="muted" style="margin:0">Anda belum ditugaskan sebagai pembina ekskul manapun. Hubungi admin.</p></div>
@else
<div class="pills">@foreach ($mine as $e)<a class="pill {{ $e->id === $ekskul->id ? 'on' : '' }}" href="{{ route('pembina.penilaian.index', $e) }}">{{ $e->name }}</a>@endforeach</div>
<form method="POST" action="{{ route('pembina.penilaian.update', $ekskul) }}">@csrf @method('PUT')
<div class="card"><div class="ch"><h3>Penilaian {{ $ekskul->name }} (skala 0–100)</h3><button class="btn btn-p btn-s">Simpan Penilaian</button></div>
<div class="tw"><table><thead><tr><th>Nama</th><th>Teknik</th><th>Disiplin</th><th>Kerja Sama</th><th>Sikap</th><th>Catatan</th></tr></thead><tbody>
@forelse ($members as $m)
    @php $a = $scores[$m->id] ?? null; @endphp
    <tr><td class="nm">{{ $m->name }}<div class="small faint">{{ $m->kelas }}</div></td>
        @foreach (['technique', 'discipline', 'teamwork', 'attitude'] as $f)
            <td><input class="inp score" type="number" min="0" max="100" name="scores[{{ $m->id }}][{{ $f }}]" value="{{ old("scores.$m->id.$f", $a?->$f ?? 75) }}" required></td>
        @endforeach
        <td><input class="inp" style="min-width:200px" name="scores[{{ $m->id }}][notes]" value="{{ old("scores.$m->id.notes", $a?->notes) }}" placeholder="Catatan singkat..."></td></tr>
@empty<tr><td colspan="6" class="muted">Belum ada anggota.</td></tr>@endforelse
</tbody></table></div></div></form>
@endif
@endsection
