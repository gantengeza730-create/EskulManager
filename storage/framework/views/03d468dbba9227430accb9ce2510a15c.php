<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - EkskulSMK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Kustomisasi scrollbar agar lebih rapi */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex overflow-hidden text-slate-800">

    <!-- ================= SIDEBAR ================= -->
    <aside class="w-64 bg-[#1E293B] flex flex-col justify-between shrink-0 h-screen overflow-y-auto">
        <div>
            <!-- Logo -->
            <div class="p-6 flex items-center gap-3">
                <div class="bg-blue-500 p-2 rounded-lg text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="text-white font-bold text-lg tracking-wide">Ekskul<span class="text-blue-400">SMK</span></span>
            </div>

            <!-- Menu Navigasi -->
            <nav class="px-4 space-y-1 mt-2">
                <!-- Dashboard (Aktif) -->
                <a href="/dashboard" class="flex items-center gap-3 bg-[#2E3C51] text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-sm border border-[#3A4A62]">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                
                <!-- Menu Lainnya (Tidak Aktif) -->
                <a href="#" class="flex items-center justify-between text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                        Ekskul Saya
                    </div>
                    <span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">3</span>
                </a>
                <a href="#" class="flex items-center gap-3 text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Jadwal Latihan
                </a>
                <a href="#" class="flex items-center gap-3 text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Kehadiran
                </a>
                <a href="#" class="flex items-center gap-3 text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Nilai & Rapor
                </a>
                <a href="#" class="flex items-center justify-between text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        Sertifikat
                    </div>
                    <span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">Baru</span>
                </a>
                <a href="#" class="flex items-center gap-3 text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    Pengumuman
                </a>
                <a href="#" class="flex items-center gap-3 text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Galeri Kegiatan
                </a>
                <a href="#" data-tab="profile" class="flex items-center gap-3 text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all mt-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profil Saya
                </a>
                <a href="#" class="flex items-center gap-3 text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Pengaturan
                </a>
            </nav>
        </div>

        <!-- Profil Bawah (Logout) -->
        <div class="p-4 bg-[#182235] mt-8 flex justify-between items-center border-t border-slate-700/50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-slate-600 overflow-hidden border-2 border-slate-500">
                    <?php if($user->avatar_path): ?>
                        <img src="<?php echo e(asset('storage/' . $user->avatar_path)); ?>" data-tab="profile" alt="User" class="w-full h-full object-cover cursor-pointer" title="Buka Profil Saya">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode(auth()->user()->name ?? 'User')); ?>&background=0D8ABC&color=fff" data-tab="profile" alt="User" class="w-full h-full object-cover cursor-pointer" title="Buka Profil Saya">
                    <?php endif; ?>
                </div>
                <div>
                    <h4 class="text-white text-sm font-bold truncate w-32"><?php echo e(auth()->user()->name ?? 'Muhe Alyaaaaaa'); ?></h4>
                    <p class="text-slate-400 text-[10px]"><?php echo e($user->class_name ?? 'XII RPL 1'); ?></p>
                </div>
            </div>
            
            <form action="/logout" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="text-slate-400 hover:text-white transition-colors" title="Keluar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- ================= KONTEN UTAMA ================= -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        
        <!-- Header Atas -->
        <header class="bg-white/80 backdrop-blur-md sticky top-0 z-10 px-8 py-5 border-b border-slate-200 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selamat Datang, <?php echo e(auth()->user()->name ?? 'M. Dimsum Shiruken'); ?></h1>
                <p class="text-xs text-slate-500 mt-1 font-medium"><?php echo e(\Carbon\Carbon::now()->translatedFormat('l, d F Y')); ?> &bull; Periode Semester Genap</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative hidden md:block">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Cari kegiatan..." class="pl-9 pr-4 py-2 border border-slate-200 rounded-full text-sm bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none w-64 transition-all">
                </div>
                <button class="relative p-2 text-slate-400 hover:text-slate-600 rounded-full border border-slate-200 bg-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                </button>
                <?php if($user->avatar_path): ?>
                    <img src="<?php echo e(asset('storage/' . $user->avatar_path)); ?>" data-tab="profile" class="w-9 h-9 rounded-full border border-slate-200 cursor-pointer shadow-sm object-cover" alt="Foto profil" title="Buka Profil Saya">
                <?php else: ?>
                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode(auth()->user()->name ?? 'User')); ?>&background=0D8ABC&color=fff" data-tab="profile" class="w-9 h-9 rounded-full border border-slate-200 cursor-pointer shadow-sm object-cover" alt="Foto profil" title="Buka Profil Saya">
                <?php endif; ?>
            </div>
        </header>

        <!-- Area Konten Isi -->
        <div class="p-8">
            <?php if(session('success')): ?>
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <ul class="list-disc pl-5 space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div id="tab-dashboard" class="space-y-8">
                <!-- Grid 4 Kartu Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Kartu 1: Ekskul -->
                <div class="bg-white p-5 border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-xs font-semibold text-slate-500">Ekskul Diikuti</p>
                        <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.001 2c-5.523 0-10 4.477-10 10s4.477 10 10 10 10-4.477 10-10-4.477-10-10-10zm-1.5 13.914l-3.207-3.207 1.414-1.414 1.793 1.793 4.793-4.793 1.414 1.414-6.207 6.207z"/></svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-black text-slate-800"><?php echo e(isset($registrations) ? $registrations->count() : '3'); ?></h2>
                    <p class="text-[10px] text-slate-400 mt-1 font-medium truncate">Futsal, Coding, Marching Band</p>
                </div>

                <!-- Kartu 2: Kehadiran -->
                <div class="bg-white p-5 border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-xs font-semibold text-slate-500">Tingkat Kehadiran</p>
                        <div class="w-8 h-8 bg-emerald-50 text-emerald-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-black text-slate-800">85%</h2>
                    <p class="text-[10px] text-slate-400 mt-1 font-medium">Sangat Baik (Kategori A)</p>
                </div>

                <!-- Kartu 3: Agenda -->
                <div class="bg-white p-5 border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-xs font-semibold text-slate-500">Agenda Bulan Ini</p>
                        <div class="w-8 h-8 bg-amber-50 text-amber-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-black text-slate-800">12</h2>
                    <p class="text-[10px] text-slate-400 mt-1 font-medium">Latihan rutin & persiapan tanding</p>
                </div>

                <!-- Kartu 4: Sertifikat -->
                <div class="bg-white p-5 border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-xs font-semibold text-slate-500">Sertifikat Diraih</p>
                        <div class="w-8 h-8 bg-rose-50 text-rose-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-black text-slate-800">2</h2>
                    <p class="text-[10px] text-slate-400 mt-1 font-medium">Marching Band & Coding</p>
                </div>
            </div>

                <!-- Area Bawah (Grafik & Widget Kanan) -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Kolom Kiri (Lebar 2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Grafik Placeholder (Sesuai Gambar) -->
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 h-64 flex flex-col">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-slate-800 text-sm">Keaktifan Latihan (Menit/Bulan)</h3>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Kehadiran</span>
                            </div>
                        </div>
                        <!-- Bar Chart Simulation CSS -->
                        <div class="flex-1 flex items-end justify-between px-8 gap-4 pb-2">
                            <div class="w-8 bg-slate-200 rounded-t-sm h-16 relative"><span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 left-1/2 -translate-x-1/2">Jan</span></div>
                            <div class="w-8 bg-slate-200 rounded-t-sm h-24 relative"><span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 left-1/2 -translate-x-1/2">Feb</span></div>
                            <div class="w-8 bg-blue-500 rounded-t-sm h-32 relative"><span class="absolute -bottom-6 text-[10px] font-bold text-slate-800 left-1/2 -translate-x-1/2">Mar</span></div>
                            <div class="w-8 bg-slate-200 rounded-t-sm h-20 relative"><span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 left-1/2 -translate-x-1/2">Apr</span></div>
                            <div class="w-8 bg-slate-200 rounded-t-sm h-12 relative"><span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 left-1/2 -translate-x-1/2">Mei</span></div>
                            <div class="w-8 bg-slate-200 rounded-t-sm h-8 relative"><span class="absolute -bottom-6 text-[10px] font-bold text-slate-400 left-1/2 -translate-x-1/2">Jun</span></div>
                        </div>
                    </div>

                    <!-- Ekstrakurikuler Saya (Daftar List) -->
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                        <div class="flex justify-between items-center mb-5">
                            <h3 class="font-bold text-slate-800 text-sm">Ekstrakurikuler Saya</h3>
                            <a href="#" class="text-xs font-bold text-blue-600 hover:underline">Kelola Ekskul</a>
                        </div>
                        
                        <div class="space-y-3">
                            <!-- List 1: Futsal -->
                            <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800">Futsal</h4>
                                        <p class="text-[11px] text-slate-500">Pembina: Bambang Pamungkas</p>
                                    </div>
                                </div>
                                <span class="text-xs font-medium text-slate-400">Setiap Selasa & Kamis</span>
                            </div>

                            <!-- List 2: Coding -->
                            <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800">Coding Club</h4>
                                        <p class="text-[11px] text-slate-500">Pembina: Sandhika Galih</p>
                                    </div>
                                </div>
                                <span class="text-xs font-medium text-slate-400">Setiap Rabu Sore</span>
                            </div>

                            <!-- List 3: Marching Band -->
                            <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800">Marching Band</h4>
                                        <p class="text-[11px] text-slate-500">Pembina: Addie MS</p>
                                    </div>
                                </div>
                                <span class="text-xs font-medium text-slate-400">Setiap Jumat Sore</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan (Lebar 1/3) -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Jadwal Kegiatan -->
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                        <h3 class="font-bold text-slate-800 text-sm mb-5">Jadwal Kegiatan Terdekat</h3>
                        
                        <div class="space-y-4">
                            <!-- Item Jadwal 1 -->
                            <div class="flex gap-4">
                                <div class="w-12 h-12 bg-blue-50 rounded-xl flex flex-col items-center justify-center shrink-0 border border-blue-100">
                                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Mar</span>
                                    <span class="text-lg font-black text-blue-700 leading-none mt-0.5">18</span>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Latihan Rutin Marching Band</h4>
                                    <p class="text-[10px] text-slate-500 mt-1">15.00 - 17.30 &bull; Lapangan Utama</p>
                                </div>
                            </div>
                            <!-- Item Jadwal 2 -->
                            <div class="flex gap-4">
                                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex flex-col items-center justify-center shrink-0 border border-emerald-100">
                                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Mar</span>
                                    <span class="text-lg font-black text-emerald-700 leading-none mt-0.5">21</span>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Seleksi LKS Programming RPL</h4>
                                    <p class="text-[10px] text-slate-500 mt-1">08.00 - selesai &bull; Lab Komputer 1</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengumuman Penting -->
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                        <h3 class="font-bold text-slate-800 text-sm mb-5">Pengumuman Penting</h3>
                        
                        <div class="space-y-3">
                            <!-- Pengumuman 1 -->
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] text-slate-400">12 Mar 2026</span>
                                    <span class="text-[9px] font-bold bg-rose-100 text-rose-600 px-2 py-0.5 rounded-full tracking-wide">PENTING</span>
                                </div>
                                <h4 class="text-xs font-bold text-slate-800 leading-tight">Seleksi LKS Nasional Tingkat Kota</h4>
                            </div>
                            <!-- Pengumuman 2 -->
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] text-slate-400">08 Mar 2026</span>
                                    <span class="text-[9px] font-bold bg-amber-100 text-amber-600 px-2 py-0.5 rounded-full tracking-wide">KEBIJAKAN</span>
                                </div>
                                <h4 class="text-xs font-bold text-slate-800 leading-tight">Aturan Baru Reservasi Lapangan</h4>
                            </div>
                        </div>
                    </div>

                </div>

                </div>
                <!-- End Konten Bawah -->
            </div>

            <div id="tab-profile" class="hidden">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6 mb-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Profil Siswa</h2>
                            <p class="text-sm text-slate-500 mt-1">Kelola nama, foto, kelas, nomor HP, dan bio singkat.</p>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Barebones</span>
                    </div>

                    <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-6 items-start">
                        <?php echo csrf_field(); ?>
                        <div class="flex flex-col items-center text-center gap-4">
                            <div class="w-36 h-36 rounded-full overflow-hidden border-4 border-slate-100 shadow-sm bg-slate-100">
                                <?php if($user->avatar_path): ?>
                                    <img src="<?php echo e(asset('storage/' . $user->avatar_path)); ?>" alt="Foto profil" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name ?? 'User')); ?>&background=0D8ABC&color=fff&size=256" alt="Foto profil" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                            <div>
                                <label class="inline-flex cursor-pointer items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700 transition-colors">
                                    Pilih Foto
                                    <input type="file" name="avatar" accept="image/*" class="hidden">
                                </label>
                                <p class="mt-2 text-xs text-slate-500">JPG, PNG, WEBP. Maks 2MB.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-4 py-3 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Kelas</label>
                                <input type="text" name="class_name" value="<?php echo e(old('class_name', $user->class_name)); ?>" placeholder="XII RPL 1" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-4 py-3 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                                <input type="email" value="<?php echo e($user->email); ?>" class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-sm" disabled>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">No. HP</label>
                                <input type="text" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" placeholder="08xxxxxxxxxx" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-4 py-3 text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Bio Singkat</label>
                                <textarea name="bio" rows="4" maxlength="500" placeholder="Ceritakan minat atau targetmu di ekskul..." class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-4 py-3 text-sm"><?php echo e(old('bio', $user->bio)); ?></textarea>
                            </div>
                            <div class="md:col-span-2 flex items-center gap-3">
                                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">Simpan Profil</button>
                                <p class="text-xs text-slate-500">Perubahan akan langsung tersimpan di database pengguna.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = {
                dashboard: document.getElementById('tab-dashboard'),
                profile: document.getElementById('tab-profile'),
            };

            const navItems = Array.from(document.querySelectorAll('[data-tab]'));

            function activateTab(name) {
                Object.entries(tabs).forEach(function ([tabName, element]) {
                    if (!element) {
                        return;
                    }

                    element.classList.toggle('hidden', tabName !== name);
                });

                navItems.forEach(function (item) {
                    const isActive = item.dataset.tab === name;
                    item.classList.toggle('bg-[#2E3C51]', isActive);
                    item.classList.toggle('text-white', isActive);
                    item.classList.toggle('shadow-sm', isActive);
                    item.classList.toggle('border', isActive);
                    item.classList.toggle('border-[#3A4A62]', isActive);
                    item.classList.toggle('text-slate-400', !isActive);
                });
            }

            navItems.forEach(function (item) {
                item.addEventListener('click', function (event) {
                    event.preventDefault();
                    activateTab(item.dataset.tab || 'dashboard');
                });
            });

            document.querySelectorAll('[data-tab="profile"]').forEach(function (element) {
                element.addEventListener('click', function () {
                    activateTab('profile');
                });
            });

            activateTab('dashboard');
        });
    </script>

</body>
</html><?php /**PATH C:\laragon\www\EskulManager\resources\views/dashboard.blade.php ENDPATH**/ ?>