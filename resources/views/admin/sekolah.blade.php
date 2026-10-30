@extends('layouts.app')
@section('title', 'Pengaturan Sekolah')
@section('subtitle', 'Identitas sekolah, kepala sekolah, dan logo')
@section('content')
<div class="grid g21"><div class="card"><h3>Identitas Sekolah <span class="small muted">(semua kolom wajib diisi)</span></h3>
<form method="POST" action="{{ route('admin.sekolah.update') }}" enctype="multipart/form-data">@csrf @method('PUT')
    <div class="f"><label class="req">Nama Sekolah</label><input name="school_name" value="{{ old('school_name', $school->name()) }}" required></div>
    <div class="f"><label class="req">Alamat Sekolah</label><input name="school_address" value="{{ old('school_address', $school->address()) }}" required></div>
    <div class="frow"><div class="f"><label class="req">Nama Kepala Sekolah</label><input name="principal_name" value="{{ old('principal_name', $school->principal()) }}" required></div><div class="f"><label class="req">NIP Kepala Sekolah</label><input name="principal_nip" value="{{ old('principal_nip', $school->principalNip()) }}" required></div></div>
    <div class="frow"><div class="f"><label class="req">Batas "Ekskul Besar" (jumlah anggota)</label><input type="number" min="1" name="ekskul_besar_min" value="{{ old('ekskul_besar_min', $school->bigMin()) }}" required></div><div class="f"><label>Logo sekolah (opsional, maks 2 MB)</label><input type="file" name="school_logo" accept="image/*"></div></div>
    <button class="btn btn-p">Simpan Pengaturan</button></form></div>
<div class="card"><h3>Pratinjau</h3>@if ($school->logo())<img src="{{ $school->logo() }}" alt="Logo" style="height:64px;margin-bottom:10px">@endif
    <div class="kv"><div><span>Sekolah</span><span>{{ $school->name() }}</span></div><div><span>Kepala Sekolah</span><span>{{ $school->principal() }}</span></div><div><span>NIP</span><span>{{ $school->principalNip() }}</span></div><div><span>Ekskul besar</span><span>≥ {{ $school->bigMin() }} anggota</span></div></div>
    <p class="small muted mt">Nama ini dipakai di landing page, sertifikat, dan cetak laporan.</p></div></div>
@endsection
