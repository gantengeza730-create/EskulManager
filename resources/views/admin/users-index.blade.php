@extends('layouts.app')
@section('title', 'Manajemen Pengguna')
@section('subtitle', 'Kelola akun siswa, pembina, dan admin')
@section('content')
<div class="head"><div><h2>Data Pengguna</h2><p>Admin mengelola akun siswa & pembina.</p></div><a class="btn btn-p" href="{{ route('admin.pengguna.create') }}">+ Tambah Pengguna</a></div>
<div class="card">
    <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:16px">
        <input class="inp" style="max-width:280px" name="cari" value="{{ $q }}" placeholder="Cari nama / email / NIS...">
        <select class="inp" style="max-width:180px" name="peran" onchange="this.form.submit()"><option value="">Semua peran</option>@foreach (['siswa' => 'Siswa', 'pembina' => 'Pembina', 'admin' => 'Admin'] as $k => $l)<option value="{{ $k }}" @selected($role === $k)>{{ $l }}</option>@endforeach</select>
        <button class="btn btn-o">Cari</button></form>
    <div class="tw"><table><thead><tr><th>Nama</th><th>Peran</th><th>Kelas/NIS</th><th>Status</th><th></th></tr></thead><tbody>
    @foreach ($items as $u)
        <tr><td><div class="nm">{{ $u->name }}</div><div class="small faint">{{ $u->email }}</div></td>
            <td><span class="b {{ $u->role === 'admin' ? 'b-pur' : ($u->role === 'pembina' ? 'b-warn' : 'b-info') }}">{{ $u->roleLabel() }}</span></td>
            <td>{{ $u->kelas ?: '-' }}<div class="small faint">{{ $u->nis }}</div></td>
            <td>{!! $u->is_active ? '<span class="b b-ok">Aktif</span>' : '<span class="b b-bad">Nonaktif</span>' !!}{!! $u->email_verified_at ? '' : ' <span class="b b-warn">Belum verifikasi</span>' !!}</td>
            <td style="white-space:nowrap"><a class="btn btn-o btn-s" href="{{ route('admin.pengguna.edit', $u) }}">Ubah</a>
                @if ($u->id !== auth()->id())<form method="POST" action="{{ route('admin.pengguna.destroy', $u) }}" style="display:inline" onsubmit="return confirm('Hapus pengguna ini?')">@csrf @method('DELETE')<button class="btn btn-d btn-s">Hapus</button></form>@endif</td></tr>
    @endforeach</tbody></table></div>
    <div class="mt">{{ $items->links('pagination.ekskul') }}</div></div>
@endsection
