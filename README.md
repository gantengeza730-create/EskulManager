# Ekskul SMK — Laravel (v2, revisi hasil presentasi)

## Pasang / update
1. Salin SEMUA isi folder ini ke proyek Laravel (timpa file yang sama), termasuk folder `lang/`.
2. `.env`: `APP_LOCALE=id`, `APP_TIMEZONE=Asia/Jakarta`, `MAIL_MAILER=log`
3. `php artisan migrate:fresh --seed`   (struktur tabel berubah — data contoh dibuat ulang)
4. `php artisan storage:link` lalu `php artisan optimize:clear` lalu `php artisan serve`

Akun (kata sandi `password`): admin@sekolah.test · nur@sekolah.test (pembina Futsal) · siswa1@sekolah.test

## Peta revisi
1 Ekskul besar → badge ★ (batas diatur di Pengaturan Sekolah) | 2 Penolakan → alasan wajib + notifikasi ke siswa
3 Tanggal presensi → dashboard pembina & filter tanggal | 4 Berita: kolom "ditujukan untuk" hilang, diganti "Berita tentang"
5 Pengumuman: tujuan pakai checkbox | 6 Dark mode: teks kartu login/daftar, ukuran font | 7 Semua kolom wajib diisi
8 Manajemen pengguna: ukuran teks & pagination | 9 Jadwal Tetap (berulang mingguan) | 10 Cetak laporan & sertifikat diperbaiki
11 Sesi dihitung hanya yang sudah berlangsung | 12 Filter laporan hari ini–1 bulan + tanggal bebas | 13 Nama kepala sekolah (Pengaturan Sekolah)
14 Filter pengumuman/berita + tampil di dashboard admin | 15 Landing siang/malam | 16 Filter berita & dokumentasi (Sekolah / ekskul)
