@extends('layouts.app')
@section('title', 'Laporan & Rekap')
@section('subtitle', 'Rekap kegiatan dan presensi seluruh ekskul')

@section('content')

<!-- bandaid solution -->
<style>
    .tw table {
        width: 100%;
        border-collapse: collapse;
    }

    .tw th,
    .tw td {
        border: 1px solid var(--border, #ddd);
        padding: 10px 12px;
        text-align: left;
    }

    .tw thead th {
        border-bottom: 2px solid var(--border, #ddd);
    }

    .tw tbody tr:last-child td {
        border-bottom: 1px solid var(--border, #ddd);
    }
</style>

@include('partials.print-header', [
    'title' => 'Laporan Kegiatan & Rekap Presensi Ekstrakurikuler',
    'subtitle' => 'Periode ' . $label
])

<div class="no-print">
    <div class="head">
        <div>
            <h2>Laporan Kegiatan & Rekap Presensi</h2>
            <p>Lihat kehadiran dari 1 hari sampai 1 bulan, atau pilih tanggal sendiri.</p>
        </div>

        <div style="display:flex;gap:8px">
            <button class="btn btn-o" onclick="window.print()">🖨 Cetak</button>
            <a class="btn btn-p" href="{{ route('admin.laporan.ekspor', request()->query()) }}">
                Unduh CSV (Excel)
            </a>
        </div>
    </div>

    @include('shared.filter-rentang', [
        'route' => 'admin.laporan',
        'key' => $key,
        'from' => $from,
        'to' => $to
    ])

    <p class="muted small">
        Periode: <b>{{ $label }}</b> ·
        "Sesi berlangsung" hanya menghitung sesi yang sudah terjadi pada rentang ini,
        bukan seluruh jadwal tetap.
    </p>
</div>

<div class="card">
    <div class="tw">
        <table>
            <thead>
                <tr>
                    <th>Ekskul</th>
                    <th>Pembina</th>
                    <th>Anggota</th>
                    <th>Sesi Berlangsung</th>
                    <th>Catatan Presensi</th>
                    <th>Kehadiran</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($rows as $r)
                    <tr>
                        <td class="nm">{{ $r['name'] }}</td>
                        <td>{{ $r['pembina'] }}</td>
                        <td>{{ $r['members'] }}</td>
                        <td>{{ $r['sessions'] }}</td>
                        <td>{{ $r['hadir'] }}/{{ $r['records'] }} hadir</td>
                        <td>
                            {{ $r['pct'] !== null ? $r['pct'] . '%' : '–' }}
                            {!! \App\Support\Ui::bar($r['pct']) !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="muted">
                            Tidak ada data pada rentang ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('partials.print-sign', [
    'leftTitle' => 'Admin',
    'leftName' => auth()->user()->name
])

@endsection