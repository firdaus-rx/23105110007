# Alur Penggunaan Aplikasi Smart Academic Dashboard

## MIN 21 Pidie -- Sistem Pengelolaan Nilai Rapor Siswa Berbasis Web

---

## A. Alur untuk Role ADMIN

Admin memiliki akses penuh ke seluruh fitur sistem. Admin bertanggung jawab mengelola data master, memantau jalannya akademik, dan melakukan kenaikan kelas.

### 1. Login ke Sistem

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 1.1 | Buka halaman `/login` | Tampilan form login akan muncul |
| 1.2 | Masukkan email dan password | Gunakan akun dengan role **admin** (contoh: `admin@madrasah.sch.id`) |
| 1.3 | Klik tombol "Masuk" | Sistem akan memverifikasi kredensial dan mengarahkan ke Dashboard Admin |

> **Catatan:** Setelah login berhasil, sidebar kiri akan menampilkan menu-menu khusus admin.

---

### 2. Dashboard Admin (`/admin`)

Setelah login, halaman yang pertama muncul adalah **Dashboard Admin**. Di sini admin dapat melihat:

- **Card Statistik** di bagian atas:
  - Total Siswa -- jumlah seluruh siswa terdaftar
  - Total Guru -- jumlah tenaga pengajar
  - Total Kelas -- jumlah rombongan belajar aktif
  - Mata Pelajaran -- jumlah mata pelajaran aktif
- **Info Semester Aktif**: menampilkan tahun pelajaran dan semester yang sedang berlangsung, plus nilai tertinggi dan terendah
- **Grafik Jumlah Siswa per Kelas** (chart batang)
- **Grafik Rata-rata Nilai per Kelas** (chart batang, hijau jika >= KKM 75, merah jika di bawah)
- **Aksi Cepat**: tautan langsung ke halaman Data Guru, Data Kelas, Data Siswa, Jadwal Mengajar, dan Rapor
- **Detail Siswa per Kelas**: daftar kelas dengan progress bar jumlah siswa
- **Rapor Terbaru**: menampilkan rapor yang baru dibuat/diupdate dengan status draft/final

---

### 3. Kelola Data Guru (`/admin/guru`)

Menu ini digunakan untuk mengelola data seluruh guru.

| Langkah | Tindakan | Menu / Tombol |
|---------|----------|---------------|
| 3.1 | Membuka menu **Data Guru** | Sidebar > Data Guru |
| 3.2 | Melihat daftar guru | Tabel menampilkan NIP, Nama, Jenis Kelamin, Telepon, dan Aksi |
| 3.3 | Menambah guru baru | Klik tombol **+ Tambah Guru** |
| 3.4 | Mengisi form tambah guru | Isi NIP (unique), Nama Guru, Jenis Kelamin, Telepon, Alamat, Email, Password |
| 3.5 | Menyimpan data | Klik **Simpan** |
| 3.6 | Mengedit data guru | Klik tombol **Edit** (ikon pena) pada baris yang dituju |
| 3.7 | Melihat detail guru | Klik tombol **Detail** (ikon mata) |
| 3.8 | Menghapus guru | Klik tombol **Hapus** (ikon tong sampah), konfirmasi dengan klik **Ya, Hapus** |

> **Catatan:** Saat menambah guru, sistem juga akan membuatkan akun User dengan role `guru` secara otomatis.

---

### 4. Kelola Data Kelas (`/admin/kelas`)

| Langkah | Tindakan | Menu / Tombol |
|---------|----------|---------------|
| 4.1 | Buka menu **Data Kelas** | Sidebar > Data Kelas |
| 4.2 | Lihat daftar kelas | Tabel: Nama Kelas, Tingkat, Wali Kelas |
| 4.3 | Tambah kelas baru | Klik **+ Tambah Kelas** -- isi Nama Kelas, Tingkat, pilih Wali Kelas (dropdown dari data guru) |
| 4.4 | Edit kelas | Klik **Edit** -- ubah data yang diperlukan |
| 4.5 | Detail kelas | Klik **Detail** -- lihat info kelas dan daftar siswa di kelas tersebut |
| 4.6 | Hapus kelas | Klik **Hapus** (siswa di kelas akan menjadi null/kelas_id = NULL) |

