@extends('layouts.app')
@section('title', 'Formulir Pendaftaran')
@section('subtitle', $ekskul->name)
@section('content')
<div class="card" style="max-width:620px">
    <h3>Formulir Pendaftaran — {{ $ekskul->name }}</h3>
    @if ($existing)
        <p>Anda sudah mendaftar ke ekskul ini. Status: {!! \App\Support\Ui::statusBadge($existing->status) !!}</p>
        <a class="btn btn-o" href="{{ route('siswa.ekskul.index') }}">Kembali</a>
    @else
    <div class="kv" style="margin-bottom:18px">
        <div><span>Nama</span><span>{{ auth()->user()->name }}</span></div>
        <div><span>Kelas</span><span>{{ auth()->user()->kelas }}</span></div>
        <div><span>Jadwal</span><span>{{ $ekskul->schedule_text }}</span></div>
        <div><span>Sisa kuota</span><span>{{ max(0, $ekskul->quota - $ekskul->memberCount()) }} kursi</span></div>
    </div>
    @if ($ekskul->requirementList())<div class="note"><b>Syarat:</b><br>@foreach ($ekskul->requirementList() as $r)• {{ $r }}<br>@endforeach</div>@endif
    <form method="POST" action="{{ route('siswa.ekskul.daftar', $ekskul) }}">@csrf
        <div class="f"><label>Alasan Mendaftar</label><textarea name="reason" required minlength="10" placeholder="Ceritakan motivasimu bergabung...">{{ old('reason') }}</textarea></div>
        <label class="small" style="display:flex;gap:8px;margin-bottom:16px"><input type="checkbox" name="agree" value="1" required> Saya memenuhi syarat dan telah mendapat persetujuan orang tua/wali.</label>
        <div style="display:flex;gap:10px"><a class="btn btn-o" href="{{ route('siswa.ekskul.index') }}">Batal</a><button class="btn btn-p">Kirim Pendaftaran</button></div>
    </form>
    @endif
</div>
@endsection
