<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Eskul SMK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans antialiased flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#111c33] text-gray-300 flex flex-col justify-between hidden md:flex shrink-0">
        <div>
            <!-- Logo Brand -->
            <div class="px-6 py-6 flex items-center gap-3 border-b border-gray-800">
                <div class="bg-blue-600 text-white p-2 rounded-lg font-bold text-lg"><i class="fa-solid fa-shield-halved"></i></div>
                <div>
                    <h1 class="text-white font-bold text-lg tracking-wide">Eskul SMK</h1>
                </div>
            </div>

            <!-- Menu Navigasi Guru (Lengkap) -->
            <nav class="px-4 py-4 space-y-1 text-sm max-h-[calc(100vh-180px)] overflow-y-auto">
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-blue-600 text-white rounded-xl font-medium shadow-lg shadow-blue-600/30">
                    <i class="fa-solid fa-grid-2"></i> Dashboard
                </a>
                <a href="#" class="flex items-center justify-between px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <span class="flex items-center gap-3"><i class="fa-solid fa-users-viewfinder"></i> Ekstrakurikuler Saya</span>
                    <span class="bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full font-bold">1</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-user-group"></i> Anggota
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-calendar-days"></i> Jadwal Latihan
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-clipboard-user"></i> Kehadiran
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-award"></i> Penilaian & Rapor
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-chart-pie"></i> Laporan Kegiatan
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-bullhorn"></i> Buat Pengumuman
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-file-certificate"></i> Permintaan Sertifikat
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-images"></i> Galeri Dokumentasi
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-user"></i> Profil Pembina
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-gear"></i> Pengaturan
                </a>
            </nav>
        </div>

        <!-- Profil User di Sidebar Bawah & Tombol Logout -->
        <div class="p-4 border-t border-gray-800 flex items-center justify-between bg-[#0e1628]">
            <div class="flex items-center gap-3">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100" class="w-10 h-10 rounded-full object-cover border border-gray-700" alt="Avatar">
                <div>
                    <h4 class="text-white text-sm font-semibold"><?php echo e($user->name ?? 'Pak Nur'); ?></h4>
                    <p class="text-xs text-blue-400">Pembina Futsal</p>
                </div>
            </div>
            <!-- Form Logout -->
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="text-gray-400 hover:text-red-400 transition p-2" title="Keluar">
                    <i class="fa-solid fa-right-from-bracket text-lg"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        
        <!-- Header Atas -->
        <header class="bg-white px-8 py-4 border-b border-gray-200 flex justify-between items-center sticky top-0 z-10">
            <div class="text-xs text-gray-400 font-semibold tracking-wider uppercase">
                05 — Teacher Dashboard
            </div>
            <div class="flex items-center gap-4">
                <!-- Search Bar -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" placeholder="Cari data siswa atau jadwal..." class="bg-gray-50 border border-gray-200 rounded-full pl-9 pr-4 py-1.5 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">
                </div>
                <!-- Notifikasi -->
                <button class="w-9 h-9 rounded-full bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition relative">
                    <span class="absolute top-2 right-2 w-2 h-2 bg-blue-600 rounded-full"></span>
                    <i class="fa-regular fa-bell text-sm"></i>
                </button>
                <!-- Avatar Kanan -->
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100" class="w-9 h-9 rounded-full object-cover" alt="User">
            </div>
        </header>

        <!-- Bagian Isi Halaman -->
        <div class="p-8 space-y-6">

            <!-- Banner Sambutan -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 rounded-2xl border border-gray-200 shadow-sm gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang, <?php echo e($user->name ?? 'Pak Nur'); ?></h2>
                        <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full font-medium">Pembina Futsal</span>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Rabu, 18 Maret 2026 • Kelola kegiatan latihan dan rekap kehadiran hari ini</p>
                </div>
                <div class="flex gap-2">
                    <button class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-4 py-2 rounded-xl text-sm font-semibold transition flex items-center gap-2">
                        <i class="fa-solid fa-print text-xs"></i> Cetak Rekap
                    </button>
                </div>
            </div>

            <!-- Grid 4 Kartu Statistik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Card 1 -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Anggota Aktif</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">45 Siswa</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-3">Siswa aktif terdaftar</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Rata-rata Kehadiran</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">92%</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                    </div>
                    <p class="text-xs text-emerald-600 font-medium mt-3">+2.4% dari bulan lalu</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Jadwal Bulan Ini</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">8 Sesi</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-3">4 latihan, 4 uji tanding</p>
                </div>
                <!-- Card 4 -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Prestasi</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">3 Piala</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                            <i class="fa-solid fa-award"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-3">Tahun ajaran genap ini</p>
                </div>
            </div>

            <!-- Layout Tengah (Grafik & Aksi Cepat) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Grafik Tren Kehadiran (Lebar 2) -->
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-gray-900 text-base">Tren Kehadiran Latihan Futsal (%)</h3>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block"></span> Kehadiran
                        </div>
                    </div>
                    <!-- Simulasi Bar Chart -->
                    <div class="h-48 flex items-end justify-between gap-2 px-4 pt-6 border-b border-gray-100">
                        <div class="w-full bg-gray-100 rounded-t-lg h-[50%] flex flex-col justify-end items-center pb-2"></div>
                        <div class="w-full bg-gray-100 rounded-t-lg h-[65%] flex flex-col justify-end items-center pb-2"></div>
                        <div class="w-full bg-gray-100 rounded-t-lg h-[55%] flex flex-col justify-end items-center pb-2"></div>
                        <div class="w-full bg-gray-100 rounded-t-lg h-[75%] flex flex-col justify-end items-center pb-2"></div>
                        <div class="w-full bg-gray-100 rounded-t-lg h-[60%] flex flex-col justify-end items-center pb-2"></div>
                        <div class="w-full bg-blue-600 rounded-t-lg h-[90%] flex flex-col justify-end items-center pb-2 shadow-md shadow-blue-500/20"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-400 pt-3 px-2">
                        <span>Sesi 1</span>
                        <span>Sesi 2</span>
                        <span>Sesi 3</span>
                        <span>Sesi 4</span>
                        <span>Sesi 5</span>
                        <span>Sesi 6</span>
                    </div>
                </div>

                <!-- Kolom Kanan (Aksi Cepat & Jadwal Terdekat) -->
                <div class="space-y-6">
                    <!-- Aksi Cepat Pembina -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                        <h3 class="font-bold text-gray-900 text-base mb-4">Aksi Cepat Pembina</h3>
                        <div class="space-y-3">
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-xl text-sm font-medium flex items-center gap-3 transition shadow-md shadow-blue-600/20">
                                <i class="fa-solid fa-plus text-xs"></i> Buat Jadwal Baru
                            </button>
                            <button class="w-full bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 py-2.5 px-4 rounded-xl text-sm font-medium flex items-center gap-3 transition">
                                <i class="fa-solid fa-clipboard-check text-blue-600 text-xs"></i> Ambil Kehadiran Sesi Ini
                            </button>
                            <button class="w-full bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 py-2.5 px-4 rounded-xl text-sm font-medium flex items-center gap-3 transition">
                                <i class="fa-solid fa-bullhorn text-blue-600 text-xs"></i> Buat Pengumuman Eskul
                            </button>
                        </div>
                    </div>

                    <!-- Jadwal Latihan Terdekat -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                        <h3 class="font-bold text-gray-900 text-base mb-4">Jadwal Latihan Terdekat</h3>
                        <div class="space-y-3">
                            <div class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50/50">
                                <div class="bg-blue-50 text-blue-600 p-2.5 rounded-xl text-center font-bold text-xs uppercase min-w-[50px]">
                                    <span class="block text-[10px] text-gray-400">Selasa</span> 17
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900">Latihan Taktik Futsal</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">15:00 - 17:30 • Lapangan Utama</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50/50">
                                <div class="bg-blue-50 text-blue-600 p-2.5 rounded-xl text-center font-bold text-xs uppercase min-w-[50px]">
                                    <span class="block text-[10px] text-gray-400">Kamis</span> 19
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900">Uji Tanding vs SMK 2</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">14:30 - 17:00 • Stadion Mini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Layout Bawah (Tabel Keaktifan & Penilaian Anggota) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Tabel Keaktifan Anggota (Lebar 2) -->
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-gray-900 text-base">Keaktifan Anggota Futsal</h3>
                        <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Lihat Semua Anggota</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider">
                                    <th class="pb-3 font-semibold">Nama Siswa</th>
                                    <th class="pb-3 font-semibold">Kelas</th>
                                    <th class="pb-3 font-semibold">Kehadiran</th>
                                    <th class="pb-3 font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                <tr>
                                    <td class="py-3.5 font-semibold text-gray-800">Jack Owhyy</td>
                                    <td class="py-3.5 text-gray-500">XII RPL 1</td>
                                    <td class="py-3.5 font-bold text-emerald-600">98%</td>
                                    <td class="py-3.5"><span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded-full font-medium">Aktif</span></td>
                                </tr>
                                <tr>
                                    <td class="py-3.5 font-semibold text-gray-800">Kha Dhael</td>
                                    <td class="py-3.5 text-gray-500">XII TKJ 2</td>
                                    <td class="py-3.5 font-bold text-emerald-600">94%</td>
                                    <td class="py-3.5"><span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded-full font-medium">Aktif</span></td>
                                </tr>
                                <tr>
                                    <td class="py-3.5 font-semibold text-gray-800">Lancelot Trigonometri</td>
                                    <td class="py-3.5 text-gray-500">XI RPL 2</td>
                                    <td class="py-3.5 font-bold text-amber-600">88%</td>
                                    <td class="py-3.5"><span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded-full font-medium">Aktif</span></td>
                                </tr>
                                <tr>
                                    <td class="py-3.5 font-semibold text-gray-800">MohonMaafLahirBatin</td>
                                    <td class="py-3.5 text-gray-500">XI MM 1</td>
                                    <td class="py-3.5 font-bold text-amber-600">76%</td>
                                    <td class="py-3.5"><span class="bg-rose-50 text-rose-600 text-xs px-2.5 py-1 rounded-full font-medium">Tidak Aktif</span></td>
                                </tr>
                                <tr>
                                    <td class="py-3.5 font-semibold text-gray-800">Sunan Crazyyyxyz</td>
                                    <td class="py-3.5 text-gray-500">X RPL 1</td>
                                    <td class="py-3.5 font-bold text-emerald-600">100%</td>
                                    <td class="py-3.5"><span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded-full font-medium">Aktif</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Daftar Tugas / Catatan Pembina (Kolom Kanan) -->
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-gray-900 text-base mb-4">Catatan & Evaluasi Pembina</h3>
                        <div class="space-y-3">
                            <div class="p-3 bg-blue-50/60 border border-blue-100 rounded-xl">
                                <h4 class="text-xs font-bold text-blue-900">Persiapan Turnamen Antar SMK</h4>
                                <p class="text-xs text-blue-700 mt-1">Fokuskan latihan fisik dan stamina untuk lini tengah pada sesi minggu depan.</p>
                            </div>
                            <div class="p-3 bg-amber-50/60 border border-amber-100 rounded-xl">
                                <h4 class="text-xs font-bold text-amber-900">Pengumpulan Nilai Rapor</h4>
                                <p class="text-xs text-amber-700 mt-1">Batas akhir input nilai ekstrakurikuler ke sistem admin adalah tanggal 25.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button class="w-full bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 py-2.5 rounded-xl text-xs font-semibold transition">
                            <i class="fa-solid fa-pen-to-square mr-1 text-blue-600"></i> Tulis Catatan Baru
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </main>

</body>
</html><?php /**PATH C:\laragon\www\EskulManager\resources\views/dashboard_guru.blade.php ENDPATH**/ ?>