> **Catatan:** Wali Kelas dipilih dari data guru yang sudah ada. Satu guru bisa menjadi wali kelas dari satu kelas.

---

### 5. Kelola Data Siswa (`/admin/siswa`)

| Langkah | Tindakan | Menu / Tombol |
|---------|----------|---------------|
| 5.1 | Buka menu **Data Siswa** | Sidebar > Data Siswa |
| 5.2 | Lihat daftar siswa | Tabel: NIS, NISN, Nama, Kelas, JK |
| 5.3 | Cari siswa | Gunakan kotak **Search** untuk mencari berdasarkan NIS/NISN/Nama |
| 5.4 | Tambah siswa baru | Klik **+ Tambah Siswa** |
| 5.5 | Isi form siswa | Lengkapi: NIS (unique), NISN (unique), Nama, Tempat Lahir, Tgl Lahir, JK, Agama, Alamat, Nama Ayah, Nama Ibu, Telepon Ortu, pilih Kelas, Email, Password |
| 5.6 | Simpan | Klik **Simpan** (sistem membuat akun User role `siswa` otomatis) |
| 5.7 | Edit / Detail / Hapus | Gunakan tombol aksi pada masing-masing baris |

---

### 6. Kelola Mata Pelajaran (`/admin/mata-pelajaran`)

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 6.1 | Buka menu **Mata Pelajaran** | Sidebar > Mata Pelajaran |
| 6.2 | Tambah mapel baru | **+ Tambah Mata Pelajaran** -- isi Kode Mapel (unique), Nama Mapel, KKM (default 75), Kelompok, Status (aktif/nonaktif) |
| 6.3 | Edit / Hapus mapel | Tombol aksi pada baris |

---

### 7. Kelola Tahun Pelajaran (`/admin/tahun-pelajaran`)

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 7.1 | Buka menu **Tahun Pelajaran** | Sidebar > Tahun Pelajaran |
| 7.2 | Tambah tahun pelajaran | Klik **+ Tambah** -- isi Nama Tahun (contoh: `2025/2026`) |
| 7.3 | Aktifkan tahun pelajaran | Klik tombol **Aktifkan** pada baris yang diinginkan. Hanya satu tahun pelajaran yang bisa aktif. |

---

### 8. Kelola Semester (`/admin/semester`)

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 8.1 | Buka menu **Semester** | Sidebar > Semester |
| 8.2 | Tambah semester | Klik **+ Tambah** -- isi Nama Semester (Ganjil/Genap) |
| 8.3 | Aktifkan semester | Klik tombol **Aktifkan** pada semester. Hanya satu semester yang aktif. |

---

### 9. Kelola Jadwal Mengajar (`/admin/jadwal-mengajar`)

Jadwal mengajar menentukan relasi antara Guru, Kelas, dan Mata Pelajaran dalam tahun pelajaran dan semester tertentu.

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 9.1 | Buka menu **Jadwal Mengajar** | Sidebar > Jadwal Mengajar |
| 9.2 | Tambah jadwal baru | Klik **+ Tambah Jadwal** |
| 9.3 | Pilih data | Pilih Guru, Kelas, Mata Pelajaran. Tahun Pelajaran dan Semester akan terisi otomatis dari yang aktif. |
| 9.4 | Simpan | Klik **Simpan**. Sistem akan mencegah duplikasi (guru + kelas + mapel + tahun + semester yang sama). |

> **Catatan:** Jadwal mengajar inilah yang menjadi dasar guru untuk menginput nilai. Guru hanya bisa menginput nilai pada kelas dan mapel yang tercantum di jadwal mengajarnya.

