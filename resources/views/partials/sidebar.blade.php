@php
    $u = auth()->user();
    $menus = match ($u->role) {
        'admin' => [
            ['admin.dashboard', '▦', 'Dashboard'], '-',
            ['admin.ekskul.index', '★', 'Manajemen Ekskul', 'admin.ekskul.*'],
            ['admin.pengguna.index', '☺', 'Manajemen Pengguna', 'admin.pengguna.*'],
            ['admin.ruangan.index', '⌂', 'Ruangan & Tempat', 'admin.ruangan.*'],
            ['admin.jadwal.index', '▤', 'Jadwal', 'admin.jadwal.*'],
            ['kalender.index', '▥', 'Kalender Terintegrasi'], '-',
            ['admin.laporan', '≣', 'Laporan & Rekap', 'admin.laporan*'],
            ['admin.sertifikat.index', '✪', 'Sertifikat', 'admin.sertifikat.*'],
            ['pengumuman.index', '✉', 'Pengumuman & Berita'],
            ['galeri.index', '▣', 'Galeri & Dokumentasi'], '-',
            ['admin.sekolah.edit', '⚙', 'Pengaturan Sekolah'],
            ['notifikasi.index', '🔔', 'Notifikasi'], ['profil.edit', '☺', 'Profil Saya'],
        ],
        'pembina' => [
            ['pembina.dashboard', '▦', 'Dashboard'], '-',
            ['pembina.pendaftar.index', '✎', 'Data Pendaftar', 'pembina.pendaftar.*'],
            ['pembina.presensi.index', '✔', 'Presensi', 'pembina.presensi.*'],
            ['pembina.penilaian.index', '☆', 'Penilaian', 'pembina.penilaian.*'],
            ['jadwal.index', '▤', 'Jadwal Latihan'], ['kalender.index', '▥', 'Kalender'],
            ['pembina.laporan', '≣', 'Laporan'], '-',
            ['pengumuman.index', '✉', 'Pengumuman & Berita'], ['galeri.index', '▣', 'Galeri & Dokumentasi'], '-',
            ['notifikasi.index', '🔔', 'Notifikasi'], ['profil.edit', '☺', 'Profil'],
        ],
        default => [
            ['siswa.dashboard', '▦', 'Dashboard'], '-',
            ['siswa.ekskul.index', '★', 'Ekstrakurikuler', 'siswa.ekskul.*'],
            ['jadwal.index', '▤', 'Jadwal Kegiatan'], ['kalender.index', '▥', 'Kalender'],
            ['siswa.presensi', '✔', 'Presensi'], ['siswa.nilai', '☆', 'Nilai & Evaluasi'], ['siswa.sertifikat', '✪', 'Sertifikat'], '-',
            ['pengumuman.index', '✉', 'Pengumuman & Berita'], ['galeri.index', '▣', 'Galeri'], '-',
            ['notifikasi.index', '🔔', 'Notifikasi'], ['profil.edit', '☺', 'Profil Saya'],
        ],
    };
@endphp
<aside class="sidebar" id="sidebar">
    <div class="sidebar-stars" id="sidebarStars"></div>
    <div class="brand">@include('partials.brand')<div>Ekskul SMK<small>{{ $u->roleLabel() }}</small></div></div>
    <nav class="nav">
        @foreach ($menus as $m)
            @if ($m === '-') <hr>
            @else
                <a href="{{ route($m[0]) }}" class="{{ request()->routeIs($m[3] ?? $m[0]) ? 'active' : '' }}"><span class="ico">{{ $m[1] }}</span> {{ $m[2] }}
                    @if ($m[0] === 'notifikasi.index' && ($c = $u->unreadCount()) > 0)<span class="badge-n">{{ $c }}</span>@endif</a>
            @endif
        @endforeach
    </nav>
    <div class="side-foot"><div class="ava">{{ $u->initials() }}</div><div class="who">{{ \Illuminate\Support\Str::limit($u->name, 18) }}<small>{{ $u->roleLabel() }}</small></div>@include('partials.logout')</div>
</aside>
