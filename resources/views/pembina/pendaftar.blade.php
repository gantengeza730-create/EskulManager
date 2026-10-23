@extends('layouts.app')
@section('title', 'Data Pendaftar')
@section('subtitle', 'Tinjau dan setujui pendaftar ekskul')
@section('content')
<div class="pills">
    <a class="pill {{ !$status ? 'on' : '' }}" href="{{ route('pembina.pendaftar.index') }}">Semua</a>
    @foreach (['pending' => 'Menunggu', 'accepted' => 'Diterima', 'rejected' => 'Ditolak'] as $k => $l)<a class="pill {{ $status === $k ? 'on' : '' }}" href="?status={{ $k }}">{{ $l }}</a>@endforeach
</div>
<div class="card"><div class="tw"><table>
    <thead><tr><th>Nama</th><th>Kelas</th><th>Ekskul</th><th>Alasan</th><th>Tanggal</th><th>Status</th><th></th></tr></thead>
    <tbody>@forelse ($rows as $r)
        <tr><td class="nm">{{ $r->user->name }}</td><td>{{ $r->user->kelas }}</td><td>{{ $r->ekskul->name }}</td><td class="small muted" style="max-width:260px">{{ $r->reason }}</td><td>{{ $r->created_at->translatedFormat('d M Y') }}</td><td>{!! \App\Support\Ui::statusBadge($r->status) !!}</td>
            <td style="white-space:nowrap">@if ($r->status === 'pending')
                <form method="POST" action="{{ route('pembina.pendaftar.update', $r) }}" style="display:inline">@csrf @method('PATCH')<input type="hidden" name="status" value="accepted"><button class="btn btn-p btn-s">Terima</button></form>
                <form method="POST" action="{{ route('pembina.pendaftar.update', $r) }}" style="display:inline">@csrf @method('PATCH')<input type="hidden" name="status" value="rejected"><button class="btn btn-o btn-s">Tolak</button></form>
            @else<span class="faint small">Diproses</span>@endif</td></tr>
    @empty<tr><td colspan="7" class="muted">Belum ada pendaftar.</td></tr>@endforelse</tbody></table></div>
    <div class="mt">{{ $rows->links('pagination.ekskul') }}</div></div>
@endsection