---

### 10. Kelola Nilai Rapor (`/admin/nilai-rapor`)

Admin dapat melihat dan mengelola semua nilai. Namun untuk pengisian nilai harian dilakukan oleh guru melalui akun masing-masing.

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 10.1 | Buka menu **Nilai Rapor** | Sidebar > Nilai Rapor |
| 10.2 | Lihat daftar nilai | Tabel seluruh nilai yang sudah diinput |
| 10.3 | Tambah/edit nilai | Klik **Tambah** atau **Edit** -- pilih Kelas, pilih Siswa (akan muncul berdasarkan kelas), pilih Mata Pelajaran, Guru, Tahun Pelajaran, Semester, lalu isi nilai |
| 10.4 | Hapus nilai | Klik **Hapus** pada baris yang dituju |

---

### 11. Kelola Absensi (`/admin/absensi`)

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 11.1 | Buka menu **Absensi** | Sidebar > Absensi |
| 11.2 | Tambah absensi | Klik **+ Tambah Absensi** -- pilih Kelas, pilih Siswa, masukkan jumlah Sakit, Izin, Alfa. Tahun Pelajaran & Semester aktif otomatis. |

---

### 12. Kelola Rapor (`/admin/rapor`)

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 12.1 | Buka menu **Rapor** | Sidebar > Rapor |
| 12.2 | Lihat daftar rapor | Tabel: Nama Siswa, Kelas, Total Nilai, Rata-rata, Peringkat, Status (Draft/Final) |
| 12.3 | Buat rapor | Klik **+ Tambah Rapor** -- pilih Kelas (muncul daftar siswa), pilih siswa. Sistem akan menghitung otomatis total nilai, rata-rata, predikat, dan peringkat dari nilai rapor yang sudah ada. |
| 12.4 | Detail rapor | Klik **Detail** -- lihat semua nilai mata pelajaran, absensi, catatan wali kelas |
| 12.5 | Edit rapor | Klik **Edit** -- ubah catatan wali kelas |
| 12.6 | Cetak rapor | Klik tombol **Cetak** pada halaman detail. Rapor akan terbuka di tab baru siap dicetak. |
| 12.7 | Hapus rapor | Klik **Hapus** |

---

### 13. Kenaikan Kelas (`/admin/kenaikan-kelas`)

Fitur ini digunakan pada akhir tahun pelajaran untuk menaikkan kelas siswa.

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 13.1 | Buka menu **Kenaikan Kelas** | Sidebar > Kenaikan Kelas (biasanya di bagian bawah) |
| 13.2 | Lihat daftar siswa per kelas | Tabel menampilkan siswa berdasarkan kelas saat ini |
| 13.3 | Preview kenaikan | Klik tombol **Preview Kenaikan** untuk melihat simulasi kenaikan kelas |
| 13.4 | Lakukan kenaikan | Klik **Promosikan** / **Naikkan Kelas**. Sistem akan menaikkan tingkat kelas siswa (I-A -> II-A, II-A -> III-A, dst). Siswa kelas VI akan otomatis keluar (status lulus). |

> **Catatan:** Fitur ini hanya bisa dijalankan oleh admin, biasanya di akhir tahun pelajaran.

---

### Ringkasan Menu Admin

| No | Menu | Fungsi |
|----|------|--------|
| 1 | Dashboard | Melihat statistik dan grafik |
| 2 | Data Guru | CRUD data guru |
| 3 | Data Kelas | CRUD data kelas & wali kelas |
| 4 | Data Siswa | CRUD data siswa |
| 5 | Mata Pelajaran | CRUD mata pelajaran & KKM |
| 6 | Tahun Pelajaran | Kelola tahun pelajaran |
| 7 | Semester | Kelola semester |
| 8 | Jadwal Mengajar | Atur jadwal guru mengajar |
| 9 | Nilai Rapor | Lihat/kelola semua nilai |
| 10 | Absensi | Lihat/kelola absensi |
| 11 | Rapor | Kelola rapor & cetak |
| 12 | Kenaikan Kelas | Proses kenaikan kelas |

