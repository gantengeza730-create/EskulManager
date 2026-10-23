# Ekskul SMK — Sistem Informasi Ekstrakurikuler (Laravel 11)

Tiga peran: **Siswa**, **Pembina Ekskul**, **Admin**. Tanpa npm/Vite (CSS ada di `public/css/app.css`).

## Cara pasang
```bash
composer create-project laravel/laravel ekskul-smk
cd ekskul-smk
# 1) salin SEMUA isi folder ini ke dalam proyek (timpa file yang sama:
#    app/, bootstrap/app.php, database/, resources/views/, routes/web.php, public/css/)
# 2) atur .env (lihat .env.example.snippet): APP_LOCALE=id, APP_TIMEZONE=Asia/Jakarta, MAIL_MAILER=log
php artisan migrate --seed
php artisan storage:link        # agar foto galeri bisa tampil
php artisan serve               # buka http://127.0.0.1:8000
```

## Akun contoh (kata sandi semua: `password`)
| Peran | Login | Catatan |
|---|---|---|
| Admin | admin@sekolah.test | |
| Pembina | nur@sekolah.test | membina Futsal (ada pendaftar menunggu) |
| Siswa | siswa1@sekolah.test atau NIS 2324001 | Ahmad Fadillah, anggota Futsal |

Semua peran bisa login dari perangkat apa pun (HP maupun laptop) — tab peran di halaman login murni pilihan, tidak lagi dikunci berdasarkan lebar layar.
Kode verifikasi register muncul di halaman verifikasi (mode `APP_DEBUG=true`) dan di `storage/logs/laravel.log`.

## Tampilan Landing Page (langit malam animasi)
Hero di landing page kini bertema langit malam: bintang berkelip acak (`public/js/stars.js`), nebula lembut yang bergerak pelan, tiga orbit dengan planet kecil yang berputar terus-menerus, dan bintang jatuh sesekali — semuanya CSS/JS ringan tanpa library.
Warna dasar mode terang juga dilembutkan (tidak lagi putih menyilaukan). Animasi otomatis nonaktif jika perangkat pengguna mengaktifkan "reduce motion".

## Mode Gelap/Terang
Tombol 🌙/☀️ di pojok kanan atas (landing, login, register, verifikasi) dan di topbar dashboard mengganti tema.
Pilihan disimpan di `localStorage` (`public/css/theme.js`) sehingga tetap ke tema yang sama saat kembali membuka aplikasi.
Tanpa memilih, aplikasi otomatis mengikuti pengaturan gelap/terang perangkat (`prefers-color-scheme`).

## Latar Belakang Dashboard (ikut bertema langit malam)
Semua dashboard (Siswa, Pembina, Admin) kini punya hiasan bergerak yang sama seperti landing page, dibuat ringan agar tidak mengganggu:
- **Sidebar** — bintang kecil berkelip pelan di belakang menu (`#sidebarStars`, dari `public/js/stars.js`).
- **Latar konten** — tiga cahaya nebula lembut yang melayang pelan di belakang kartu/tabel (`body.dash::before` di `public/css/app.css`). Karena semua tabel dan kartu punya latar solid, keterbacaan tidak terganggu.
Efek ini otomatis mengikuti mode gelap/terang dan nonaktif jika perangkat mengaktifkan "reduce motion".

## Logout
Tombol **Keluar** (sidebar) mengakhiri sesi lalu **langsung kembali ke landing page** (`AuthController@logout`).

## Fungsi setiap menu & fitur

### Publik (tanpa login)
- **Landing page** — profil sekolah, statistik (jumlah ekskul/siswa/pembina), daftar ekskul, cara bergabung, berita terbaru, cuplikan galeri. Semua data dari database.
- **Detail ekskul** — Info, Syarat, dan Anggota (daftar nama hanya tampil setelah login), tombol daftar.
- **Login** — satu form, tab peran (Siswa/Pembina/Admin) dicocokkan dengan peran akun di server. Siswa bisa memakai email atau NIS.
- **Register + verifikasi** — siswa membuat akun, sistem membuat kode 6 digit; akun baru bisa login setelah verifikasi.

