@extends('layouts.app')
@section('title', 'Pusat Kendali Admin')
@section('subtitle', 'Monitoring global sistem ekstrakurikuler')
@section('content')
<div class="head"><div><h2>Pusat Kendali Admin</h2><p>Monitoring seluruh ekskul, siswa, dan pembina di sekolah.</p></div><a class="btn btn-p" href="{{ route('admin.ekskul.create') }}">+ Tambah Cabang Ekskul</a></div>
<div class="grid g4" style="margin-bottom:16px">
    <div class="card stat"><div class="l">Total Siswa</div><div class="v">{{ $stats['siswa'] }}</div><div class="s">Akun siswa terdaftar</div></div>
    <div class="card stat"><div class="l">Ekstrakurikuler</div><div class="v">{{ $stats['ekskul'] }}</div><div class="s">Cabang aktif</div></div>
    <div class="card stat"><div class="l">Pembina/Guru</div><div class="v">{{ $stats['pembina'] }}</div><div class="s">Terdaftar membimbing</div></div>
    <div class="card stat"><div class="l">Sertifikat</div><div class="v">{{ $stats['sertifikat'] }}</div><div class="s">Kehadiran rata-rata {{ $stats['attPct'] !== null ? $stats['attPct'].'%' : '–' }}</div></div>
</div>
<div class="grid g21">
    <div style="display:flex;flex-direction:column;gap:16px">
        <div class="card"><h3>Popularitas Ekstrakurikuler (Jumlah Anggota)</h3>
            @foreach ($popularity as $p)
                <div style="margin-bottom:12px"><div style="display:flex;justify-content:space-between;font-size:13px;font-weight:700"><span>{{ $p->name }}</span><span>{{ $p->members_count }}</span></div>
                    <div class="bar"><span style="width:{{ $p->members_count / $maxMembers * 100 }}%;background:{{ $p->color }}"></span></div></div>
            @endforeach
        </div>
        <div class="card"><h3>Pendaftaran Terbaru</h3><div class="tw"><table><thead><tr><th>Nama</th><th>Ekskul</th><th>Waktu</th><th>Status</th></tr></thead><tbody>
            @forelse ($recent as $r)<tr><td class="nm">{{ $r->user->name }}</td><td>{{ $r->ekskul->name }}</td><td class="muted small">{{ $r->created_at->diffForHumans() }}</td><td>{!! \App\Support\Ui::statusBadge($r->status) !!}</td></tr>@empty<tr><td colspan="4" class="muted">Belum ada pendaftaran.</td></tr>@endforelse
        </tbody></table></div></div>
    </div>
    <div style="display:flex;flex-direction:column;gap:16px">
        <div class="card"><h3>Menu Operasional Admin</h3><div style="display:flex;flex-direction:column;gap:8px">
            <a class="btn btn-p" href="{{ route('admin.ekskul.create') }}">+ Tambah Cabang Ekskul</a>
            <a class="btn btn-o" href="{{ route('admin.pengguna.create') }}">Tambah Pengguna</a>
            <a class="btn btn-o" href="{{ route('admin.jadwal.create') }}">Buat Jadwal Baru</a>
            <a class="btn btn-o" href="{{ route('admin.sertifikat.index') }}">Terbitkan Sertifikat</a></div></div>
        <div class="card"><h3>Jadwal Terdekat</h3>
            @forelse ($upcoming as $s)<div class="li"><div class="d">{{ $s->date->format('d') }}<small>{{ $s->date->translatedFormat('M') }}</small></div><div><div class="nm">{{ $s->title }}</div><div class="muted small">{{ $s->ekskul->name }} · {{ $s->timeRange() }} · {{ $s->room?->name ?? '-' }}</div></div></div>@empty<p class="muted">Belum ada jadwal.</p>@endforelse</div>
    </div>
</div>
@endsection
