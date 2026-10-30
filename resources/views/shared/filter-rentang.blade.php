{{-- Filter rentang tanggal laporan: hari ini s.d. 1 bulan, atau tanggal bebas --}}
<div class="pills">
    @foreach (\App\Support\ReportRange::PRESETS as $k => $l)<a class="pill {{ $key === (string) $k ? 'on' : '' }}" href="{{ route($route, ['rentang' => $k]) }}">{{ $l }}</a>@endforeach
</div>
<form method="GET" action="{{ route($route) }}" class="filters">
    <div class="f"><label>Dari tanggal</label><input class="inp" type="date" name="dari" value="{{ $key === 'custom' ? $from->toDateString() : '' }}" required></div>
    <div class="f"><label>Sampai tanggal</label><input class="inp" type="date" name="sampai" value="{{ $key === 'custom' ? $to->toDateString() : '' }}" required></div>
    <button class="btn btn-p">Terapkan Rentang</button>
</form>