---

## B. Alur untuk Role GURU

Guru memiliki dua jenis akses:
1. **Akses Guru Biasa** -- melihat jadwal, input nilai, rekap nilai
2. **Akses Wali Kelas** -- jika guru ditunjuk sebagai wali kelas, ada menu tambahan untuk absensi dan rapor

### 1. Login

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 1.1 | Buka `/login` | Form login |
| 1.2 | Masukkan email & password guru | Contoh: `guru1@madrasah.sch.id` |
| 1.3 | Klik **Masuk** | Masuk ke Dashboard Guru |

---

### 2. Dashboard Guru (`/guru`)

Halaman utama setelah login menampilkan:

- **Card Statistik**:
  - Kelas Diajar -- jumlah kelas yang diajar oleh guru ini
  - Total Siswa -- jumlah siswa dari seluruh kelas yang diajar
  - Mata Pelajaran -- jumlah mapel yang diajar
  - Total Jadwal -- jumlah jadwal mengajar
- **Grafik Rata-rata Nilai per Kelas** (dari hasil input nilai guru)
- **Aksi Cepat**: ke Jadwal Mengajar, Rekap Nilai, Wali Kelas
- **Kelas Saya**: kartu-kartu kelas yang diajar, lengkap dengan daftar mapel per kelas dan tautan **Input Nilai** (ikon pensil)

---

### 3. Lihat Jadwal Mengajar (`/guru/jadwal`)

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 3.1 | Buka menu **Jadwal Mengajar** | Sidebar > Jadwal Mengajar |
| 3.2 | Lihat daftar jadwal | Tabel menampilkan: Kelas, Mata Pelajaran, Tahun Pelajaran, Semester. Hanya jadwal milik guru yang login. |
| 3.3 | Klik tombol **Input Nilai** | Pada kolom Aksi, klik **Input Nilai** untuk mulai mengisi nilai pada kelas & mapel tersebut |

---

### 4. Input Nilai (`/guru/nilai/{jadwal}`)

Ini adalah fitur utama guru untuk mengisi nilai rapor siswa.

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 4.1 | Pilih jadwal (dari halaman jadwal atau dari kartu kelas) | Masuk ke halaman input nilai |
| 4.2 | Lihat daftar siswa | Tabel menampilkan semua siswa di kelas tersebut |
| 4.3 | Isi **Nilai Pengetahuan** | Input angka 0-100 untuk setiap siswa |
| 4.4 | Isi **Nilai Keterampilan** | Input angka 0-100 untuk setiap siswa |
| 4.5 | Isi **Nilai Sikap** | Pilih dari opsi (Sangat Baik, Baik, Cukup, Kurang) |
| 4.6 | Klik **Simpan Nilai** | Semua nilai tersimpan. Sistem akan otomatis menghitung predikat (A/B/C/D) dan menyimpannya. |

> **Catatan Penting:**
> - Guru hanya bisa menginput nilai untuk kelas dan mapel yang tercantum di jadwal mengajarnya
> - Nilai Pengetahuan dan Keterampilan harus antara 0-100
> - Jika nilai sudah pernah diinput, guru bisa mengeditnya kembali
> - Predikat otomatis: A (90-100), B (80-89), C (70-79), D (<70)

---

### 5. Rekap Nilai (`/guru/rekap`)

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 5.1 | Buka menu **Rekap Nilai** | Sidebar > Rekap Nilai |
| 5.2 | Lihat ringkasan nilai | Tabel menampilkan per kelas: rata-rata nilai pengetahuan, keterampilan, jumlah siswa, dan status |
| 5.3 | Filter berdasarkan kelas | Pilih kelas dari dropdown untuk melihat detail |

---

### 6. Fitur Wali Kelas

