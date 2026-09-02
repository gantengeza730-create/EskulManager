<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Eskul SMK</title>
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

            <!-- Menu Navigasi Admin -->
            <nav class="px-4 py-4 space-y-1 text-sm max-h-[calc(100vh-180px)] overflow-y-auto">
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-blue-600 text-white rounded-xl font-medium shadow-lg shadow-blue-600/30">
                    <i class="fa-solid fa-grid-2"></i> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-layer-group"></i> Manajemen Eskul
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-user-graduate"></i> Manajemen Siswa
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-chalkboard-user"></i> Manajemen Guru
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-calendar-days"></i> Jadwal
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-clipboard-user"></i> Kehadiran
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-chart-pie"></i> Laporan
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-bullhorn"></i> Pengumuman
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-award"></i> Sertifikat
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 rounded-xl transition text-gray-400 hover:text-white">
                    <i class="fa-solid fa-images"></i> Galeri
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
                    <h4 class="text-white text-sm font-semibold"><?php echo e($user->name ?? 'Admin Utama'); ?></h4>
                    <p class="text-xs text-blue-400">Hubungan Siswa</p>
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
                06 — Admin Dashboard
            </div>
            <div class="flex items-center gap-4">
                <!-- Search Bar -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" placeholder="Cari kegiatan..." class="bg-gray-50 border border-gray-200 rounded-full pl-9 pr-4 py-1.5 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">
                </div>
                <!-- Notifikasi -->
                <button class="w-9 h-9 rounded-full bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition">
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
                        <h2 class="text-2xl font-bold text-gray-900">Pusat Kendali Admin SMK</h2>
                        <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full font-medium">Super Admin</span>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Rabu, 18 Maret 2026 • Monitoring global sistem</p>
                </div>
            </div>

            <!-- Grid 4 Kartu Statistik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Card 1 -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Total Siswa</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">1,250</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-3">Dari semua jurusan</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Ekstrakurikuler</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">9 Cabang</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                    </div>
                    <p class="text-xs text-emerald-600 font-medium mt-3">Aktif berjalan</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Pembina/Guru</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">48 Guru</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-3">Terdaftar membimbing</p>
                </div>
                <!-- Card 4 -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Sertifikat Diterbitkan</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">350+</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                            <i class="fa-solid fa-award"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-3">Telah diverifikasi qr-code</p>
                </div>
            </div>

            <!-- Layout Bagian Tengah (Grafik Popularitas & Menu Operasional) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Grafik Popularitas Eskul (Kolom Kiri - Lebar 2) -->
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-gray-900 text-base">Popularitas Ekstrakurikuler (Jumlah Anggota)</h3>
                    </div>
                    <!-- Simulasi Bar Chart -->
                    <div class="h-48 flex items-end justify-between gap-4 px-4 pt-6 border-b border-gray-100">
                        <div class="w-full bg-blue-500 rounded-t-lg h-[65%] flex flex-col justify-end items-center pb-2 shadow-sm"></div>
                        <div class="w-full bg-blue-400 rounded-t-lg h-[55%] flex flex-col justify-end items-center pb-2"></div>
                        <div class="w-full bg-blue-600 rounded-t-lg h-[90%] flex flex-col justify-end items-center pb-2 shadow-md shadow-blue-500/25"></div>
                        <div class="w-full bg-blue-400 rounded-t-lg h-[45%] flex flex-col justify-end items-center pb-2"></div>
                        <div class="w-full bg-blue-400 rounded-t-lg h-[45%] flex flex-col justify-end items-center pb-2"></div>
                        <div class="w-full bg-blue-300 rounded-t-lg h-[35%] flex flex-col justify-end items-center pb-2"></div>
                    </div>
                    <div class="grid grid-cols-6 text-center text-[11px] text-gray-500 pt-3">
                        <span>Programming</span>
                        <span>Futsal</span>
                        <span>Pramuka</span>
                        <span>Basketball</span>
                        <span>Marching Band</span>
                        <span>Photography</span>
                    </div>
                </div>

                <!-- Kolom Kanan (Menu Operasional Admin) -->
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                        <h3 class="font-bold text-gray-900 text-base mb-4">Menu Operasional Admin</h3>
                        <div class="space-y-3">
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-xl text-sm font-medium flex items-center gap-3 transition shadow-md shadow-blue-600/20">
                                <i class="fa-solid fa-plus text-xs"></i> Tambah Cabang Eskul
                            </button>
                            <button class="w-full bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 py-2.5 px-4 rounded-xl text-sm font-medium flex items-center gap-3 transition">
                                <i class="fa-solid fa-user-plus text-blue-600 text-xs"></i> Impor Data Siswa Baru
                            </button>
                            <button class="w-full bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 py-2.5 px-4 rounded-xl text-sm font-medium flex items-center gap-3 transition">
                                <i class="fa-solid fa-file-arrow-down text-blue-600 text-xs"></i> Cetak Laporan Rapor
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Layout Bagian Bawah (Tabel Pendaftaran & Aktivitas Terkini) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Tabel Pendaftaran Siswa Baru (Lebar 2) -->
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-gray-900 text-base">Pendaftaran Siswa Baru</h3>
                        <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Proses Semua Pendaftaran</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider">
                                    <th class="pb-3 font-semibold">Nama Pendaftar</th>
                                    <th class="pb-3 font-semibold">Pilihan Eskul</th>
                                    <th class="pb-3 font-semibold">Waktu Daftar</th>
                                    <th class="pb-3 font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                <tr>
                                    <td class="py-3.5 font-semibold text-gray-800">Alukar Pou</td>
                                    <td class="py-3.5 text-gray-500">Programming</td>
                                    <td class="py-3.5 text-gray-400 text-xs">Hari Ini, 09:30</td>
                                    <td class="py-3.5"><span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded-full font-medium">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td class="py-3.5 font-semibold text-gray-800">Jack OwH Chii</td>
                                    <td class="py-3.5 text-gray-500">Marching Band</td>
                                    <td class="py-3.5 text-gray-400 text-xs">Hari Ini, 08:15</td>
                                    <td class="py-3.5"><span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded-full font-medium">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td class="py-3.5 font-semibold text-gray-800">Ambaruwoo</td>
                                    <td class="py-3.5 text-gray-500">Photography</td>
                                    <td class="py-3.5 text-gray-400 text-xs">Kemarin, 16:45</td>
                                    <td class="py-3.5"><span class="bg-amber-50 text-amber-600 text-xs px-2.5 py-1 rounded-full font-medium">Diproses</span></td>
                                </tr>
                                <tr>
                                    <td class="py-3.5 font-semibold text-gray-800">Fuad Cihuuyyy</td>
                                    <td class="py-3.5 text-gray-500">PMR</td>
                                    <td class="py-3.5 text-gray-400 text-xs">Kemarin, 14:20</td>
                                    <td class="py-3.5"><span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded-full font-medium">Selesai</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Aktivitas Sistem Terkini (Kolom Kanan) -->
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <h3 class="font-bold text-gray-900 text-base mb-4">Aktivitas Sistem Terkini</h3>
                    <div class="space-y-4 border-l-2 border-gray-100 ml-2 pl-4">
                        <div class="relative">
                            <span class="absolute -left-[21px] top-1 w-2.5 h-2.5 rounded-full bg-blue-600 ring-4 ring-white"></span>
                            <h4 class="text-xs font-bold text-gray-800">Admin merilis jadwal upacara Paskibra</h4>
                            <p class="text-[11px] text-gray-400 mt-0.5">10 menit yang lalu</p>
                        </div>
                        <div class="relative">
                            <span class="absolute -left-[21px] top-1 w-2.5 h-2.5 rounded-full bg-blue-600 ring-4 ring-white"></span>
                            <h4 class="text-xs font-bold text-gray-800">Pendaftaran ekskul 'PMR' dibuka kembali</h4>
                            <p class="text-[11px] text-gray-400 mt-0.5">1 jam yang lalu</p>
                        </div>
                        <div class="relative">
                            <span class="absolute -left-[21px] top-1 w-2.5 h-2.5 rounded-full bg-blue-600 ring-4 ring-white"></span>
                            <h4 class="text-xs font-bold text-gray-800">Pak Sandhika mengunduh rapor ekskul Programming</h4>
                            <p class="text-[11px] text-gray-400 mt-0.5">3 jam yang lalu</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

</body>
</html><?php /**PATH C:\laragon\www\EskulManager\resources\views/dashboard_admin.blade.php ENDPATH**/ ?>