### Siswa
- **Dashboard** — ekskul diikuti, % kehadiran, rata-rata nilai, jumlah sertifikat, jadwal terdekat, pengumuman terbaru, status pendaftaran yang menunggu.
- **Ekstrakurikuler** — jelajah + filter kategori, lihat status pendaftaran per ekskul.
- **Formulir pendaftaran** — alasan + persetujuan; mengecek kuota & pendaftaran ganda; pembina otomatis dinotifikasi.
- **Jadwal Kegiatan / Kalender** — hanya jadwal ekskul yang sudah diterima.
- **Presensi** — riwayat hadir/izin/sakit/alpha dan persentase, langsung dari input pembina.
- **Nilai & Evaluasi** — 4 aspek (teknik, disiplin, kerja sama, sikap) + catatan pembina.
- **Sertifikat** — daftar sertifikat milik sendiri, bisa dicetak/PDF.
- **Pengumuman, Galeri, Notifikasi, Profil** — baca informasi, lihat dokumentasi, pengingat jadwal/status, ubah data diri & kata sandi.

### Pembina
- **Dashboard** — ekskul binaan, total anggota, pendaftar menunggu, kehadiran rata-rata, jadwal terdekat.
- **Data Pendaftar** — tabel pendaftar; Terima/Tolak (cek kuota); siswa dinotifikasi.
- **Presensi** — pilih sesi jadwal, tandai anggota (hadir/izin/sakit/alpha), simpan; sesi ditandai selesai.
- **Penilaian** — isi nilai 0–100 + catatan per anggota; siswa dinotifikasi saat nilai berubah.
- **Jadwal / Kalender** — melihat jadwal ekskul binaan.
- **Laporan** — rekap kehadiran per anggota (bisa dicetak).
- **Pengumuman & Galeri** — menerbitkan pengumuman/berita ke anggota ekskul dan mengunggah foto (notifikasi otomatis untuk pengumuman).

### Admin
- **Dashboard** — total siswa/ekskul/pembina/sertifikat, popularitas ekskul, pendaftaran terbaru, jadwal terdekat, pintasan operasional.
- **Manajemen Ekskul** — CRUD master data (nama, kategori, deskripsi, syarat, jadwal teks, lokasi, kuota, warna, pembina, aktif/nonaktif).
- **Manajemen Pengguna** — CRUD siswa/pembina/admin, cari & filter peran, aktif/nonaktifkan akun, reset kata sandi. Admin tidak bisa menghapus/mengunci dirinya sendiri.
- **Ruangan & Tempat** — master data tempat latihan (nama, kapasitas).
- **Jadwal** — CRUD jadwal + alokasi ruangan; **menolak jadwal yang bentrok** (ruangan sama, tanggal sama, jam beririsan); anggota dinotifikasi saat jadwal dibuat/diubah.
- **Kalender Terintegrasi** — semua jadwal semua ekskul dalam satu kalender bulanan berwarna per ekskul.
- **Laporan & Rekap** — rekap per ekskul (anggota, sesi selesai, kehadiran), cetak, dan **unduh CSV** (Excel).
- **Sertifikat** — generate untuk satu siswa atau seluruh anggota ekskul, nomor unik otomatis, halaman cetak A4/PDF, siswa dinotifikasi.
- **Pengumuman & Berita, Galeri** — terbitkan ke seluruh sekolah atau ekskul tertentu (kirim notifikasi), unggah/hapus dokumentasi.

### Keamanan & alur data
- Middleware `role:` (`app/Http/Middleware/RoleMiddleware.php`) memblokir akses lintas peran (403).
- Pembina hanya bisa mengelola ekskul yang ia bina; siswa hanya melihat data miliknya.
- Notifikasi dalam aplikasi (`app_notifications`) dibuat oleh `App\Support\Notifier` pada: jadwal baru/diubah, pengumuman, pendaftar baru, keputusan pendaftaran, nilai diperbarui, sertifikat terbit.

## Struktur singkat
`routes/web.php` (semua route) · `app/Http/Controllers/{Admin,Pembina,Siswa}` · `app/Models` · `database/migrations` (10 tabel) · `database/seeders/DatabaseSeeder.php` · `resources/views/{layouts,partials,auth,shared,siswa,pembina,admin}`.