Jika guru ditunjuk sebagai wali kelas (oleh admin di menu Data Kelas), maka akan muncul menu **Wali Kelas** di sidebar dengan submenu:

#### 6.1 Data Siswa (`/guru/wali-kelas`)

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 6.1.1 | Buka menu **Wali Kelas > Data Siswa** | Sidebar > Wali Kelas > Data Siswa |
| 6.1.2 | Lihat daftar siswa | Tabel semua siswa di kelas wali, lengkap dengan NIS, Nama, JK, dan detail lainnya |

#### 6.2 Input Absensi (`/guru/wali-kelas/absensi`)

Wali kelas menginput data kehadiran siswa.

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 6.2.1 | Buka menu **Wali Kelas > Absensi** | Sidebar > Wali Kelas > Absensi |
| 6.2.2 | Lihat daftar siswa | Tabel siswa di kelas wali |
| 6.2.3 | Input jumlah absensi | Untuk setiap siswa, isi jumlah **Sakit**, **Izin**, dan **Alfa** |
| 6.2.4 | Klik **Simpan Absensi** | Data tersimpan. Tahun Pelajaran & Semester aktif otomatis terisi. |

#### 6.3 Kelola Rapor (`/guru/wali-kelas/rapor`)

Wali kelas dapat mengelola rapor siswanya.

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 6.3.1 | Buka menu **Wali Kelas > Rapor** | Sidebar > Wali Kelas > Rapor |
| 6.3.2 | Lihat daftar rapor | Tabel rapor siswa di kelas wali: Nama, Total Nilai, Rata-rata, Peringkat, Status |
| 6.3.3 | Isi **Catatan Wali Kelas** | Klik **Edit** pada baris rapor -- tulis catatan untuk siswa (contoh: "Tetap semangat belajar, tingkatkan lagi nilai Matematika") |
| 6.3.4 | **Finalisasi Rapor** | Jika semua data sudah lengkap, klik tombol **Finalisasi** pada baris rapor. Status berubah dari `draft` menjadi `final`. |
| 6.3.5 | Cetak Rapor | Setelah status final, klik tombol **Cetak** untuk mencetak rapor PDF |

> **Catatan:** Finalisasi bersifat permanen. Setelah rapor final, siswa/orang tua bisa melihat dan mencetak rapor. Admin juga bisa mencetak rapor kapan saja.

---

### Ringkasan Menu Guru

| No | Menu | Fungsi |
|----|------|--------|
| 1 | Dashboard | Statistik & akses cepat |
| 2 | Jadwal Mengajar | Lihat jadwal & masuk ke input nilai |
| 3 | Rekap Nilai | Lihat ringkasan nilai yang sudah diinput |
| 4 | Wali Kelas -- Data Siswa | Lihat daftar siswa (jika wali kelas) |
| 5 | Wali Kelas -- Absensi | Input absensi siswa (jika wali kelas) |
| 6 | Wali Kelas -- Rapor | Catatan wali kelas & finalisasi rapor (jika wali kelas) |

---

## C. Alur untuk Role SISWA / ORANG TUA

Siswa dan orang tua memiliki akses terbatas. Mereka hanya bisa melihat data milik sendiri dan tidak bisa mengubah apapun.

### 1. Login

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 1.1 | Buka `/login` | Form login |
| 1.2 | Masukkan email & password | Akun siswa (contoh: `siswa1@madrasah.sch.id`) atau akun orang tua |
| 1.3 | Klik **Masuk** | Masuk ke Dashboard Siswa |

---

### 2. Dashboard Siswa (`/siswa`)

Halaman utama menampilkan:

- **Informasi Pribadi**: Nama lengkap siswa dan kelas
- **Card Statistik**:
  - Rata-rata Nilai -- warna hijau jika >= 75, merah jika < 75
  - Absensi (Sakit / Izin / Alfa)
  - Total Mata Pelajaran
  - Jumlah Predikat A
  - Total Kehadiran (Sakit + Izin + Alfa)
  - NIS
