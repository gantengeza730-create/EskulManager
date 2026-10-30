@extends('layouts.app')
@section('title', 'Data Pendaftar')
@section('subtitle', 'Tinjau dan setujui pendaftar ekskul')
@section('content')
<div class="pills"><a class="pill {{ !$status ? 'on' : '' }}" href="{{ route('pembina.pendaftar.index') }}">Semua</a>@foreach (['pending' => 'Menunggu', 'accepted' => 'Diterima', 'rejected' => 'Ditolak'] as $k => $l)<a class="pill {{ $status === $k ? 'on' : '' }}" href="?status={{ $k }}">{{ $l }}</a>@endforeach</div>
<div class="card"><div class="tw" style="min-height:120px"><table><thead><tr><th>Nama</th><th>Kelas</th><th>Ekskul</th><th>Alasan</th><th>Tanggal</th><th>Status</th><th></th></tr></thead><tbody>
@forelse ($rows as $r)
<tr><td class="nm">{{ $r->user->name }}</td><td>{{ $r->user->kelas }}</td><td>{{ $r->ekskul->name }}</td><td class="small muted" style="max-width:240px">{{ $r->reason }}</td><td>{{ $r->created_at->translatedFormat('d M Y') }}</td>
    <td>{!! \App\Support\Ui::statusBadge($r->status) !!}@if ($r->status === 'rejected' && $r->reject_reason)<div class="small muted" style="max-width:200px">{{ $r->reject_reason }}</div>@endif</td>
    <td style="white-space:nowrap">@if ($r->status === 'pending')
        <form method="POST" action="{{ route('pembina.pendaftar.update', $r) }}" style="display:inline">@csrf @method('PATCH')<input type="hidden" name="status" value="accepted"><button class="btn btn-p btn-s">Terima</button></form>
        <details class="tolak"><summary class="btn btn-o btn-s">Tolak</summary>
            <div class="pop"><form method="POST" action="{{ route('pembina.pendaftar.update', $r) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="rejected">
                <div class="f"><label class="req">Alasan penolakan (dikirim ke siswa)</label><textarea name="reject_reason" required minlength="5" style="min-height:70px"></textarea></div>
                <button class="btn btn-d btn-s btn-b">Tolak &amp; Kirim Notifikasi</button></form></div></details>
    @else<span class="faint small">Diproses</span>@endif</td></tr>
@empty<tr><td colspan="7" class="muted">Belum ada pendaftar.</td></tr>@endforelse</tbody></table></div>
<div class="mt">{{ $rows->links('pagination.ekskul') }}</div></div>
@endsection
