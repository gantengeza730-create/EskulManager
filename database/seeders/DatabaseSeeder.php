<?php

namespace Database\Seeders;

use App\Models\{Announcement, Assessment, Attendance, Certificate, Ekskul, Registration, Room, Schedule, Setting, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $mk = fn ($name, $email, $role, $extra = []) => User::create([
            'name' => $name, 'email' => $email, 'role' => $role, 'password' => 'password',
            'email_verified_at' => $now, 'is_active' => true, 'phone' => '0812-0000-0000',
        ] + $extra);

        // Identitas sekolah (bisa diubah admin di menu Pengaturan Sekolah)
        Setting::put([
            'school_name' => 'SMKN 1 Binong', 'school_address' => 'Jl. Pendidikan No. 10, Bandung',
            'principal_name' => 'Drs. H. Ahmad Syafei, M.Pd', 'principal_nip' => '19680512 199403 1 004',
            'ekskul_besar_min' => '8',
        ]);

        $admin = $mk('Admin Utama', 'admin@sekolah.test', 'admin', ['nis' => 'ADM001']);
        $pNur = $mk('Nur Hidayat, S.Pd', 'nur@sekolah.test', 'pembina', ['nis' => 'NIP001']);
        $pSiti = $mk('Siti Aminah, S.Pd', 'siti@sekolah.test', 'pembina', ['nis' => 'NIP002']);
        $pDedi = $mk('Dedi Kurniawan, S.Kom', 'dedi@sekolah.test', 'pembina', ['nis' => 'NIP003']);
        $pRina = $mk('Rina Marlina, S.Pd', 'rina@sekolah.test', 'pembina', ['nis' => 'NIP004']);

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

        $mkE = fn ($name, $cat, $pembina, $sched, $loc, $color, $quota, $desc, $req) => Ekskul::create([
            'name' => $name, 'category' => $cat, 'pembina_id' => $pembina->id, 'schedule_text' => $sched,
            'location' => $loc, 'color' => $color, 'quota' => $quota, 'description' => $desc, 'requirements' => $req,
        ]);
        $futsal = $mkE('Futsal', 'Olahraga', $pNur, 'Selasa, 15.00–17.30', 'Lapangan Utama', '#2563EB', 30, 'Melatih teknik dasar, strategi permainan, dan kerja sama tim melalui latihan rutin dan uji tanding.', "Sehat jasmani dan rohani\nMengisi formulir pendaftaran\nMendapat persetujuan orang tua/wali\nBersedia mengikuti latihan rutin");
        $pramuka = $mkE('Pramuka', 'Kepramukaan', $pSiti, 'Jumat, 14.00–16.00', 'Aula Sekolah', '#16A34A', 60, 'Kegiatan kepramukaan yang membentuk karakter, kemandirian, dan jiwa kepemimpinan.', "Mengisi formulir pendaftaran\nMengikuti perkemahan dasar");
        $prog = $mkE('Programming', 'Akademik', $pDedi, 'Rabu, 15.00–17.00', 'Lab Komputer 2', '#4338CA', 40, 'Belajar dasar pemrograman web dan mobile serta berlatih untuk kompetisi coding.', "Memiliki laptop pribadi (disarankan)\nMinat di bidang teknologi");
        $band = $mkE('Marching Band', 'Seni', $pRina, 'Sabtu, 08.00–11.00', 'Lapangan Utama', '#DB2777', 50, 'Ekskul musik dan baris-berbaris untuk tampil di acara sekolah dan karnaval kota.', "Lulus tes ritme dasar\nMengisi formulir pendaftaran");

        foreach (array_slice($siswa, 0, 10) as $s) Registration::create(['user_id' => $s->id, 'ekskul_id' => $futsal->id, 'status' => 'accepted', 'decided_at' => $now, 'reason' => 'Suka bermain futsal']);
        foreach ([10, 13, 14] as $i) Registration::create(['user_id' => $siswa[$i]->id, 'ekskul_id' => $pramuka->id, 'status' => 'accepted', 'decided_at' => $now]);
        foreach ([11, 4] as $i) Registration::create(['user_id' => $siswa[$i]->id, 'ekskul_id' => $prog->id, 'status' => 'accepted', 'decided_at' => $now]);
        Registration::create(['user_id' => $siswa[10]->id, 'ekskul_id' => $band->id, 'status' => 'accepted', 'decided_at' => $now]);
        Registration::create(['user_id' => $siswa[11]->id, 'ekskul_id' => $futsal->id, 'status' => 'pending', 'reason' => 'Ingin ikut tim sekolah dan berlatih rutin.']);
        Registration::create(['user_id' => $siswa[12]->id, 'ekskul_id' => $futsal->id, 'status' => 'rejected', 'reason' => 'Ingin ikut futsal.', 'reject_reason' => 'Kuota posisi kiper sudah penuh, silakan daftar semester depan.', 'decided_at' => $now]);

        $lap = Room::create(['name' => 'Lapangan Utama', 'capacity' => 60]);
        $aula = Room::create(['name' => 'Aula Sekolah', 'capacity' => 100]);
        $lab = Room::create(['name' => 'Lab Komputer 2', 'capacity' => 40]);

        // Jadwal TETAP Futsal: tiap Selasa, mulai 3 minggu lalu sampai 5 minggu ke depan (9 sesi)
        $series = (string) Str::uuid();
        $start = today()->startOfWeek()->addDay()->subWeeks(3);
        $fixedSessions = [];
        for ($w = 0; $w < 9; $w++) {
            $fixedSessions[] = Schedule::create(['ekskul_id' => $futsal->id, 'room_id' => $lap->id, 'title' => 'Latihan Rutin Futsal', 'date' => $start->copy()->addWeeks($w),
                'start_time' => '15:00', 'end_time' => '17:30', 'is_fixed' => true, 'series' => $series, 'notes' => 'Jadwal tetap tiap Selasa']);
        }
        Schedule::create(['ekskul_id' => $futsal->id, 'room_id' => $lap->id, 'title' => 'Uji Tanding vs SMK 2', 'type' => 'uji_tanding', 'date' => today()->addDays(4), 'start_time' => '14:30', 'end_time' => '17:00', 'notes' => 'Bawa jersey tim']);
        Schedule::create(['ekskul_id' => $pramuka->id, 'room_id' => $aula->id, 'title' => 'Latihan Tali Temali', 'date' => today()->addDays(3), 'start_time' => '14:00', 'end_time' => '16:00', 'notes' => 'Bawa tali tambang']);
        Schedule::create(['ekskul_id' => $prog->id, 'room_id' => $lab->id, 'title' => 'Workshop Web Dasar', 'date' => today()->addDays(1), 'start_time' => '15:00', 'end_time' => '17:00', 'notes' => 'Bawa laptop']);

        // Presensi untuk sesi Futsal yang sudah berlangsung
        $held = collect($fixedSessions)->filter(fn ($s) => $s->date->lt(today()));
        foreach ($held as $si => $s) {
            foreach (array_slice($siswa, 0, 10) as $mi => $m) {
                $status = ($mi + $si) % 7 === 0 ? 'izin' : (($mi * 3 + $si) % 11 === 0 ? 'alpha' : 'hadir');
                Attendance::create(['schedule_id' => $s->id, 'user_id' => $m->id, 'status' => $status]);
            }
        }
        foreach (array_slice($siswa, 0, 10) as $mi => $m) {
            Assessment::create(['ekskul_id' => $futsal->id, 'user_id' => $m->id, 'assessed_by' => $pNur->id,
                'technique' => 72 + ($mi * 3) % 25, 'discipline' => 75 + ($mi * 5) % 22, 'teamwork' => 70 + ($mi * 7) % 28, 'attitude' => 80 + ($mi * 2) % 18,
                'notes' => $mi === 0 ? 'Perkembangan teknik konsisten dan kerja sama tim sangat baik. Pertahankan disiplin latihan.' : 'Terus tingkatkan stamina dan konsistensi latihan.']);
        }

        // Pengumuman (tujuan: seluruh sekolah / ekskul tertentu) dan Berita (topik: Sekolah / ekskul)
        $a1 = Announcement::create(['user_id' => $pNur->id, 'type' => 'pengumuman', 'title' => 'Persiapan Uji Tanding vs SMK 2', 'body' => 'Seluruh anggota diharapkan membawa jersey tim dan berkumpul 30 menit lebih awal.', 'is_all' => false]);
        $a1->targets()->sync([$futsal->id]);
        Announcement::create(['user_id' => $admin->id, 'type' => 'pengumuman', 'title' => 'Pendaftaran Ekskul Semester Genap Dibuka', 'body' => 'Siswa dapat mendaftar ke ekskul pilihan melalui portal ini sampai akhir bulan.', 'is_all' => true]);
        Announcement::create(['user_id' => $admin->id, 'type' => 'berita', 'ekskul_id' => $futsal->id, 'title' => 'Futsal SMK Juara 1 Liga Pelajar Kota', 'body' => 'Tim futsal sekolah menjuarai Liga Futsal Pelajar Kota setelah menang 3-1 di partai final.', 'is_all' => true]);
        Announcement::create(['user_id' => $admin->id, 'type' => 'berita', 'ekskul_id' => null, 'title' => 'Sekolah Raih Akreditasi A', 'body' => 'SMKN 1 Binong kembali meraih akreditasi A dari BAN-S/M.', 'is_all' => true]);
        Certificate::create(['number' => 'SRT/FUT/' . now()->format('Y') . '/0001', 'user_id' => $siswa[0]->id, 'ekskul_id' => $futsal->id, 'title' => 'Juara 1 Liga Futsal Pelajar Kota', 'issued_at' => today()->subDays(30)]);
    }
}