- **Grafik Nilai**: Chart batang perbandingan Nilai Pengetahuan dan Nilai Keterampilan untuk setiap mata pelajaran di semester aktif
- **Tabel Daftar Nilai**: Tampilan detail nilai per mata pelajaran (Pengetahuan, Keterampilan, Sikap, Predikat)

---

### 3. Lihat Nilai Saya (`/siswa/nilai`)

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 3.1 | Buka menu **Nilai Saya** | Sidebar > Nilai Saya |
| 3.2 | Lihat semua nilai | Tabel lengkap nilai semua mata pelajaran di semester aktif: Pengetahuan, Keterampilan, Sikap, Predikat, Deskripsi |
| 3.3 | Grafik perkembangan | Jika tersedia data dari semester sebelumnya, grafik perkembangan akan ditampilkan |

> **Catatan:** Siswa/orang tua hanya bisa melihat nilai miliknya sendiri. Tidak bisa melihat data siswa lain.

---

### 4. Lihat Rapor Saya (`/siswa/rapor`)

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 4.1 | Buka menu **Rapor Saya** | Sidebar > Rapor Saya |
| 4.2 | Lihat daftar rapor | Tabel rapor yang tersedia (per tahun pelajaran & semester) |
| 4.3 | Lihat detail rapor | Klik **Detail** untuk melihat rapor lengkap: semua nilai mata pelajaran, absensi, catatan wali kelas, peringkat |
| 4.4 | Cetak rapor | Klik tombol **Cetak** jika status rapor sudah **final**. Rapor akan tampil di tab baru siap dicetak/di-PDF. |

> **Catatan:** Jika status rapor masih `draft`, tombol cetak tidak akan muncul. Siswa harus menunggu wali kelas melakukan finalisasi rapor.

---

### 5. Logout

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 5.1 | Klik tombol **Keluar** | Sidebar bagian bawah, tombol berwarna merah |
| 5.2 | Konfirmasi | Sistem akan logout dan mengarahkan kembali ke halaman login |

---

### Ringkasan Menu Siswa/Orang Tua

| No | Menu | Fungsi |
|----|------|--------|
| 1 | Dashboard | Informasi pribadi, statistik, grafik nilai, tabel nilai |
| 2 | Nilai Saya | Lihat detail semua nilai per semester |
| 3 | Rapor Saya | Lihat & cetak rapor final |

---

## D. Alur Lengkap Sistem (End-to-End)

Berikut adalah alur lengkap penggunaan sistem dari awal hingga akhir tahun ajaran:

### Tahap 1: Persiapan Data Master (Admin)

```
Admin Login
  -> Tambah Data Guru
  -> Tambah Data Kelas & Tentukan Wali Kelas
  -> Tambah Data Siswa (masukkan ke kelas masing-masing)
  -> Tambah Mata Pelajaran & Tentukan KKM
  -> Tambah Tahun Pelajaran & Aktifkan
  -> Tambah Semester & Aktifkan
  -> Buat Jadwal Mengajar (relasikan Guru - Kelas - Mapel)
```

### Tahap 2: Proses Belajar Mengajar (Guru)

```
Guru Login
  -> Lihat Jadwal Mengajar
  -> Input Nilai Pengetahuan, Keterampilan, Sikap untuk setiap siswa
  -> Cek Rekap Nilai
```

### Tahap 3: Pengelolaan Rapor (Wali Kelas)

```
Wali Kelas Login
  -> Input Absensi Siswa (Sakit, Izin, Alfa)
  -> Cek Nilai yang sudah diinput oleh guru mata pelajaran
  -> Buat/Generate Rapor (sistem hitung otomatis nilai akhir, predikat, rata-rata, peringkat)
  -> Isi Catatan Wali Kelas
  -> Finalisasi Rapor (ubah status draft -> final)
  -> Cetak Rapor untuk dibagikan ke siswa
```

### Tahap 4: Akses Siswa/Orang Tua

