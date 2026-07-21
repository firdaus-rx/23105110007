BAB V
PENUTUP

5.1 Kesimpulan

Berdasarkan hasil analisis, perancangan, dan implementasi sistem yang telah dilakukan, maka dapat ditarik kesimpulan sebagai berikut:

1. Sistem Smart Academic Dashboard berhasil dibangun menggunakan framework Laravel 12 dengan arsitektur MVC (Model-View-Controller) dan database MySQL. Sistem ini menerapkan konsep Blade templating engine dengan TailwindCSS untuk tampilan antarmuka yang responsif dan modern.

2. Sistem berhasil mengimplementasikan 11 tabel database utama yaitu users, guru, kelas, siswa, mata_pelajaran, tahun_pelajaran, semester, jadwal_mengajar, nilai_rapor, absensi, dan rapor beserta seluruh relasi Eloquent yang terdefinisi dengan baik.

3. Sistem berhasil menerapkan tiga role pengguna dengan hak akses yang berbeda:
   a. Admin memiliki akses penuh terhadap seluruh fitur CRUD termasuk kelola guru, kelas, siswa, mata pelajaran, tahun pelajaran, semester, jadwal mengajar, nilai rapor, absensi, rapor, dan kenaikan kelas.
   b. Guru dapat mengelola nilai sesuai jadwal mengajar yang diberikan, melihat rekap nilai, serta bagi wali kelas dapat mengelola absensi, mengisi catatan wali kelas, dan melakukan finalisasi rapor.
   c. Siswa dan orang tua dapat melihat nilai, grafik perkembangan nilai, dan mencetak rapor yang telah difinalisasi.

4. Sistem berhasil mengimplementasikan fitur perhitungan nilai secara otomatis melalui NilaiService yang mencakup:
   a. Perhitungan nilai akhir dari rata-rata nilai pengetahuan dan nilai keterampilan.
   b. Penentuan predikat (A, B, C, D) berdasarkan rentang nilai yang telah ditentukan.
   c. Perhitungan rata-rata rapor dan total nilai seluruh mata pelajaran.
   d. Perhitungan peringkat siswa dalam satu kelas berdasarkan rata-rata nilai.

5. Sistem berhasil menyediakan dashboard admin yang informatif dengan menampilkan total siswa, total guru, total kelas, total mata pelajaran, grafik rata-rata nilai per kelas, serta rekap nilai tertinggi dan terendah.

6. Sistem berhasil mengimplementasikan fitur cetak rapor berbasis browser (print view) yang menampilkan seluruh komponen rapor termasuk identitas siswa, nilai mata pelajaran, predikat, deskripsi, absensi, dan catatan wali kelas.

7. Sistem berhasil menerapkan sistem autentikasi manual tanpa starter kit dengan validasi form menggunakan Form Request dan middleware RoleMiddleware untuk membatasi akses berdasarkan peran pengguna.

5.2 Saran

Berdasarkan hasil pengembangan sistem yang telah dilakukan, berikut beberapa saran yang dapat diberikan untuk pengembangan sistem lebih lanjut:

1. Implementasi cetak rapor dalam format PDF native menggunakan library seperti DomPDF atau Barryvdh/Laravel-DomPDF agar hasil cetak lebih rapi dan dapat diatur format halaman secara presisi.

2. Penambahan fitur notifikasi atau pengingat bagi guru yang belum menginput nilai menjelang akhir semester agar proses pengelolaan nilai lebih tepat waktu.

3. Pengembangan fitur manajemen ekstrakurikuler dan nilai sikap spiritual/sosial yang lebih terperinci sesuai dengan kurikulum yang berlaku.

4. Implementasi sistem backup database otomatis untuk menjaga keamanan data akademik sekolah.

5. Penambahan fitur impor data siswa dan guru dari file Excel atau CSV untuk memudahkan migrasi data awal.

6. Pengembangan fitur histori perubahan nilai (audit trail) untuk melacak setiap perubahan data nilai yang dilakukan oleh pengguna.

7. Implementasi API endpoint untuk memungkinkan integrasi dengan sistem lain seperti sistem penerimaan peserta didik baru (PPDB) atau sistem informasi sekolah lainnya.

8. Penambahan fitur chat atau pesan internal antar pengguna untuk memudahkan komunikasi antara guru, wali kelas, dan orang tua siswa.

9. Pengembangan fitur multi-semester aktif untuk mendukung sistem kredit semester atau sistem paket pada jenjang pendidikan yang lebih tinggi.

10. Optimalisasi performa query pada halaman rekap nilai dan dashboard dengan implementasi caching untuk data yang jarang berubah.
