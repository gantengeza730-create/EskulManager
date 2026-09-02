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
            <a href="/" class="p-6 flex items-center gap-3">
                <div class="bg-blue-500 p-2 rounded-lg text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="text-white font-bold text-lg tracking-wide">Ekskul<span class="text-blue-400">SMK</span></span>
            </a>

            <!-- Menu Navigasi -->
            <nav class="px-4 space-y-1 mt-2">
                <!-- Dashboard (Aktif) -->
                <a href="/dashboard" class="flex items-center gap-3 bg-[#2E3C51] text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-sm border border-[#3A4A62]">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                
                <!-- Menu Lainnya (Tidak Aktif) -->
                <a href="#" data-tab="ekskul" class="flex items-center justify-between text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                        Ekskul Saya
                    </div>
                    @php $ekskulCount = isset($registrations) ? $registrations->count() : 0; @endphp
                    @if($ekskulCount > 0)
                        <span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $ekskulCount }}</span>
                    @endif
                </a>
                <a href="#" data-tab="jadwal" class="flex items-center gap-3 text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
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
                <a href="#" data-tab="settings" class="flex items-center gap-3 text-slate-400 hover:text-white hover:bg-[#2E3C51]/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Pengaturan
                </a>
            </nav>
        </div>

        <!-- Profil Bawah (Logout) -->
        <div class="p-4 bg-[#182235] mt-8 flex justify-between items-center border-t border-slate-700/50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-slate-600 overflow-hidden border-2 border-slate-500">
                    @if($user->avatar_path)
                        <img src="{{ asset('storage/' . $user->avatar_path) }}" data-tab="profile" alt="User" class="w-full h-full object-cover cursor-pointer" title="Buka Profil Saya">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=0D8ABC&color=fff" data-tab="profile" alt="User" class="w-full h-full object-cover cursor-pointer" title="Buka Profil Saya">
                    @endif
                </div>
                <div>
                    <h4 class="text-white text-sm font-bold truncate w-32">{{ auth()->user()->name ?? 'Muhe Alyaaaaaa' }}</h4>
                    <p class="text-slate-400 text-[10px]">{{ $user->class_name ?? 'XII RPL 1' }}</p>
                </div>
            </div>
            
            <form action="/logout" method="POST">
                @csrf
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
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selamat Datang, {{ auth()->user()->name ?? 'M. Dimsum Shiruken' }}</h1>
                <p class="text-xs text-slate-500 mt-1 font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }} &bull; Periode Semester Genap</p>
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
                @if($user->avatar_path)
                    <img src="{{ asset('storage/' . $user->avatar_path) }}" data-tab="profile" class="w-9 h-9 rounded-full border border-slate-200 cursor-pointer shadow-sm object-cover" alt="Foto profil" title="Buka Profil Saya">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=0D8ABC&color=fff" data-tab="profile" class="w-9 h-9 rounded-full border border-slate-200 cursor-pointer shadow-sm object-cover" alt="Foto profil" title="Buka Profil Saya">
                @endif
            </div>
        </header>

        <!-- Area Konten Isi -->
        <div class="p-8">
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $resolveEkskulImage = function ($image) {
                    if (!$image) {
                        return null;
                    }

                    return \Illuminate\Support\Str::startsWith($image, ['http://', 'https://', '/'])
                        ? $image
                        : asset('storage/' . $image);
                };
            @endphp

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
                    <h2 class="text-3xl font-black text-slate-800">{{ isset($registrations) ? $registrations->count() : '0' }}</h2>
                    <p class="text-[10px] text-slate-400 mt-1 font-medium truncate">
                        {{ isset($registrations) && $registrations->count() ? $registrations->pluck('ekskul.title')->filter()->join(', ') : 'Belum ada ekskul diikuti' }}
                    </p>
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

            <div id="tab-ekskul" class="hidden space-y-8">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Ekstrakurikuler Saya</h2>
                            <p class="text-sm text-slate-500 mt-1">Daftar ekskul yang sudah kamu ikuti.</p>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full">{{ isset($registrations) ? $registrations->count() : 0 }} Ekskul</span>
                    </div>

                    @if(isset($registrations) && $registrations->count())
                        <div class="space-y-3">
                            @foreach($registrations as $registration)
                                <div class="flex items-center justify-between gap-4 p-4 rounded-2xl border border-slate-200 bg-slate-50/70">
                                    <div class="flex items-center gap-4 min-w-0">
                                        <div class="w-14 h-14 rounded-2xl bg-slate-200 overflow-hidden shrink-0">
                                            @if($registration->ekskul && $registration->ekskul->image)
                                                <img src="{{ $resolveEkskulImage($registration->ekskul->image) }}" alt="{{ $registration->ekskul->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-blue-50 text-blue-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="text-sm font-bold text-slate-900 truncate">{{ $registration->ekskul->title ?? 'Ekskul' }}</h3>
                                            <p class="text-xs text-slate-500 truncate">Pembina: {{ $registration->ekskul->coach ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 shrink-0">
                                        <span class="text-xs font-medium text-slate-400 capitalize">{{ $registration->status }}</span>
                                        @if(auth()->user()->role === 'siswa')
                                            <form action="{{ route('ekskul.cancel', $registration->ekskul_id) }}" method="POST" onsubmit="return confirm('Batalkan pendaftaran ekskul ini?')">
                                                @csrf
                                                <button type="submit" class="rounded-full border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-100 transition-colors">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <details class="mt-4 rounded-2xl border border-slate-200 bg-white/80 px-4 py-3">
                                    <summary class="cursor-pointer list-none text-xs font-semibold text-slate-700 flex items-center justify-between gap-3">
                                        <span>Tampilan Jadwal Kegiatan Ekstrakurikuler</span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600">Lihat</span>
                                    </summary>
                                    <div class="mt-4 space-y-3 border-t border-slate-100 pt-4 text-sm text-slate-600">
                                        <div>
                                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Jadwal 1</p>
                                            <p class="mt-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Jadwal 2</p>
                                            <p class="mt-1">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Jadwal 3</p>
                                            <p class="mt-1">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                        </div>
                                    </div>
                                </details>
                                <details class="mt-3 rounded-2xl border border-slate-200 bg-white/80 px-4 py-3">
                                    <summary class="cursor-pointer list-none text-xs font-semibold text-slate-700 flex items-center justify-between gap-3">
                                        <span>Detail Ekstrakurikuler</span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Info</span>
                                    </summary>
                                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-slate-100 pt-4 text-sm text-slate-600">
                                        <div class="rounded-xl bg-slate-50 p-4">
                                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Info</p>
                                            <p class="mt-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante venenatis dapibus.</p>
                                        </div>
                                        <div class="rounded-xl bg-slate-50 p-4">
                                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Syarat</p>
                                            <ul class="mt-2 list-disc pl-4 space-y-1">
                                                <li>Lorem ipsum dolor sit amet.</li>
                                                <li>Consectetur adipiscing elit.</li>
                                                <li>Sed do eiusmod tempor incididunt.</li>
                                            </ul>
                                        </div>
                                        <div class="rounded-xl bg-slate-50 p-4">
                                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Anggota</p>
                                            @php
                                                $members = isset($ekskulMembers)
                                                    ? $ekskulMembers->where('ekskul_id', $registration->ekskul_id)->pluck('user.name')->filter()->unique()
                                                    : collect();
                                            @endphp
                                            @if($members->count())
                                                <ul class="mt-2 space-y-1">
                                                    @foreach($members as $member)
                                                        <li class="rounded-lg bg-white px-3 py-2 text-slate-700 border border-slate-200">{{ $member }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="mt-2">Belum ada anggota yang terdaftar.</p>
                                            @endif
                                        </div>
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-sm text-slate-500">
                            Belum ada ekskul yang diikuti.
                        </div>
                    @endif
                </div>

                @if(auth()->user()->role === 'siswa')
                    <div id="formulir-pendaftaran" class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6">
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">Formulir Pendaftaran Ekstrakurikuler</h2>
                                <p class="text-sm text-slate-500 mt-1">Pilih ekskul yang tersedia untuk mengajukan pendaftaran baru.</p>
                            </div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Student Only</span>
                        </div>

                        @if(isset($ekskuls) && $ekskuls->count())
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                                @foreach($ekskuls as $ekskul)
                                    <form action="{{ route('ekskul.join', $ekskul->id) }}" method="POST" class="rounded-2xl border border-slate-200 p-4 bg-slate-50/70 hover:bg-white transition-colors">
                                        @csrf
                                        <div class="flex items-start gap-4">
                                            <div class="w-14 h-14 rounded-2xl bg-blue-100 overflow-hidden shrink-0 flex items-center justify-center">
                                                @if($ekskul->image)
                                                    <img src="{{ $resolveEkskulImage($ekskul->image) }}" alt="{{ $ekskul->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h3 class="font-bold text-slate-900 truncate">{{ $ekskul->title }}</h3>
                                                <p class="text-xs text-slate-500 mt-1">Pembina: {{ $ekskul->coach }}</p>
                                                <p class="text-xs text-slate-400 mt-1">{{ $ekskul->category }}</p>
                                            </div>
                                        </div>

                                        <p class="text-sm text-slate-600 mt-4 line-clamp-3">{{ $ekskul->description }}</p>

                                        @php
                                            $alreadyJoined = isset($registrations) && $registrations->contains('ekskul_id', $ekskul->id);
                                        @endphp

                                        <div class="mt-4 flex items-center justify-between gap-3">
                                            <span class="text-xs font-semibold {{ $alreadyJoined ? 'text-emerald-600' : 'text-slate-400' }}">
                                                {{ $alreadyJoined ? 'Sudah terdaftar' : 'Belum terdaftar' }}
                                            </span>
                                            @if($alreadyJoined)
                                                <button type="button" disabled class="inline-flex items-center justify-center rounded-full px-4 py-2 text-xs font-semibold text-white bg-slate-400 cursor-not-allowed transition-colors">
                                                    Terdaftar
                                                </button>
                                            @else
                                                <button type="submit" class="inline-flex items-center justify-center rounded-full px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                                    Daftar
                                                </button>
                                            @endif
                                        </div>
                                    </form>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-sm text-slate-500">
                                Belum ada data ekskul untuk didaftarkan.
                            </div>
                        @endif
                    </div>
                @endif
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

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-6 items-start">
                        @csrf
                        <div class="flex flex-col items-center text-center gap-4">
                            <div class="w-36 h-36 rounded-full overflow-hidden border-4 border-slate-100 shadow-sm bg-slate-100">
                                @if($user->avatar_path)
                                    <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="Foto profil" class="w-full h-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'User') }}&background=0D8ABC&color=fff&size=256" alt="Foto profil" class="w-full h-full object-cover">
                                @endif
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
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-4 py-3 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Kelas</label>
                                <input type="text" name="class_name" value="{{ old('class_name', $user->class_name) }}" placeholder="XII RPL 1" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-4 py-3 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                                <input type="email" value="{{ $user->email }}" class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-sm" disabled>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">No. HP</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-4 py-3 text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Bio Singkat</label>
                                <textarea name="bio" rows="4" maxlength="500" placeholder="Ceritakan minat atau targetmu di ekskul..." class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 px-4 py-3 text-sm">{{ old('bio', $user->bio) }}</textarea>
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
                            <h2 class="text-lg font-bold text-slate-900">Pengaturan</h2>
                            <p class="text-sm text-slate-500 mt-1">Kelola preferensi akun dan tampilan dasar dashboard.</p>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-600 bg-slate-100 px-3 py-1 rounded-full">Settings</span>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Akun</p>
                            <h3 class="mt-2 font-bold text-slate-900">Informasi Profil</h3>
                            <p class="mt-2 text-sm text-slate-600">Nama, kelas, nomor HP, dan bio bisa diubah dari tab Profil Saya.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Notifikasi</p>
                            <h3 class="mt-2 font-bold text-slate-900">Aktivitas Ekskul</h3>
                            <p class="mt-2 text-sm text-slate-600">Lorem ipsum dolor sit amet, pengumuman, jadwal, dan perubahan status pendaftaran.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Tampilan</p>
                            <h3 class="mt-2 font-bold text-slate-900">Mode Dashboard</h3>
                            <p class="mt-2 text-sm text-slate-600">Lorem ipsum dolor sit amet, tema sederhana, kartu ringkas, dan navigasi sidebar aktif.</p>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-5 text-sm text-slate-500">
                        Untuk sementara, menu pengaturan ini menampilkan ringkasan dasar saja. Nanti bisa ditambah opsi notifikasi, bahasa, dan preferensi tampilan.
                    </div>
                </div>
            </div>

            <div id="tab-jadwal" class="hidden space-y-8">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Jadwal Latihan</h2>
                            <p class="text-sm text-slate-500 mt-1">Jadwal kegiatan hanya untuk ekskul yang sudah kamu terdaftar.</p>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Registered Only</span>
                    </div>

                    @if(isset($registrations) && $registrations->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach($registrations as $registration)
                                <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-5">
                                    <div class="flex items-start justify-between gap-3 mb-4">
                                        <div>
                                            <h3 class="font-bold text-slate-900">{{ $registration->ekskul->title ?? 'Ekskul' }}</h3>
                                            <p class="text-xs text-slate-500 mt-1">Pembina: {{ $registration->ekskul->coach ?? '-' }}</p>
                                        </div>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">{{ $registration->status }}</span>
                                    </div>

                                    <div class="space-y-3 text-sm text-slate-600">
                                        <div class="rounded-xl bg-white border border-slate-200 p-3">
                                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Jadwal 1</p>
                                            <p class="mt-1">Lorem ipsum dolor sit amet, Senin 15.00 - 17.00 WIB, lokasi latihan utama.</p>
                                        </div>
                                        <div class="rounded-xl bg-white border border-slate-200 p-3">
                                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Jadwal 2</p>
                                            <p class="mt-1">Lorem ipsum dolor sit amet, Rabu 15.30 - 17.30 WIB, pemantapan materi dan simulasi.</p>
                                        </div>
                                        <div class="rounded-xl bg-white border border-slate-200 p-3">
                                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Jadwal 3</p>
                                            <p class="mt-1">Lorem ipsum dolor sit amet, Jumat 14.00 - 16.00 WIB, evaluasi mingguan anggota.</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-sm text-slate-500">
                            Belum ada ekskul yang diikuti, jadi jadwal latihan belum tersedia.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = {
                dashboard: document.getElementById('tab-dashboard'),
                jadwal: document.getElementById('tab-jadwal'),
                ekskul: document.getElementById('tab-ekskul'),
                profile: document.getElementById('tab-profile'),
                settings: document.getElementById('tab-settings'),
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
</html>