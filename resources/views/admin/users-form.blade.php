@extends('layouts.app')
@section('title', $user->exists ? 'Ubah Pengguna' : 'Tambah Pengguna')
@section('content')
<div class="card" style="max-width:640px"><h3>{{ $user->exists ? 'Ubah' : 'Tambah' }} Pengguna</h3>
<form method="POST" action="{{ $user->exists ? route('admin.pengguna.update', $user) : route('admin.pengguna.store') }}">@csrf @if ($user->exists) @method('PUT') @endif
    <div class="frow"><div class="f"><label>Nama Lengkap</label><input name="name" value="{{ old('name', $user->name) }}" required></div>
        <div class="f"><label>Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required></div></div>
    <div class="frow"><div class="f"><label>Peran</label><select name="role">@foreach (['siswa' => 'Siswa', 'pembina' => 'Pembina Ekskul', 'admin' => 'Admin'] as $k => $l)<option value="{{ $k }}" @selected(old('role', $user->role) === $k)>{{ $l }}</option>@endforeach</select></div>
        <div class="f"><label>NIS / NIP</label><input name="nis" value="{{ old('nis', $user->nis) }}"></div></div>
    <div class="frow"><div class="f"><label>Kelas (siswa)</label><input name="kelas" value="{{ old('kelas', $user->kelas) }}"></div><div class="f"><label>No. HP</label><input name="phone" value="{{ old('phone', $user->phone) }}"></div></div>
    <div class="f"><label>Kata Sandi {{ $user->exists ? '(kosongkan jika tidak diganti)' : '' }}</label><input type="password" name="password" {{ $user->exists ? '' : 'required' }}></div>
    <label class="small" style="display:flex;gap:8px;margin-bottom:16px"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active)) style="width:auto"> Akun aktif</label>
    <div style="display:flex;gap:10px"><a class="btn btn-o" href="{{ route('admin.pengguna.index') }}">Batal</a><button class="btn btn-p">Simpan</button></div>
</form></div>
@endsection
