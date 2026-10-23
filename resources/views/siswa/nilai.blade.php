@extends('layouts.app')
@section('title', 'Nilai & Evaluasi')
@section('subtitle', 'Penilaian kemampuan dari pembina')
@section('content')
@forelse ($items as $a)
    <div class="card" style="margin-bottom:16px">
        <div class="ch"><h3>{{ $a->ekskul->name }}</h3><span class="b b-info">Rata-rata {{ $a->average() }}</span></div>
        <div class="grid g2">
            @foreach (['technique' => 'Teknik', 'discipline' => 'Disiplin', 'teamwork' => 'Kerja Sama Tim', 'attitude' => 'Sikap & Sportivitas'] as $k => $label)
                <div><div style="display:flex;justify-content:space-between;font-size:13px;font-weight:700"><span>{{ $label }}</span><span>{{ $a->$k }}</span></div>{!! \App\Support\Ui::bar($a->$k) !!}</div>
            @endforeach
        </div>
        @if ($a->notes)<p class="muted mt" style="margin-bottom:0"><b>Catatan pembina:</b> {{ $a->notes }}</p>@endif
        <p class="faint small" style="margin-bottom:0">Diperbarui {{ $a->updated_at->translatedFormat('d M Y') }}</p>
    </div>
@empty
    <div class="card"><p class="muted" style="margin:0">Pembina belum memberikan penilaian.</p></div>
@endforelse
@endsection
