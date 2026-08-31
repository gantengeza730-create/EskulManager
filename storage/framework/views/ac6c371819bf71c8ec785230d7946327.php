<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru - EkskulSMK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white min-h-screen flex antialiased">

    <!-- Kolom Kiri: Form Pendaftaran -->
    <div class="w-full lg:w-1/2 p-8 md:p-12 lg:p-16 flex flex-col justify-center overflow-y-auto">
        <div class="max-w-md w-full mx-auto">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 mb-2 tracking-tight">Buat Akun Baru</h1>
                <p class="text-slate-500 text-sm">Daftarkan diri Anda untuk memulai perjalanan digital ini.</p>
            </div>

            <!-- Pesan Error Validasi -->
            <?php if($errors->any()): ?>
                <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-6 border border-red-200">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/register" method="POST">
                <?php echo csrf_field(); ?>

                <!-- INPUT TERSEMBUNYI UNTUK MENYIMPAN ROLE -->
                <input type="hidden" name="role" id="roleInput" value="siswa">

                <!-- Label & Tombol Pilih Peran -->
                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Peran Anda</label>
                    <div class="flex bg-slate-100 p-1 rounded-xl">
                        <button type="button" onclick="setRole('siswa')" id="btn_siswa" class="flex-1 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-semibold shadow-sm transition-all">
                            Siswa
                        </button>
                        <button type="button" onclick="setRole('guru')" id="btn_guru" class="flex-1 py-2.5 rounded-lg text-slate-600 hover:text-slate-900 text-sm font-semibold transition-all">
                            Guru
                        </button>
                        <button type="button" onclick="setRole('admin')" id="btn_admin" class="flex-1 py-2.5 rounded-lg text-slate-600 hover:text-slate-900 text-sm font-semibold transition-all">
                            Admin
                        </button>
                    </div>
                </div>

                <!-- Input Nama Lengkap -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Contoh: Muhee Suaminya Intan" 
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-800 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>

                <!-- Input Nomor Induk Siswa (NIS) -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Induk Siswa (NIS)</label>
                    <input type="text" name="nis" placeholder="Contoh: 8471" 
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-800 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>

                <!-- Input Email Sekolah -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Sekolah</label>
                    <input type="email" name="email" required placeholder="muheealya@gmail.com" 
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-800 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>

                <!-- Input Password -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter" 
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-800 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>

                <!-- Input Kelas (Sesuai Gambar Screenshot 23) -->
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kelas</label>
                    <input type="text" name="class" placeholder="Contoh: XII RPL 1" 
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-800 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>

                <!-- Checkbox Syarat & Ketentuan -->
                <div class="mb-6 flex items-center gap-2">
                    <input type="checkbox" required id="syarat" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <label for="syarat" class="text-xs text-slate-600">
                        Saya menyetujui <a href="#" class="text-blue-600 font-medium hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-blue-600 font-medium hover:underline">Kebijakan Privasi</a>.
                    </label>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-md shadow-blue-600/20 text-sm">
                    Daftar Sekarang
                </button>
            </form>

            <p class="mt-6 text-center text-xs text-slate-500">
                Sudah punya akun? <a href="/login" class="text-blue-600 font-bold hover:underline">Masuk</a>
            </p>
        </div>
    </div>

    <!-- Kolom Kanan: Banner Estetik Biru Gelap (Sesuai Screenshot 23) -->
    <div class="hidden lg:flex w-1/2 bg-[#0A1628] text-white p-16 flex-col justify-between relative overflow-hidden">
        <!-- Logo & Brand -->
        <div class="flex items-center gap-2.5 font-bold text-lg text-white z-10">
            <span class="bg-blue-600 text-white p-2 rounded-xl text-sm shadow-md">🎓</span> EkskulSMK
        </div>

        <!-- Teks Utama Banner -->
        <div class="z-10 max-w-lg space-y-4">
            <h2 class="text-4xl lg:text-5xl font-extrabold tracking-tight leading-[1.15]">
                Langkah Awal Menuju <br>Eksplorasi Tiada Batas
            </h2>
            <p class="text-slate-400 text-sm leading-relaxed">
                Daftar hari ini dan gabung dengan ribuan siswa kreatif lainnya. Kembangkan softskills kepemimpinan, olahraga, seni, dan teknologi digital.
            </p>
        </div>

        <!-- Kotak Statistik di Bawah Banner -->
        <div class="grid grid-cols-2 gap-6 bg-[#11223A]/80 border border-slate-800/80 backdrop-blur-md p-6 rounded-2xl z-10">
            <div>
                <h3 class="text-2xl font-extrabold text-white">15+</h3>
                <p class="text-[11px] text-slate-400 mt-0.5 leading-tight">Pilihan Ekstrakurikuler Berjalan</p>
            </div>
            <div>
                <h3 class="text-2xl font-extrabold text-white">323+</h3>
                <p class="text-[11px] text-slate-400 mt-0.5 leading-tight">Siswa Aktif Berpartisipasi</p>
            </div>
        </div>
    </div>

    <!-- Script JavaScript untuk Interaksi Tombol Role -->
    <script>
        function setRole(role) {
            // 1. Masukkan nilai role ke input hidden
            document.getElementById('roleInput').value = role;

            // 2. Reset semua tombol ke warna abu-abu netral
            const roles = ['siswa', 'guru', 'admin'];
            roles.forEach(r => {
                const btn = document.getElementById('btn_' + r);
                btn.className = 'flex-1 py-2.5 rounded-lg text-slate-600 hover:text-slate-900 text-sm font-semibold transition-all';
            });

            // 3. Beri warna biru aktif ke tombol yang sedang diklik
            const activeBtn = document.getElementById('btn_' + role);
            activeBtn.className = 'flex-1 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-semibold shadow-sm transition-all';
        }
    </script>
</body>
</html><?php /**PATH /home/lcfoxiii/Documents/EskulManager/resources/views/auth/register.blade.php ENDPATH**/ ?>