```
Siswa/Orang Tua Login
  -> Lihat Dashboard (nilai, statistik, grafik)
  -> Lihat Detail Nilai per Mata Pelajaran
  -> Lihat Rapor Final
  -> Cetak Rapor (download PDF / print browser)
```

### Tahap 5: Akhir Tahun Ajaran (Admin)

```
Admin Login
  -> Aktifkan Semester Genap (jika belum) atau Tahun Pelajaran Baru
  -> Lakukan Kenaikan Kelas (siswa naik tingkat)
  -> Siapkan data untuk tahun ajaran baru
```

---

## E. Diagram Alur Sederhana

```
                        +-----------+
                        |   LOGIN   |
                        +-----+-----+
                              |
                    +---------+---------+
                    |         |         |
              +-----v--+  +--v-----+  +-v--------+
              | ADMIN  |  |  GURU  |  | SISWA/OT |
              +----+---+  +---+----+  +----+-----+
                   |          |            |
        +----------+--+    +--+----+    +--+-------+
        | CRUD Master |    | Input |    |  Lihat   |
        | Data Guru   |    | Nilai |    |  Nilai   |
        | Siswa       |    |       |    |  Sendiri |
        | Kelas       |    | +--+--+    |          |
        | Mapel       |    | |  |       |  +-------+--+
        | Jadwal      |    | |  |       |  | Cetak    |
        | Semester    |    | |  +--+    |  | Rapor    |
        | Ta. Pel     |    | |     |    |  | (final)  |
        |             |    | |  +--v--+ |  +----------+
        | +---------+ |    | |  |Wali | |
        | |Kenaikan | |    | |  |Kls  | |
        | |Kelas    | |    | |  |Absen| |
        | +---------+ |    | |  |Rapor| |
        +-------------+    | |  +-----+ |
                           ++-+---------+
```

---

## F. Informasi Tambahan

### Perhitungan Nilai Otomatis

| Komponen | Rumus | Keterangan |
|----------|-------|------------|
| Nilai Akhir | Rata-rata Pengetahuan + Keterampilan | `(nilai_pengetahuan + nilai_keterampilan) / 2` |
| Predikat A | Nilai >= 90 | Sangat Baik |
| Predikat B | Nilai 80 - 89 | Baik |
| Predikat C | Nilai 70 - 79 | Cukup |
| Predikat D | Nilai < 70 | Kurang |
| Rata-rata Rapor | Rata-rata seluruh nilai mapel | Dihitung dari semua nilai mata pelajaran siswa |
| Peringkat | Urutan rata-rata nilai dalam kelas | Dibandingkan dengan siswa lain dalam kelas, tahun ajaran, semester yang sama |

### Hak Akses

| Fitur | Admin | Guru | Wali Kelas | Siswa/OT |
|-------|-------|------|------------|----------|
| Kelola Data Guru | Ya | Tidak | Tidak | Tidak |
| Kelola Data Siswa | Ya | Tidak | Tidak | Tidak |
| Kelola Kelas | Ya | Tidak | Tidak | Tidak |
| Kelola Mapel | Ya | Tidak | Tidak | Tidak |
| Kelola Jadwal | Ya | Tidak | Tidak | Tidak |
| Input Nilai | Ya | Ya* | Lihat | Tidak |
| Input Absensi | Ya | Tidak | Ya | Tidak |
| Catatan Wali Kelas | Tidak | Tidak | Ya | Tidak |
| Finalisasi Rapor | Tidak | Tidak | Ya | Tidak |
| Cetak Rapor | Ya | Tidak | Ya | Ya** |
| Lihat Nilai Sendiri | Tidak | Tidak | Tidak | Ya |
| Kenaikan Kelas | Ya | Tidak | Tidak | Tidak |

> \* Guru hanya bisa input nilai sesuai jadwal mengajarnya sendiri
> \** Siswa/orang tua hanya bisa cetak rapor dengan status final
