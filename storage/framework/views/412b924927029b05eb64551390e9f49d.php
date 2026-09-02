<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EkskulSMK - Portal Ekstrakurikuler</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased selection:bg-blue-600 selection:text-white">

    <!-- Flash Message Notification -->
    <?php if(session('error')): ?>
        <div class="bg-red-500 text-white p-3 text-center text-sm font-semibold sticky top-0 z-50"><?php echo e(session('error')); ?></div>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <div class="bg-emerald-500 text-white p-3 text-center text-sm font-semibold sticky top-0 z-50"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 font-bold text-lg tracking-tight text-blue-950">
                <span class="bg-blue-600 text-white p-1.5 rounded-lg text-sm shadow-md">🎓</span> EkskulSMK
            </a>
            <div class="hidden md:flex gap-8 text-sm font-semibold text-slate-500">
                <a href="#home" class="text-blue-600 transition">Beranda</a>
                <a href="#ekskul" class="hover:text-blue-600 transition">Ekstrakurikuler</a>
                <a href="#fitur" class="hover:text-blue-600 transition">Fitur</a>
                <a href="#jadwal" class="hover:text-blue-600 transition">Jadwal</a>
            </div>
            <div class="flex items-center gap-3">
                <?php if(auth()->guard()->check()): ?>
                    <a href="/dashboard" class="px-5 py-2 bg-blue-600 text-white text-sm font-bold rounded-full shadow-md hover:bg-blue-700 transition">Ke Dashboard -></a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="px-5 py-2 text-slate-700 text-sm font-bold rounded-full hover:bg-slate-100 transition">Masuk</a>
                    <a href="<?php echo e(url('/register')); ?>" class="px-5 py-2 bg-blue-600 text-white text-sm font-bold rounded-full shadow-md hover:bg-blue-700 transition">Daftar Sekarang</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section (Tetap Dipertahankan) -->
    <section id="home" class="max-w-7xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-12 items-center">
        <div class="space-y-6">
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 leading-[1.15] tracking-tight">
                Temukan & Kembangkan <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Bakat Terpendammu.</span>
            </h1>
            <p class="text-slate-600 text-base md:text-lg leading-relaxed max-w-lg">
                Platform resmi manajemen ekstrakurikuler sekolah. Jelajahi aktivitas, lihat jadwal, dan daftarkan dirimu ke berbagai kegiatan hanya dengan satu klik.
            </p>
            <div class="flex flex-wrap gap-4 pt-2">
                <a href="/register" class="px-8 py-3.5 bg-blue-600 text-white font-bold rounded-full shadow-lg shadow-blue-600/30 hover:bg-blue-700 transition">Mulai Jelajahi</a>
                <a href="#ekskul" class="px-8 py-3.5 bg-white border-2 border-slate-200 text-slate-700 font-bold rounded-full hover:border-slate-300 hover:bg-slate-50 transition">Lihat Katalog</a>
            </div>
        </div>
        <div class="relative hidden md:block">
            <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=800&q=80" class="relative rounded-3xl shadow-2xl w-full object-cover h-[450px] z-10" alt="Siswa Aktif">
        </div>
    </section>

    <!-- Ekstrakurikuler Grid Dinamis -->
    <section id="ekskul" class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center mb-12">
            <span class="text-blue-600 text-xs font-bold uppercase tracking-widest">AKTIVITAS SISWA</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2">Ekstrakurikuler Populer</h2>
        </div>
        
        <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $ekskuls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="group relative h-80 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-end p-5 text-white bg-cover bg-center" style="background-image: url('<?php echo e($item->image); ?>');">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div class="flex justify-between items-start">
                        <span class="bg-white text-emerald-700 text-[10px] font-bold px-3 py-1 rounded-full uppercase"><?php echo e($item->category); ?></span>
                        <span class="text-xs font-medium text-slate-200 block"><?php echo e(rand(40, 150)); ?> Anggota</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold"><?php echo e($item->title); ?></h3>
                        <p class="text-xs text-slate-300 mb-2"><?php echo e($item->coach); ?></p>
                        <p class="text-[11px] text-slate-300 mt-2 line-clamp-3"><?php echo e($item->description); ?></p>
                        <form action="/join/<?php echo e($item->id); ?>" method="POST" class="mt-4">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-max px-5 py-1.5 border border-white/50 hover:bg-white hover:text-slate-900 rounded-lg text-xs font-bold transition">Gabung</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <!-- Fitur Unggulan Sistem (Sesuai Screenshot 3) -->
    <section id="fitur" class="bg-white py-20 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <span class="text-blue-600 text-xs font-bold uppercase tracking-widest">TEKNOLOGI MODERN</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2">Fitur Unggulan Sistem</h2>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Data statis sesuai gambar -->
                <?php
                    $fiturs = [
                        ['icon' => '👤', 'title' => 'Dashboard Siswa', 'desc' => 'Akses personal untuk pendaftaran, presensi, jadwal latihan, dan sertifikat prestasi.'],
                        ['icon' => '🎓', 'title' => 'Dashboard Pembina', 'desc' => 'Kelola daftar anggota, input absensi, nilai kegiatan, hingga laporan pertanggungjawaban.'],
                        ['icon' => '🛡️', 'title' => 'Dashboard Admin', 'desc' => 'Kontrol penuh pendaftaran ekskul baru, kelola data master sekolah, dan ekspor laporan menyeluruh.'],
                        ['icon' => '📄', 'title' => 'Pendaftaran Online', 'desc' => 'Formulir pendaftaran digital cepat, eliminasi berkas fisik, dan persetujuan wali kelas otomatis.'],
                        ['icon' => '☑️', 'title' => 'Presensi Realtime', 'desc' => 'Pencatatan absensi digital via scan QR code atau geotagging lokasi latihan secara akurat.'],
                        ['icon' => '📅', 'title' => 'Jadwal Interaktif', 'desc' => 'Kalender kegiatan terintegrasi untuk menghindari bentrok penggunaan aula/lapangan sekolah.'],
                        ['icon' => '🏅', 'title' => 'Evaluasi & Penilaian', 'desc' => 'Sistem penilaian keaktifan siswa yang otomatis tersinkronisasi sebagai nilai rapor.'],
                        ['icon' => '📜', 'title' => 'Sertifikat Digital', 'desc' => 'Generasi sertifikat berstandar sekolah ber-QR code untuk klaim portofolio kerja siswa.'],
                        ['icon' => '📢', 'title' => 'Papan Pengumuman', 'desc' => 'Sebarkan berita resmi, pembatalan latihan, dan jadwal kompetisi langsung ke beranda siswa.'],
                        ['icon' => '🔔', 'title' => 'Notifikasi Cepat', 'desc' => 'Kirim pesan peringatan otomatis ke WhatsApp/Email orang tua terkait kehadiran siswa.'],
                        ['icon' => '🖼️', 'title' => 'Galeri Dokumentasi', 'desc' => 'Abadikan dan pamerkan momen keseruan serta foto aksi terbaik dari setiap ekstrakurikuler.'],
                        ['icon' => '📊', 'title' => 'Laporan Terstruktur', 'desc' => 'Analisis grafik pertumbuhan keaktifan siswa yang siap dicetak untuk evaluasi dinas pendidikan.']
                    ];
                ?>
                <?php $__currentLoopData = $fiturs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="p-6 rounded-2xl border border-slate-100 bg-white hover:shadow-lg transition duration-300">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xl mb-4"><?php echo e($f['icon']); ?></div>
                    <h4 class="font-bold text-slate-900 mb-2"><?php echo e($f['title']); ?></h4>
                    <p class="text-xs text-slate-500 leading-relaxed"><?php echo e($f['desc']); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- Pengumuman Terbaru (Sesuai Screenshot 4) -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <span class="text-blue-600 text-xs font-bold uppercase tracking-widest">KABAR SEKOLAH</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2">Pengumuman Terbaru</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xs text-slate-400 font-medium">12 Mar 2026</span>
                        <span class="text-[10px] font-bold px-3 py-1 bg-amber-100 text-amber-700 rounded-full">Informasi</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-lg mb-2">Pendaftaran Ekstrakurikuler SMKN 1 Binong Dibuka</h4>
                    <p class="text-sm text-slate-500 mb-6 flex-grow">Siswa SMKN 1 Binong dapat mendaftarkan diri ke berbagai ekstrakurikuler sesuai minat dan bakat. Segera lakukan pendaftaran sebelum batas waktu ditentukan.</p>
                    <a href="#" class="text-blue-600 text-sm font-bold hover:underline">Baca Selengkapnya →</a>
                </div>
                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xs text-slate-400 font-medium">08 Mar 2026</span>
                        <span class="text-[10px] font-bold px-3 py-1 bg-red-100 text-red-700 rounded-full">Pengumuman</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-lg mb-2">Jadwal Latihan Ekstrakurikuler Semester Genap</h4>
                    <p class="text-sm text-slate-500 mb-6 flex-grow">Jadwal latihan seluruh ekstrakurikuler telah diperbarui. Silahkan cek jadwal masing-masing agar tidak terjadi bentrok dengan kegiatan belajar mengajar.</p>
                    <a href="#" class="text-blue-600 text-sm font-bold hover:underline">Baca Selengkapnya →</a>
                </div>
                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xs text-slate-400 font-medium">05 Mar 2026</span>
                        <span class="text-[10px] font-bold px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full">Prestasi</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-lg mb-2">SMKN 1 Binong Raih Prestasi di Tingkat Kabupaten</h4>
                    <p class="text-sm text-slate-500 mb-6 flex-grow">Selamat kepada siswa siswi SMKN 1 Binong yang berhasil meraih prestasi dalam berbagai perlombaan akademik. Semoga menjadi inspirasi bagi seluruh warga sekolah.</p>
                    <a href="#" class="text-blue-600 text-sm font-bold hover:underline">Baca Selengkapnya →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Jadwal Kegiatan Mendatang (Sesuai Screenshot 5 & 6) -->
    <section id="jadwal" class="py-20 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <span class="text-blue-600 text-xs font-bold uppercase tracking-widest">AGENDA LATIHAN & LOMBA</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2">Jadwal Kegiatan Mendatang</h2>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                    $jadwals = [
                        ['badge' => 'Marching Band', 'title' => 'Festival Marching Band Jakarta', 'date' => 'Sabtu, 18 April 2026', 'time' => '08:00 - 15:00 WIB', 'loc' => 'Subang, subang'],
                        ['badge' => 'Paskibra', 'title' => 'Paskibra Gabungan & Pemantapan Fisik', 'date' => 'Minggu, 19 April 2026', 'time' => '07:00 - 12:00 WIB', 'loc' => 'Lapangan Utama SMK'],
                        ['badge' => 'Pramuka', 'title' => 'Kemah Bakti Pramuka Penegak', 'date' => '24 - 26 April 2026', 'time' => '3 Hari 2 Malam', 'loc' => 'Bumi Perkemahan Ciwideeuyyy'],
                        ['badge' => 'PMR', 'title' => 'Simulasi Gawat Darurat & PMR', 'date' => 'Selasa, 28 April 2026', 'time' => '14:00 - 16:30 WIB', 'loc' => 'Di ruangan PMI'],
                        ['badge' => 'Programming', 'title' => 'UI/UX & Frontend Development Workshop', 'date' => 'Jumat, 01 Mei 2026', 'time' => '13:30 - 17:00 WIB', 'loc' => 'Lab Komputer RPL 1'],
                        ['badge' => 'Basketball', 'title' => 'Futsal antar sekolah / Tournament', 'date' => 'Sabtu, 02 Mei 2026', 'time' => '09:00 - selesai', 'loc' => 'Di America']
                    ];
                ?>
                <?php $__currentLoopData = $jadwals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 hover:shadow-md transition">
                    <span class="inline-block px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-full mb-4"><?php echo e($j['badge']); ?></span>
                    <h4 class="font-bold text-slate-900 text-lg mb-4"><?php echo e($j['title']); ?></h4>
                    <div class="space-y-2 text-sm text-slate-600">
                        <p class="flex items-center gap-2">📅 <?php echo e($j['date']); ?></p>
                        <p class="flex items-center gap-2">🕒 <?php echo e($j['time']); ?></p>
                        <p class="flex items-center gap-2">📍 <?php echo e($j['loc']); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- Testimoni (Sesuai Screenshot 7) -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <span class="text-blue-600 text-xs font-bold uppercase tracking-widest">CERITA SUKSES</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2">Apa Kata Mereka?</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Testi 1 -->
                <div class="bg-white p-8 rounded-2xl border border-slate-200">
                    <p class="text-slate-600 italic text-sm leading-relaxed mb-6">"Sejak sekolah pakai sistem ini, saya gampang banget lihat jadwal latihan basket dan absen tinggal scan QR code. Pengajuan sertifikat lomba juga serba digital, membantu sekali buat persiapan SNMPTN dan portofolio kerja nanti!"</p>
                    <div class="flex items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100" class="w-12 h-12 rounded-full object-cover" alt="User">
                        <div>
                            <h5 class="font-bold text-slate-900 text-sm">M. Alucard Ciwideuy</h5>
                            <p class="text-xs text-slate-500">Siswa Kelas XII RPL</p>
                        </div>
                    </div>
                </div>
                <!-- Testi 2 -->
                <div class="bg-white p-8 rounded-2xl border border-slate-200">
                    <p class="text-slate-600 italic text-sm leading-relaxed mb-6">"Sebagai pembina Pramuka, mendata 200+ anggota secara manual dulu bikin pusing kepala. Sekarang, rekap kehadiran otomatis, pembagian modul materi gampang diakses siswa, dan saya bisa langsung buat laporan ke kepala sekolah."</p>
                    <div class="flex items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100" class="w-12 h-12 rounded-full object-cover" alt="User">
                        <div>
                            <h5 class="font-bold text-slate-900 text-sm">Istar Pamungkas</h5>
                            <p class="text-xs text-slate-500">Pembina Pramuka</p>
                        </div>
                    </div>
                </div>
                <!-- Testi 3 -->
                <div class="bg-white p-8 rounded-2xl border border-slate-200">
                    <p class="text-slate-600 italic text-sm leading-relaxed mb-6">"Sistem Ekskul SMK memberikan visibilitas penuh bagi jajaran direksi sekolah untuk memonitor tingkat keaktifan siswa. Platform ini sangat sejalan dengan visi digitalisasi sekolah kejuruan modern yang cerdas dan transparan."</p>
                    <div class="flex items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" class="w-12 h-12 rounded-full object-cover" alt="User">
                        <div>
                            <h5 class="font-bold text-slate-900 text-sm">Ir, Sigma M.Pd.</h5>
                            <p class="text-xs text-slate-500">Kepala Sekolah SMK</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (Sesuai Screenshot 7) -->
    <footer class="bg-[#111827] text-slate-300 py-16">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12 mb-12">
            <!-- Col 1 -->
            <div>
                <a href="/" class="flex items-center gap-2 font-bold text-xl text-white mb-4">
                    <span class="bg-blue-600 text-white p-1.5 rounded-lg text-sm">🎓</span> EkskulSMK
                </a>
                <p class="text-sm text-slate-400 mb-6 leading-relaxed">Sistem Manajemen Ekstrakurikuler SMK terpadu untuk mempermudah pendaftaran, manajemen absensi, sertifikasi, dan publikasi agenda olahraga & kreativitas siswa.</p>
                <div class="flex gap-3">
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition text-white">📸</a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition text-white">📘</a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition text-white">▶️</a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition text-white">🐦</a>
                </div>
            </div>
            <!-- Col 2 -->
            <div>
                <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">NAVIGASI</h4>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li><a href="#home" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="#ekskul" class="hover:text-white transition">Ekstrakurikuler</a></li>
                    <li><a href="#jadwal" class="hover:text-white transition">Jadwal Latihan</a></li>
                    <li><a href="#" class="hover:text-white transition">Pengumuman</a></li>
                    <li><a href="#" class="hover:text-white transition">Galeri Foto</a></li>
                    <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                </ul>
            </div>
            <!-- Col 3 -->
            <div>
                <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">KONTAK SEKOLAH</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5">📍</span>
                        Jl. Subang No. 1, Jawa Barat, Indonesia
                    </li>
                    <li class="flex items-center gap-3">
                        <span>📞</span>
                        +62 822-4937-7261
                    </li>
                    <li class="flex items-center gap-3">
                        <span>✉️</span>
                        muhealya@gmail.com
                    </li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
            <p>&copy; 2026 Ekskul SMKN 1 Binong All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-slate-300">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-slate-300">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

</body>
</html><?php /**PATH C:\laragon\www\EskulManager\resources\views/landing.blade.php ENDPATH**/ ?>