<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - EkskulSMK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex overflow-hidden text-slate-800">

    <aside class="w-64 bg-[#1E293B] flex flex-col justify-between shrink-0 h-screen overflow-y-auto">
        <div>
            <a href="/" class="p-6 flex items-center gap-3">
                <div class="bg-blue-500 p-2 rounded-lg text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="text-white font-bold text-lg tracking-wide">Ekskul<span class="text-blue-400">SMK</span></span>
            </a>

            <nav class="px-4 space-y-1 mt-2">
                <a href="#" data-tab="dashboard" class="flex items-center gap-3 bg-[#2E3C51] text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-sm border border-[#3A4A62]">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>

                <a href="#" data-tab="anggota" class="flex items-center justify-between text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                        Anggota
                    </div>
                    <?php $anggotaCount = ($acceptedRegistrations->count() + $pendingRegistrations->count()); ?>
                    <?php if($anggotaCount > 0): ?>
                        <span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full"><?php echo e($anggotaCount); ?></span>
                    <?php endif; ?>
                </a>

                <a href="#" data-tab="ekskul" class="flex items-center justify-between text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                        Ekskul Saya
                    </div>
                    <?php if($ekskuls->count() > 0): ?>
                        <span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full"><?php echo e($ekskuls->count()); ?></span>
                    <?php endif; ?>
                </a>

                <a href="#" data-tab="jadwal" class="flex items-center gap-3 text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Jadwal Latihan
                </a>

                <a href="#" data-tab="kehadiran" class="flex items-center gap-3 text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Kehadiran
                </a>

                <a href="#" data-tab="nilai" class="flex items-center gap-3 text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
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

                <a href="#" data-tab="settings" class="flex items-center gap-3 text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Pengaturan
                </a>
            </nav>
        </div>

        <div class="p-4 bg-[#182235] mt-8 flex justify-between items-center border-t border-slate-700/50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-slate-600 overflow-hidden border-2 border-slate-500">
                    <?php if($user->avatar_path): ?>
                        <img src="<?php echo e(asset('storage/' . $user->avatar_path)); ?>" data-tab="profile" alt="User" class="w-full h-full object-cover cursor-pointer" title="Buka Profil Saya">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name ?? 'User')); ?>&background=0D8ABC&color=fff" data-tab="profile" alt="User" class="w-full h-full object-cover cursor-pointer" title="Buka Profil Saya">
                    <?php endif; ?>
                </div>
                <div>
                    <h4 class="text-white text-sm font-bold truncate w-32"><?php echo e($user->name ?? 'Pembina Futsal'); ?></h4>
                    <p class="text-slate-400 text-[10px]"><?php echo e($user->class_name ?? 'Pembina Ekstrakurikuler'); ?></p>
                </div>
            </div>

            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="text-slate-400 hover:text-white transition-colors" title="Keluar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <header class="bg-white/80 backdrop-blur-md sticky top-0 z-10 px-8 py-5 border-b border-slate-200 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selamat Datang, <?php echo e($user->name ?? 'Pembina Futsal'); ?></h1>
                <p class="text-xs text-slate-500 mt-1 font-medium"><?php echo e(\Carbon\Carbon::now()->translatedFormat('l, d F Y')); ?> &bull; Kelola ektrakurikuler dan rekap aktivitas</p>
            </div>

            <div class="flex items-center gap-4">
                <div class="relative hidden md:block">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Cari siswa atau jadwal..." class="pl-9 pr-4 py-2 border border-slate-200 rounded-full text-sm bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none w-64 transition-all">
                </div>

                <button class="relative p-2 text-slate-400 hover:text-slate-600 rounded-full border border-slate-200 bg-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <?php if(($pendingRegistrations->count() + $acceptedRegistrations->count()) > 0): ?>
                        <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 flex items-center justify-center text-[10px] font-bold bg-red-500 text-white rounded-full border-2 border-white">
                            <?php echo e($pendingRegistrations->count() + $acceptedRegistrations->count()); ?>

                        </span>
                    <?php endif; ?>
                </button>

                <?php if($user->avatar_path): ?>
                    <img src="<?php echo e(asset('storage/' . $user->avatar_path)); ?>" data-tab="profile" class="w-9 h-9 rounded-full border border-slate-200 cursor-pointer shadow-sm object-cover" alt="Foto profil" title="Buka Profil Saya">
                <?php else: ?>
                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name ?? 'User')); ?>&background=0D8ABC&color=fff" data-tab="profile" class="w-9 h-9 rounded-full border border-slate-200 cursor-pointer shadow-sm object-cover" alt="Foto profil" title="Buka Profil Saya">
                <?php endif; ?>
            </div>
        </header>

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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-5 border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-xs font-semibold text-slate-500">Total Anggota</p>
                            <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                            </div>
                        </div>
                        <h2 class="text-3xl font-black text-slate-800"><?php echo e($acceptedRegistrations->count()); ?></h2>
                        <p class="text-[10px] text-slate-400 mt-1 font-medium">Siswa aktif yang sudah diterima</p>
                    </div>

                    <div class="bg-white p-5 border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-xs font-semibold text-slate-500">Rata-rata Kehadiran</p>
                            <div class="w-8 h-8 bg-emerald-50 text-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>
                        <h2 class="text-3xl font-black text-emerald-600"><?php echo e(number_format($averageAttendance, 1)); ?>%</h2>
                        <p class="text-[10px] text-emerald-600 mt-1 font-bold">Berdasarkan catatan masuk yang valid</p>
                        <div class="mt-3 h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full rounded-full" style="width: <?php echo e(min(100, max(0, $averageAttendance))); ?>%; background: linear-gradient(90deg, #f87171 0%, #facc15 55%, #22c55e 100%);"></div>
                        </div>
                    </div>

                    <div class="bg-white p-5 border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-xs font-semibold text-slate-500">Jadwal Bulan Ini</p>
                            <div class="w-8 h-8 bg-amber-50 text-amber-500 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                        <h2 class="text-3xl font-black text-slate-800">8</h2>
                        <p class="text-[10px] text-slate-400 mt-1 font-medium">4 latihan dan 4 agenda penting</p>
                    </div>

                    <div class="bg-white p-5 border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-xs font-semibold text-slate-500">Sertifikat</p>
                            <div class="w-8 h-8 bg-rose-50 text-rose-500 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                            </div>
                        </div>
                        <h2 class="text-3xl font-black text-slate-800">3</h2>
                        <p class="text-[10px] text-slate-400 mt-1 font-medium">Pengajuan dan penerbitan selesai</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 flex flex-col">
                            <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                                <h3 class="font-bold text-slate-800 text-base">Tren Kehadiran Siswa Bulan Ini</h3>
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block"></span> Kehadiran
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-3 items-end h-64">
                                <div class="flex flex-col items-center justify-end h-full gap-2">
                                    <span class="text-[10px] text-slate-400">50%</span>
                                    <div class="w-full bg-slate-100 rounded-t-xl h-[50%]"></div>
                                </div>
                                <div class="flex flex-col items-center justify-end h-full gap-2">
                                    <span class="text-[10px] text-slate-400">65%</span>
                                    <div class="w-full bg-slate-100 rounded-t-xl h-[65%]"></div>
                                </div>
                                <div class="flex flex-col items-center justify-end h-full gap-2">
                                    <span class="text-[10px] text-slate-400">55%</span>
                                    <div class="w-full bg-slate-100 rounded-t-xl h-[55%]"></div>
                                </div>
                                <div class="flex flex-col items-center justify-end h-full gap-2">
                                    <span class="text-[10px] text-slate-400">75%</span>
                                    <div class="w-full bg-slate-100 rounded-t-xl h-[75%]"></div>
                                </div>
                                <div class="flex flex-col items-center justify-end h-full gap-2">
                                    <span class="text-[10px] text-slate-400">60%</span>
                                    <div class="w-full bg-slate-100 rounded-t-xl h-[60%]"></div>
                                </div>
                                <div class="flex flex-col items-center justify-end h-full gap-2">
                                    <span class="text-[10px] text-slate-400">90%</span>
                                    <div class="w-full bg-blue-600 rounded-t-xl h-[90%]"></div>
                                </div>
                                <div class="flex flex-col items-center justify-end h-full gap-2">
                                    <span class="text-[10px] text-slate-400">83%</span>
                                    <div class="w-full bg-slate-100 rounded-t-xl h-[83%]"></div>
                                </div>
                                <div class="flex flex-col items-center justify-end h-full gap-2">
                                    <span class="text-[10px] text-slate-400">96%</span>
                                    <div class="w-full bg-blue-600 rounded-t-xl h-[96%]"></div>
                                </div>
                                <div class="flex flex-col items-center justify-end h-full gap-2">
                                    <span class="text-[10px] text-slate-400">88%</span>
                                    <div class="w-full bg-slate-100 rounded-t-xl h-[88%]"></div>
                                </div>
                                <div class="flex flex-col items-center justify-end h-full gap-2">
                                    <span class="text-[10px] text-slate-400">91%</span>
                                    <div class="w-full bg-slate-100 rounded-t-xl h-[91%]"></div>
                                </div>
                                <div class="flex flex-col items-center justify-end h-full gap-2">
                                    <span class="text-[10px] text-slate-400">94%</span>
                                    <div class="w-full bg-blue-600 rounded-t-xl h-[94%]"></div>
                                </div>
                                <div class="flex flex-col items-center justify-end h-full gap-2">
                                    <span class="text-[10px] text-slate-400">97%</span>
                                    <div class="w-full bg-blue-600 rounded-t-xl h-[97%]"></div>
                                </div>
                            </div>

                            <div class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span>Jan</span>
                                    <span>Feb</span>
                                    <span>Mar</span>
                                    <span>Apr</span>
                                    <span>Mei</span>
                                    <span>Jun</span>
                                    <span>Jul</span>
                                    <span>Agu</span>
                                    <span>Sep</span>
                                    <span>Okt</span>
                                    <span>Nov</span>
                                    <span>Des</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                            <h3 class="font-bold text-slate-800 text-sm mb-5">Aksi Cepat Pembina</h3>
                            <div class="space-y-3">
                                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-xl text-sm font-medium flex items-center gap-3 transition shadow-md shadow-blue-600/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Buat Jadwal Baru
                                </button>
                                <button class="w-full bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 py-2.5 px-4 rounded-xl text-sm font-medium flex items-center gap-3 transition">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Ambil Kehadiran
                                </button>
                                <button class="w-full bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 py-2.5 px-4 rounded-xl text-sm font-medium flex items-center gap-3 transition">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                    Buat Pengumuman
                                </button>
                            </div>
                        </div>

                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                            <h3 class="font-bold text-slate-800 text-sm mb-5">Jadwal Kegiatan Terdekat</h3>
                            <div class="space-y-4">
                                <div class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50/50">
                                    <div class="bg-blue-50 text-blue-600 p-2.5 rounded-xl text-center font-bold text-xs uppercase min-w-[50px]">
                                        <span class="block text-[10px] text-gray-400">Selasa</span> 17
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800">Latihan Taktik</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">15:00 - 17:30 • Lapangan Utama</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50/50">
                                    <div class="bg-blue-50 text-blue-600 p-2.5 rounded-xl text-center font-bold text-xs uppercase min-w-[50px]">
                                        <span class="block text-[10px] text-gray-400">Kamis</span> 19
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800">Uji Tanding</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">14:30 - 17:00 • Stadion Mini</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-anggota" class="hidden space-y-8">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Data Pendaftar & Anggota Ekstrakurikuler</h2>
                            <p class="text-sm text-slate-500 mt-1">Kelola siswa yang menunggu persetujuan serta data anggota yang sudah diterima.</p>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full"><?php echo e($acceptedRegistrations->count()); ?> Anggota</span>
                    </div>

                    <?php if($pendingRegistrations->count()): ?>
                        <div class="mb-8">
                            <h3 class="text-sm font-bold text-slate-800 mb-3">Pendaftar Menunggu Persetujuan</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-left border border-slate-200 rounded-2xl overflow-hidden">
                                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-600">
                                        <tr>
                                            <th class="px-4 py-3">Nama</th>
                                            <th class="px-4 py-3">Ekskul</th>
                                            <th class="px-4 py-3">Kelas</th>
                                            <th class="px-4 py-3">Status</th>
                                            <th class="px-4 py-3 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white text-sm text-slate-700">
                                        <?php $__currentLoopData = $pendingRegistrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pending): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="px-4 py-3 font-medium"><?php echo e($pending->user->name ?? '-'); ?></td>
                                                <td class="px-4 py-3"><?php echo e($pending->ekskul->title ?? '-'); ?></td>
                                                <td class="px-4 py-3"><?php echo e($pending->user->class_name ?? '-'); ?></td>
                                                <td class="px-4 py-3">
                                                    <span class="bg-amber-50 text-amber-600 text-xs px-2.5 py-1 rounded-full font-medium">Pending</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex justify-end gap-2">
                                                        <form action="<?php echo e(route('registration.accept', $pending->id)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit" class="rounded-full bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700">Terima</button>
                                                        </form>
                                                        <form action="<?php echo e(route('registration.reject', $pending->id)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit" class="rounded-full bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-rose-700">Tolak</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="mb-8 rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-5 text-sm text-slate-500">
                            Tidak ada pendaftar yang menunggu persetujuan.
                        </div>
                    <?php endif; ?>

                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-3">Anggota Aktif</h3>
                        <?php if($acceptedRegistrations->count()): ?>
                            <div class="space-y-3">
                                <?php $__currentLoopData = $acceptedRegistrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between gap-4 border border-slate-200 rounded-2xl p-4">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo e($registration->user && $registration->user->avatar_path ? asset('storage/' . $registration->user->avatar_path) : 'https://ui-avatars.com/api/?name=' . urlencode($registration->user->name ?? 'User') . '&background=0D8ABC&color=fff'); ?>" class="w-12 h-12 rounded-full object-cover border border-slate-200" alt="<?php echo e($registration->user->name ?? 'User'); ?>">
                                            <div>
                                                <h3 class="font-bold text-slate-800"><?php echo e($registration->user->name ?? '-'); ?></h3>
                                                <p class="text-xs text-slate-500"><?php echo e($registration->user->class_name ?? '-'); ?> • <?php echo e($registration->ekskul->title ?? '-'); ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <?php
                                                $memberAttendance = $registration->attendanceRecords->where('status', 'hadir')->count();
                                                $memberTotalAttendance = $registration->attendanceRecords->count();
                                                $memberAttendancePercent = $memberTotalAttendance > 0 ? round(($memberAttendance / $memberTotalAttendance) * 100, 1) : 0;
                                            ?>
                                            <span class="text-sm font-semibold <?php echo e($memberAttendancePercent >= 80 ? 'text-emerald-600' : 'text-amber-600'); ?>"><?php echo e($memberAttendancePercent); ?>% hadir</span>
                                            <span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded-full font-medium">Aktif</span>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-sm text-slate-500">
                                Belum ada anggota yang diterima.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div id="tab-ekskul" class="hidden space-y-8">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Ekskul Saya</h2>
                            <p class="text-sm text-slate-500 mt-1">Tambah eskul baru, kelola siswa yang terdaftar, dan lihat detail kegiatan.</p>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full">3 Eskul</span>
                    </div>

                    <div class="grid grid-cols-1 xl:grid-cols-[1.2fr_1.8fr] gap-6">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 min-w-0">
                            <h3 class="text-base font-bold text-slate-800 mb-4">Tambah Eskul Baru</h3>
                            <form action="<?php echo e(route('ekskul.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                                <?php echo csrf_field(); ?>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Eskul</label>
                                    <input type="text" name="title" placeholder="Contoh: Futsal" required class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-4 py-3 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                                    <input type="text" name="category" placeholder="Contoh: Olahraga" required class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-4 py-3 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                                    <textarea name="description" rows="5" placeholder="Tuliskan deskripsi singkat kegiatan eskul..." class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-4 py-3 text-sm resize-y"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar Eskul</label>
                                    <input type="file" name="image" accept="image/*" class="block w-full text-sm text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
                                    Simpan Eskul
                                </button>
                            </form>
                        </div>

                        <div class="space-y-4 min-w-0">
                            <?php if(isset($ekskuls) && $ekskuls->count()): ?>
                                <?php $__currentLoopData = $ekskuls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ekskul): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm min-w-0">
                                        <div class="flex items-start gap-4 mb-3">
                                            <?php if($ekskul->image): ?>
                                                <?php
                                                    $ekskulImageUrl = \Illuminate\Support\Str::startsWith((string) $ekskul->image, ['http://', 'https://', '/'])
                                                        ? $ekskul->image
                                                        : \Illuminate\Support\Facades\Storage::url($ekskul->image);
                                                ?>
                                                <img src="<?php echo e($ekskulImageUrl); ?>" alt="<?php echo e($ekskul->title); ?>" class="w-20 h-20 object-cover rounded-xl border border-slate-200">
                                            <?php endif; ?>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between gap-3">
                                                    <div class="min-w-0">
                                                        <h3 class="font-bold text-slate-800 break-words"><?php echo e($ekskul->title); ?></h3>
                                                        <p class="text-xs text-slate-500 break-words"><?php echo e($ekskul->category); ?> • <?php echo e($ekskul->coach); ?></p>
                                                    </div>
                                                    <span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded-full font-medium shrink-0"><?php echo e($ekskul->registrations->count()); ?> Siswa</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-sm text-slate-600 mb-4 break-words whitespace-pre-line"><?php echo e($ekskul->description ?: 'Belum ada deskripsi.'); ?></p>
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <?php if($ekskul->registrations && $ekskul->registrations->count()): ?>
                                                <?php $__currentLoopData = $ekskul->registrations->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full"><?php echo e($registration->user->name ?? 'Siswa'); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full">Belum ada siswa</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <a href="#detail-<?php echo e($ekskul->id); ?>" class="inline-flex items-center justify-center rounded-full bg-blue-50 text-blue-700 px-3 py-1.5 text-xs font-semibold hover:bg-blue-100 transition-colors">Lihat</a>
                                            <a href="#edit-<?php echo e($ekskul->id); ?>" class="inline-flex items-center justify-center rounded-full bg-amber-50 text-amber-700 px-3 py-1.5 text-xs font-semibold hover:bg-amber-100 transition-colors">Edit</a>
                                            <form action="<?php echo e(route('ekskul.delete', $ekskul->id)); ?>" method="POST" onsubmit="return confirm('Hapus eskul ini?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-rose-50 text-rose-700 px-3 py-1.5 text-xs font-semibold hover:bg-rose-100 transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>

                                        <div id="detail-<?php echo e($ekskul->id); ?>" class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                                            <p class="font-semibold text-slate-800 mb-2">Detail Ekskul</p>
                                            <p class="break-words whitespace-pre-line"><?php echo e($ekskul->description ?: 'Belum ada detail deskripsi.'); ?></p>
                                        </div>

                                        <form id="edit-<?php echo e($ekskul->id); ?>" action="<?php echo e(route('ekskul.update', $ekskul->id)); ?>" method="POST" enctype="multipart/form-data" class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4 space-y-3">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <p class="font-semibold text-slate-800">Edit Ekskul</p>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Ekskul</label>
                                                <input type="text" name="title" value="<?php echo e(old('title', $ekskul->title)); ?>" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-3 py-2 text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori</label>
                                                <input type="text" name="category" value="<?php echo e(old('category', $ekskul->category)); ?>" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-3 py-2 text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi</label>
                                                <textarea name="description" rows="4" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-3 py-2 text-sm resize-y"><?php echo e(old('description', $ekskul->description)); ?></textarea>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Ganti Gambar</label>
                                                <input type="file" name="image" accept="image/*" class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            </div>
                                            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700 transition-colors">
                                                Simpan Perubahan
                                            </button>
                                        </form>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-5 text-sm text-slate-500">
                                    Belum ada data eskul yang dibuat oleh guru.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>

            <div id="tab-jadwal" class="hidden space-y-8">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Jadwal Latihan</h2>
                            <p class="text-sm text-slate-500 mt-1">Pengaturan sesi latihan dan jadwal penting untuk siswa.</p>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full">8 Sesi</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs font-semibold uppercase tracking-wider text-blue-600">Selasa</p>
                            <h3 class="mt-2 text-lg font-bold text-slate-800">Latihan Taktik</h3>
                            <p class="mt-2 text-sm text-slate-600">15:00 - 17:30</p>
                            <p class="text-sm text-slate-500">Lapangan Utama</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs font-semibold uppercase tracking-wider text-blue-600">Kamis</p>
                            <h3 class="mt-2 text-lg font-bold text-slate-800">Uji Tanding</h3>
                            <p class="mt-2 text-sm text-slate-600">14:30 - 17:00</p>
                            <p class="text-sm text-slate-500">Stadion Mini</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs font-semibold uppercase tracking-wider text-blue-600">Sabtu</p>
                            <h3 class="mt-2 text-lg font-bold text-slate-800">Kondisi Fisik</h3>
                            <p class="mt-2 text-sm text-slate-600">08:00 - 10:00</p>
                            <p class="text-sm text-slate-500">Gymnasium Sekolah</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-kehadiran" class="hidden space-y-8">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Rekap Kehadiran</h2>
                            <p class="text-sm text-slate-500 mt-1">Semua pencatatan kehadiran anggota ekstrakurikuler yang sudah diterima.</p>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full"><?php echo e($acceptedRegistrations->sum(fn($reg) => $reg->attendanceRecords->count())); ?> Catatan</span>
                    </div>

                    <?php if($acceptedRegistrations->count()): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $acceptedRegistrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $registration->attendanceRecords->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 flex items-center justify-between gap-4">
                                        <div>
                                            <h3 class="font-bold text-slate-800"><?php echo e($registration->user->name ?? '-'); ?></h3>
                                            <p class="text-sm text-slate-500"><?php echo e($attendance->attendance_date->translatedFormat('l, d F Y')); ?> • <?php echo e(ucfirst(str_replace('_', ' ', $attendance->status))); ?></p>
                                        </div>
                                        <span class="text-xs px-2.5 py-1 rounded-full font-bold
                                            <?php if($attendance->status === 'hadir'): ?> bg-emerald-50 text-emerald-600
                                            <?php elseif($attendance->status === 'sakit_izin'): ?> bg-amber-50 text-amber-600
                                            <?php else: ?> bg-rose-50 text-rose-600 <?php endif; ?>">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $attendance->status))); ?>

                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-sm text-slate-500">
                            Belum ada data kehadiran untuk anggota yang diterima.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div id="tab-nilai" class="hidden space-y-8">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Nilai & Rapor Ekstrakurikuler</h2>
                            <p class="text-sm text-slate-500 mt-1">Nilai siswa per hari. Guru bisa menambah atau mengedit penilaian pada hari yang sama dengan skala 0–100.</p>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-violet-600 bg-violet-50 px-3 py-1 rounded-full"><?php echo e($evaluations->count()); ?> Data</span>
                    </div>

                    <div class="space-y-5">
                        <?php $__currentLoopData = $acceptedRegistrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $studentEvaluationsForRegistration = $registration->evaluations()->orderByDesc('evaluation_date')->get();
                                $latestEvaluation = $studentEvaluationsForRegistration->first();
                            ?>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-800"><?php echo e($registration->user->name ?? '-'); ?></h3>
                                        <p class="text-sm text-slate-500"><?php echo e($registration->ekskul->title ?? '-'); ?> • <?php echo e($registration->user->class_name ?? 'Belum ada kelas'); ?></p>
                                    </div>
                                    <?php if($latestEvaluation): ?>
                                        <?php
                                            $score = (int) $latestEvaluation->score;
                                            $grade = $score >= 90 ? 'A' : ($score >= 80 ? 'B' : ($score >= 70 ? 'C' : ($score >= 60 ? 'D' : 'F')));
                                            $gradeClass = $score >= 90 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($score >= 80 ? 'bg-blue-50 text-blue-700 border border-blue-200' : ($score >= 70 ? 'bg-amber-50 text-amber-700 border border-amber-200' : ($score >= 60 ? 'bg-orange-50 text-orange-700 border border-orange-200' : 'bg-rose-50 text-rose-700 border border-rose-200')));
                                        ?>
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold <?php echo e($gradeClass); ?>">Nilai terakhir: <?php echo e($score); ?> (<?php echo e($grade); ?>)</span>
                                    <?php endif; ?>
                                </div>

                                <form action="<?php echo e(route('evaluation.store', $registration->id)); ?>" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
                                    <?php echo csrf_field(); ?>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal</label>
                                        <input type="date" name="evaluation_date" value="<?php echo e(old('evaluation_date', $latestEvaluation?->evaluation_date?->format('Y-m-d') ?? now()->toDateString())); ?>" required class="w-full rounded-xl border-slate-200 focus:border-violet-500 focus:ring-violet-500 px-3 py-2.5 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai (0-100)</label>
                                        <input type="number" name="score" min="0" max="100" value="<?php echo e(old('score', $latestEvaluation?->score ?? 0)); ?>" required class="w-full rounded-xl border-slate-200 focus:border-violet-500 focus:ring-violet-500 px-3 py-2.5 text-sm">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan</label>
                                        <input type="text" name="notes" value="<?php echo e(old('notes', $latestEvaluation?->notes ?? '')); ?>" placeholder="Catatan evaluasi" class="w-full rounded-xl border-slate-200 focus:border-violet-500 focus:ring-violet-500 px-3 py-2.5 text-sm">
                                    </div>
                                    <div class="md:col-span-4 flex justify-end">
                                        <button type="submit" class="rounded-full bg-violet-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-violet-700 transition-colors">
                                            Simpan / Edit Nilai
                                        </button>
                                    </div>
                                </form>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <?php if($evaluations->count()): ?>
                        <div class="mt-8 overflow-x-auto">
                            <table class="min-w-full text-left border border-slate-200 rounded-2xl overflow-hidden">
                                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-600">
                                    <tr>
                                        <th class="px-4 py-3">Nama</th>
                                        <th class="px-4 py-3">Ekskul</th>
                                        <th class="px-4 py-3">Tanggal</th>
                                        <th class="px-4 py-3">Nilai</th>
                                        <th class="px-4 py-3">Huruf</th>
                                        <th class="px-4 py-3">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white text-sm text-slate-700">
                                    <?php $__currentLoopData = $evaluations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evaluation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $score = (int) ($evaluation->score ?? 0);
                                            $scoreGrade = $score >= 90 ? 'A' : ($score >= 80 ? 'B' : ($score >= 70 ? 'C' : ($score >= 60 ? 'D' : 'F')));
                                            $scoreColor = $score >= 90 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($score >= 80 ? 'bg-blue-50 text-blue-700 border border-blue-200' : ($score >= 70 ? 'bg-amber-50 text-amber-700 border border-amber-200' : ($score >= 60 ? 'bg-orange-50 text-orange-700 border border-orange-200' : 'bg-rose-50 text-rose-700 border border-rose-200')));
                                        ?>
                                        <tr>
                                            <td class="px-4 py-3 font-medium"><?php echo e($evaluation->user->name ?? '-'); ?></td>
                                            <td class="px-4 py-3"><?php echo e($evaluation->ekskul->title ?? '-'); ?></td>
                                            <td class="px-4 py-3"><?php echo e($evaluation->evaluation_date ? $evaluation->evaluation_date->translatedFormat('d F Y') : '-'); ?></td>
                                            <td class="px-4 py-3">
                                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold" style="background: linear-gradient(90deg, rgb(239,68,68) 0%, rgb(250,204,21) 50%, rgb(34,197,94) 100%); color: white;">
                                                    <?php echo e($score); ?>

                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold <?php echo e($scoreColor); ?>"><?php echo e($scoreGrade); ?></span>
                                            </td>
                                            <td class="px-4 py-3 max-w-xs break-words"><?php echo e($evaluation->notes ?: '-'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-sm text-slate-500">
                            Belum ada data evaluasi untuk ekstrakurikuler yang dibina.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div id="tab-profile" class="hidden">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6 mb-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Profil Pembina</h2>
                            <p class="text-sm text-slate-500 mt-1">Kelola nama, foto, nomor HP, dan bio singkat.</p>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Profil</span>
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
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Jabatan</label>
                                <input type="text" name="class_name" value="<?php echo e(old('class_name', $user->class_name)); ?>" placeholder="Pembina Futsal" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-4 py-3 text-sm">
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
                                <textarea name="bio" rows="4" maxlength="500" placeholder="Ceritakan fokus pembinaan dan pengalaman..." class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-4 py-3 text-sm"><?php echo e(old('bio', $user->bio)); ?></textarea>
                            </div>
                            <div class="md:col-span-2 flex items-center gap-3">
                                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">Simpan Profil</button>
                                <p class="text-xs text-slate-500">Perubahan akan langsung tersimpan di database pengguna.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="tab-settings" class="hidden space-y-8">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Pengaturan</h2>
                            <p class="text-sm text-slate-500 mt-1">Atur preferensi dasar dashboard pembina.</p>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-600 bg-slate-100 px-3 py-1 rounded-full">Settings</span>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Tema</p>
                            <h3 class="mt-2 text-lg font-bold text-slate-800">Mode Gelap</h3>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Notifikasi</p>
                            <h3 class="mt-2 text-lg font-bold text-slate-800">Aktif</h3>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Bahasa</p>
                            <h3 class="mt-2 text-lg font-bold text-slate-800">Indonesia</h3>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-5 text-sm text-slate-500">
                        Untuk sementara, menu pengaturan ini menampilkan ringkasan dasar saja. Nanti bisa ditambah opsi notifikasi, bahasa, dan preferensi tampilan.
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = {
                dashboard: document.getElementById('tab-dashboard'),
                anggota: document.getElementById('tab-anggota'),
                ekskul: document.getElementById('tab-ekskul'),
                jadwal: document.getElementById('tab-jadwal'),
                kehadiran: document.getElementById('tab-kehadiran'),
                nilai: document.getElementById('tab-nilai'),
                profile: document.getElementById('tab-profile'),
                settings: document.getElementById('tab-settings'),
            };

            const navItems = Array.from(document.querySelectorAll('[data-tab]'));

            function activateTab(name) {
                Object.entries(tabs).forEach(function ([tabName, element]) {
                    if (!element) return;
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

            const evaluationModal = document.getElementById('evaluation-modal');
            const evaluationForm = document.getElementById('evaluation-form');
            const closeEvaluationModal = document.getElementById('close-evaluation-modal');
            const cancelEvaluationModal = document.getElementById('cancel-evaluation-modal');

            document.querySelectorAll('.open-evaluation-modal').forEach(function (button) {
                button.addEventListener('click', function () {
                    const evaluationId = button.dataset.evaluationId;
                    const studentName = button.dataset.userName;
                    const ekskulTitle = button.dataset.ekskulTitle;
                    const score = button.dataset.score;
                    const date = button.dataset.date;
                    const notes = button.dataset.notes;

                    document.getElementById('modal-student-name').value = studentName;
                    document.getElementById('modal-ekskul-title').value = ekskulTitle;
                    document.getElementById('modal-score').value = score;
                    document.getElementById('modal-date').value = date;
                    document.getElementById('modal-notes').value = notes;

                    evaluationForm.action = `<?php echo e(url('/guru/evaluation')); ?>/${evaluationId}`;
                    evaluationModal.classList.remove('hidden');
                });
            });

            function hideEvaluationModal() {
                evaluationModal.classList.add('hidden');
                evaluationForm.reset();
            }

            closeEvaluationModal.addEventListener('click', hideEvaluationModal);
            cancelEvaluationModal.addEventListener('click', hideEvaluationModal);
            evaluationModal.addEventListener('click', function (event) {
                if (event.target === evaluationModal) {
                    hideEvaluationModal();
                }
            });

            const initialTab = window.location.hash.replace('#', '') || 'dashboard';
            activateTab(tabs[initialTab] ? initialTab : 'dashboard');
        });
    </script>

</body>
</html>
<?php /**PATH /home/lcfoxiii/Documents/EskulManager/resources/views/dashboard_guru.blade.php ENDPATH**/ ?>