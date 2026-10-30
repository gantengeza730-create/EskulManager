@extends('layouts.app')
@section('title', 'Profil')
@section('subtitle', 'Data diri dan keamanan akun')
@section('content')
<div class="grid g21"><div class="card"><h3>Data Diri</h3>
<form method="POST" action="{{ route('profil.update') }}">@csrf @method('PUT')
    <div class="frow"><div class="f"><label class="req">Nama Lengkap</label><input name="name" value="{{ old('name', $user->name) }}" required></div><div class="f"><label class="req">No. Telepon</label><input name="phone" value="{{ old('phone', $user->phone) }}" required></div></div>
    <div class="frow"><div class="f"><label>Email</label><input value="{{ $user->email }}" disabled></div>
        <div class="f"><label class="{{ $user->isSiswa() ? 'req' : '' }}">{{ $user->isSiswa() ? 'Kelas' : 'NIS/NIP' }}</label>@if ($user->isSiswa())<input name="kelas" value="{{ old('kelas', $user->kelas) }}" required>@else<input value="{{ $user->nis ?? '-' }}" disabled>@endif</div></div>
    <div class="frow"><div class="f"><label>Kata Sandi Baru (kosongkan jika tidak diganti)</label><input type="password" name="password" minlength="8"></div><div class="f"><label>Ulangi Kata Sandi</label><input type="password" name="password_confirmation"></div></div>
    <button class="btn btn-p">Simpan Perubahan</button></form></div>
<div class="card"><h3>Akun</h3><div class="kv"><div><span>Peran</span><span>{{ $user->roleLabel() }}</span></div><div><span>Status</span><span>{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span></div><div><span>Terverifikasi</span><span>{{ $user->email_verified_at?->translatedFormat('d M Y') ?? '-' }}</span></div></div></div></div>
@endsection
