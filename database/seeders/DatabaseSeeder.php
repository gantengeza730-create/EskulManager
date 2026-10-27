<?php

namespace Database\Seeders;

use App\Models\{Announcement, Assessment, Attendance, Certificate, Ekskul, Registration, Room, Schedule, User};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('email', 'admin@sekolah.test')->exists()) {
            return;
        }

        $now = now();
        $mk = fn ($name, $email, $role, $extra = []) => User::create([
            'name' => $name, 'email' => $email, 'role' => $role, 'password' => 'password',
            'email_verified_at' => $now, 'is_active' => true,
        ] + $extra);

        // ---- Akun (kata sandi semua: password) ----
        $admin = $mk('Admin Utama', 'admin@sekolah.test', 'admin');
        $pNur = $mk('Nur Hidayat, S.Pd', 'nur@sekolah.test', 'pembina', ['phone' => '0812-1111-2222']);
        $pSiti = $mk('Siti Aminah, S.Pd', 'siti@sekolah.test', 'pembina');
        $pDedi = $mk('Dedi Kurniawan, S.Kom', 'dedi@sekolah.test', 'pembina');
        $pRina = $mk('Rina Marlina, S.Pd', 'rina@sekolah.test', 'pembina');

        $names = [
            ['Ahmad Fadillah Rasyid', 'XII RPL 1'], ['Bagas Setiawan', 'XII TKJ 2'], ['Candra Wijaya', 'XI RPL 2'],
            ['Dimas Prayoga', 'XI MM 1'], ['Eka Saputra', 'X RPL 1'], ['Fajar Nugroho', 'XII TKJ 1'],
            ['Gilang Ramadhan', 'XI TKJ 2'], ['Hendra Kurniawan', 'X MM 2'], ['Irfan Maulana', 'XII RPL 2'],
            ['Joko Susilo', 'XI RPL 1'], ['Nabila Putri Andini', 'XI MM 1'], ['Raka Firmansyah', 'X RPL 2'],
            ['Salsabila Rahmawati', 'X MM 2'], ['Dewi Anggraini', 'XI RPL 1'], ['Intan Permatasari', 'X RPL 1'],
        ];
        $siswa = [];
        foreach ($names as $i => [$n, $k]) {
            $siswa[] = $mk($n, 'siswa' . ($i + 1) . '@sekolah.test', 'siswa', ['nis' => '2324' . str_pad($i + 1, 3, '0', STR_PAD_LEFT), 'kelas' => $k]);
        }

        // ---- Ekskul ----
        $mkE = fn ($name, $cat, $pembina, $sched, $loc, $color, $quota, $desc, $req) => Ekskul::create([
            'name' => $name, 'category' => $cat, 'pembina_id' => $pembina?->id, 'schedule_text' => $sched,
            'location' => $loc, 'color' => $color, 'quota' => $quota, 'description' => $desc, 'requirements' => $req,
        ]);
        $futsal = $mkE('Futsal', 'Olahraga', $pNur, 'Selasa & Kamis, 15.00–17.30', 'Lapangan Utama', '#2563EB', 30,
            'Melatih teknik dasar, strategi permainan, dan kerja sama tim melalui latihan rutin dan uji tanding berkala.',
            "Sehat jasmani dan rohani\nMengisi formulir pendaftaran\nMendapat persetujuan orang tua/wali\nBersedia mengikuti latihan rutin");
        $pramuka = $mkE('Pramuka', 'Kepramukaan', $pSiti, 'Jumat, 14.00–16.00', 'Aula Sekolah', '#16A34A', 60,
            'Kegiatan kepramukaan yang membentuk karakter, kemandirian, dan jiwa kepemimpinan.',
            "Mengisi formulir pendaftaran\nMengikuti perkemahan dasar");
        $prog = $mkE('Programming', 'Akademik', $pDedi, 'Rabu, 15.00–17.00', 'Lab Komputer 2', '#4338CA', 40,
            'Belajar dasar pemrograman web dan mobile, serta berlatih untuk kompetisi coding.',
            "Memiliki laptop pribadi (disarankan)\nMinat di bidang teknologi");
        $band = $mkE('Marching Band', 'Seni', $pRina, 'Sabtu, 08.00–11.00', 'Lapangan Utama', '#DB2777', 50,
            'Ekskul musik dan baris-berbaris untuk tampil di acara sekolah dan karnaval kota.',
            "Lulus tes ritme dasar\nMengisi formulir pendaftaran");
        $mkE('Basket', 'Olahraga', null, 'Senin & Rabu, 15.00–17.00', 'Lapangan Basket', '#D97706', 40, 'Ekskul basket untuk kompetisi antar sekolah.', "Sehat jasmani dan rohani\nMengisi formulir pendaftaran");
        $mkE('Fotografi', 'Seni', null, 'Kamis, 15.00–17.00', 'Studio Multimedia', '#0284C7', 35, 'Belajar teknik dasar fotografi dan editing.', "Memiliki kamera atau smartphone");
        $mkE('PMR', 'Sosial', null, 'Selasa, 14.00–16.00', 'Ruang UKS', '#0D9488', 40, 'Palang Merah Remaja: pertolongan pertama dan kepedulian sosial.', "Sehat jasmani dan rohani");

        // ---- Pendaftaran: 10 siswa masuk Futsal, beberapa ke ekskul lain, 2 pending ----
        foreach (array_slice($siswa, 0, 10) as $s) Registration::create(['user_id' => $s->id, 'ekskul_id' => $futsal->id, 'status' => 'accepted', 'decided_at' => $now, 'reason' => 'Suka bermain futsal']);
        foreach ([10, 13, 14] as $i) Registration::create(['user_id' => $siswa[$i]->id, 'ekskul_id' => $pramuka->id, 'status' => 'accepted', 'decided_at' => $now]);
        foreach ([11, 4] as $i) Registration::create(['user_id' => $siswa[$i]->id, 'ekskul_id' => $prog->id, 'status' => 'accepted', 'decided_at' => $now]);
        Registration::create(['user_id' => $siswa[10]->id, 'ekskul_id' => $band->id, 'status' => 'accepted', 'decided_at' => $now]);
        Registration::create(['user_id' => $siswa[11]->id, 'ekskul_id' => $futsal->id, 'status' => 'pending', 'reason' => 'Ingin ikut tim sekolah dan berlatih rutin.']);
        Registration::create(['user_id' => $siswa[12]->id, 'ekskul_id' => $futsal->id, 'status' => 'pending', 'reason' => 'Sudah bermain futsal sejak SMP.']);

        // ---- Ruangan ----
        $lap = Room::create(['name' => 'Lapangan Utama', 'capacity' => 60]);
        $aula = Room::create(['name' => 'Aula Sekolah', 'capacity' => 100]);
        $lab = Room::create(['name' => 'Lab Komputer 2', 'capacity' => 40]);

        // ---- Jadwal (3 sesi lalu + 3 sesi mendatang untuk Futsal, dst.) ----
        $sched = [];
        foreach ([-14, -7, -3] as $d) {
            $sched[] = Schedule::create(['ekskul_id' => $futsal->id, 'room_id' => $lap->id, 'title' => 'Latihan Rutin', 'date' => today()->addDays($d), 'start_time' => '15:00', 'end_time' => '17:30', 'status' => 'selesai']);
        }
        foreach ([2, 4, 9] as $i => $d) {
            Schedule::create(['ekskul_id' => $futsal->id, 'room_id' => $lap->id, 'title' => ['Latihan Taktik', 'Uji Tanding vs SMK 2', 'Latihan Fisik & Stamina'][$i],
                'type' => $i === 1 ? 'uji_tanding' : 'latihan', 'date' => today()->addDays($d), 'start_time' => '15:00', 'end_time' => '17:30']);
        }
        Schedule::create(['ekskul_id' => $pramuka->id, 'room_id' => $aula->id, 'title' => 'Latihan Tali Temali', 'date' => today()->addDays(3), 'start_time' => '14:00', 'end_time' => '16:00']);
        Schedule::create(['ekskul_id' => $prog->id, 'room_id' => $lab->id, 'title' => 'Workshop Web Dasar', 'date' => today()->addDays(1), 'start_time' => '15:00', 'end_time' => '17:00']);

        // ---- Presensi & Penilaian untuk anggota Futsal ----
        $futsalMembers = array_slice($siswa, 0, 10);
        foreach ($sched as $si => $s) {
            foreach ($futsalMembers as $mi => $m) {
                $status = ($mi + $si) % 7 === 0 ? 'izin' : (($mi * 3 + $si) % 11 === 0 ? 'alpha' : 'hadir');
                Attendance::create(['schedule_id' => $s->id, 'user_id' => $m->id, 'status' => $status]);
            }
        }
        foreach ($futsalMembers as $mi => $m) {
            Assessment::create(['ekskul_id' => $futsal->id, 'user_id' => $m->id, 'assessed_by' => $pNur->id,
                'technique' => 72 + ($mi * 3) % 25, 'discipline' => 75 + ($mi * 5) % 22, 'teamwork' => 70 + ($mi * 7) % 28, 'attitude' => 80 + ($mi * 2) % 18,
                'notes' => $mi === 0 ? 'Perkembangan teknik konsisten dan kerja sama tim sangat baik. Pertahankan disiplin latihan.' : null]);
        }

        // ---- Pengumuman, berita, sertifikat ----
        Announcement::create(['user_id' => $pNur->id, 'ekskul_id' => $futsal->id, 'type' => 'pengumuman', 'title' => 'Persiapan Uji Tanding vs SMK 2', 'body' => 'Seluruh anggota diharapkan membawa jersey tim dan berkumpul 30 menit lebih awal sebelum pertandingan dimulai.']);
        Announcement::create(['user_id' => $admin->id, 'type' => 'berita', 'title' => 'Futsal SMK Juara 1 Liga Pelajar Kota', 'body' => 'Tim futsal sekolah berhasil menjuarai Liga Futsal Pelajar Kota setelah mengalahkan lawannya di partai final dengan skor 3-1.']);
        Announcement::create(['user_id' => $admin->id, 'type' => 'pengumuman', 'title' => 'Pendaftaran Ekskul Semester Genap Dibuka', 'body' => 'Siswa dapat mendaftar ke ekskul pilihan melalui portal ini sampai akhir bulan.']);
        Certificate::create(['number' => 'SRT/FUT/' . now()->format('Y') . '/0001', 'user_id' => $siswa[0]->id, 'ekskul_id' => $futsal->id, 'title' => 'Juara 1 Liga Futsal Pelajar Kota', 'issued_at' => today()->subDays(30)]);
    }
}
