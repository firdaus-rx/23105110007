# Alur Penggunaan Aplikasi Smart Academic Dashboard

## MIN 21 Pidie — Sistem Pengelolaan Nilai Rapor Siswa Berbasis Web

---

## A. Alur untuk Role ADMIN

Admin memiliki akses penuh ke seluruh fitur sistem: mengelola data master, memantau akademik, melakukan kenaikan kelas, dan sinkronisasi ranking.

### 1. Login

| Langkah | Tindakan | Keterangan |
|---------|----------|------------|
| 1.1 | Buka `/login` | Form login |
| 1.2 | Masukkan email & password | Contoh: `admin@min21.sch.id` / `admin123` |
| 1.3 | Klik **Masuk** | Masuk ke Dashboard Admin |

---

### 2. Dashboard (`/admin`)

Menampilkan:
- **6 Card Statistik**: Total Siswa, Laki-laki, Perempuan, Total Guru, Total Kelas, Mata Pelajaran
- **Info Semester Aktif**: Tahun Pelajaran + Semester berjalan, nilai tertinggi/terendah
- **Grafik**: Jumlah Siswa per Kelas + Rata-rata Nilai per Kelas
- **Aksi Cepat**: tautan ke halaman utama
- **Rapor Terbaru**: 5 rapor terakhir dengan status draft/final

---

### 3. Data Guru (`/admin/guru`)

| Langkah | Tindakan |
|---------|----------|
| 3.1 | Buka **Data Guru** → lihat tabel (Nama, NIP, JK, Telepon, Akun) |
| 3.2 | **+ Tambah Guru** → isi form (NIP, Nama, JK, Telepon, Alamat, Email, Password) |
| 3.3 | **Edit** (ikon pena) / **Detail** (ikon mata) / **Hapus** (ikon tong sampah) |
| 3.4 | **Cari** guru berdasarkan Nama/NIP/Telepon |

> Saat tambah guru, sistem otomatis membuat akun User role `guru`.

---

### 4. Data Kelas (`/admin/kelas`)

| Langkah | Tindakan |
|---------|----------|
| 4.1 | Buka **Data Kelas** → tabel (Nama Kelas, Tingkat, Wali Kelas) |
| 4.2 | **+ Tambah Kelas** → isi Nama, Tingkat, pilih Wali Kelas |
| 4.3 | **Cari** kelas berdasarkan Nama/Tingkat/Wali Kelas |

---

### 5. Data Siswa (`/admin/siswa`)

| Langkah | Tindakan |
|---------|----------|
| 5.1 | Buka **Data Siswa** → tabel (NIS, Nama, Kelas, JK, Akun) |
| 5.2 | Filter **Kelas** + **Cari** (Nama/NIS/NISN) |
| 5.3 | **+ Tambah Siswa** → isi lengkap (NIS, NISN, Nama, Tempat Lahir, Tgl Lahir, JK, Agama, Alamat, Nama Ayah, Nama Ibu, Telepon Ortu, Kelas, Email, Password) |

---

### 6. Mata Pelajaran (`/admin/mata-pelajaran`)

| Langkah | Tindakan |
|---------|----------|
| 6.1 | **+ Tambah Mapel** → Kode Mapel, Nama, KKM (default 75), Kelompok, Status |
| 6.2 | **Cari** berdasarkan Nama/Kode Mapel |

---

### 7. Tahun Pelajaran (`/admin/tahun-pelajaran`)

| Langkah | Tindakan |
|---------|----------|
| 7.1 | **+ Tambah** → Nama Tahun (contoh: `2025/2026`) |
| 7.2 | Klik **Aktifkan** pada baris yang diinginkan (hanya satu yang aktif) |

---

### 8. Semester (`/admin/semester`)

| Langkah | Tindakan |
|---------|----------|
| 8.1 | **+ Tambah** → Nama Semester (Ganjil/Genap) |
| 8.2 | Klik **Aktifkan** (hanya satu yang aktif) |

---

### 9. Jadwal Mengajar (`/admin/jadwal-mengajar`)

Relasi Guru - Kelas - Mata Pelajaran dalam Tahun Pelajaran & Semester tertentu.

| Langkah | Tindakan |
|---------|----------|
| 9.1 | **+ Tambah Jadwal** → Pilih Guru, Kelas, Mapel. Tahun & Semester aktif otomatis |
| 9.2 | Sistem mencegah duplikasi (guru + kelas + mapel + tahun + semester sama) |

> Jadwal inilah yang menjadi dasar guru untuk menginput nilai. Guru hanya bisa input nilai pada jadwal miliknya.

---

### 10. Nilai Rapor (`/admin/nilai-rapor`)

| Langkah | Tindakan |
|---------|----------|
| 10.1 | **+ Tambah Nilai** → pilih Kelas → otomatis tampil **Guru** yang ngajar di kelas itu → pilih Guru → otomatis tampil **Mapel** yang diajar guru tersebut |
| 10.2 | Input nilai Pengetahuan (0-100), Keterampilan (0-100), Sikap untuk setiap siswa |
| 10.3 | **Simpan** → sistem hitung predikat + update rapor + **hitung peringkat** otomatis |

---

### 11. Absensi (`/admin/absensi`)

| Langkah | Tindakan |
|---------|----------|
| 11.1 | **+ Tambah Absensi** → Pilih Kelas, pilih Siswa, isi Sakit/Izin/Alfa |

---

### 12. Rapor (`/admin/rapor`)

| Langkah | Tindakan |
|---------|----------|
| 12.1 | Lihat daftar rapor per kelas (Total Nilai, Rata-rata, Peringkat, Status) |
| 12.2 | **Sinkron Ranking** → tombol per kelas untuk menghitung ulang peringkat semua siswa |
| 12.3 | **Finalisasi** → ubah status draft → final, otomatis hitung peringkat |
| 12.4 | **Cetak** → tampilan siap print browser |

---

### 13. Kenaikan Kelas (`/admin/kenaikan-kelas`)

| Langkah | Tindakan |
|---------|----------|
| 13.1 | Lihat daftar siswa per kelas |
| 13.2 | Centang siswa yang naik, klik **Preview Kenaikan** |
| 13.3 | Klik **Naikkan Kelas** → sistem naikkan tingkat (I-A → II-A, dst). Kelas VI otomatis lulus |

---

### Ringkasan Menu Admin

| No | Menu | Fungsi |
|----|------|--------|
| 1 | Dashboard | Statistik & grafik |
| 2 | Data Guru | CRUD guru + cari |
| 3 | Data Kelas | CRUD kelas + wali kelas |
| 4 | Data Siswa | CRUD siswa + filter kelas + cari |
| 5 | Mata Pelajaran | CRUD mapel + KKM |
| 6 | Tahun Pelajaran | Kelola tahun pelajaran |
| 7 | Semester | Kelola semester |
| 8 | Jadwal Mengajar | Atur relasi guru-kelas-mapel |
| 9 | Nilai Rapor | Kelola semua nilai |
| 10 | Absensi | Kelola absensi |
| 11 | Rapor | Kelola rapor, finalisasi, cetak, sinkron ranking |
| 12 | Kenaikan Kelas | Proses kenaikan kelas |

---

## B. Alur untuk Role GURU

Guru memiliki akses: melihat jadwal, input nilai, rekap. Jika ditunjuk sebagai wali kelas, muncul menu tambahan.

### 1. Login

| Langkah | Tindakan |
|---------|----------|
| 1.1 | Buka `/login`, masuk dengan email guru (contoh: `guru1@min21.sch.id`) |

---

### 2. Dashboard (`/guru`)

Menampilkan:
- **Banner** Tahun Pelajaran & Semester aktif
- **6 Card Statistik**: Kelas Diajar, Total Siswa, Laki-laki, Perempuan, Mapel, Total Jadwal
- **Grafik** Rata-rata Nilai per Kelas
- **Aksi Cepat**: Jadwal, Rekap Nilai, Wali Kelas
- **Kelas Saya**: kartu per kelas dengan daftar mapel + tautan **Input Nilai**

---

### 3. Jadwal Mengajar (`/guru/jadwal`)

| Langkah | Tindakan |
|---------|----------|
| 3.1 | Filter **Tahun Pelajaran** & **Semester** (default: aktif) |
| 3.2 | Lihat jadwal per kelas, klik **Input Nilai** untuk masuk ke halaman nilai |

---

### 4. Input Nilai (`/guru/nilai/{jadwal}`)

| Langkah | Tindakan |
|---------|----------|
| 4.1 | Lihat daftar siswa di kelas + mapel sesuai jadwal |
| 4.2 | Isi **Nilai Pengetahuan** (0-100), **Nilai Keterampilan** (0-100), **Sikap** |
| 4.3 | Klik **Simpan Nilai** → sistem hitung predikat (A/B/C/D) + update rapor + **hitung peringkat** otomatis |

> Guru hanya bisa input nilai untuk kelas & mapel yang ada di jadwalnya sendiri.

---

### 5. Rekap Nilai (`/guru/rekap`)

| Langkah | Tindakan |
|---------|----------|
| 5.1 | Filter **Tahun Pelajaran** & **Semester** |
| 5.2 | Lihat rata-rata nilai per mapel per kelas, warna hijau (>=75) / merah (<75) |

---

### 6. Fitur Wali Kelas (Multi Kelas)

Jika guru ditugaskan sebagai wali kelas lebih dari satu kelas, semua kelas akan tampil dengan navigasi pilih kelas.

#### 6.1 Data Siswa (`/guru/wali-kelas`)

- Lihat semua kelas walinya dalam card terpisah
- Tabel siswa per kelas
- Tombol **Absensi** & **Rapor** per kelas

#### 6.2 Absensi (`/guru/wali-kelas/absensi`)

| Langkah | Tindakan |
|---------|----------|
| 6.2.1 | Pilih kelas (dropdown) |
| 6.2.2 | Input Sakit, Izin, Alfa per siswa |
| 6.2.3 | **Simpan Absensi** |

#### 6.3 Rapor (`/guru/wali-kelas/rapor`)

| Langkah | Tindakan |
|---------|----------|
| 6.3.1 | Pilih kelas (dropdown) |
| 6.3.2 | Lihat rapor: Total Nilai, Rata-rata, Peringkat, Status |
| 6.3.3 | **Finalisasi** → ubah draft ke final, hitung peringkat |
| 6.3.4 | **Cetak** setelah final |

> Finalisasi bersifat permanen. Setelah final, siswa/orang tua bisa lihat & cetak rapor.

---

### Ringkasan Menu Guru

| No | Menu | Fungsi |
|----|------|--------|
| 1 | Dashboard | Statistik, grafik, kelas saya |
| 2 | Jadwal Mengajar | Lihat jadwal + input nilai (filter tahun/semester) |
| 3 | Rekap Nilai | Ringkasan nilai (filter tahun/semester) |
| 4 | Wali Kelas - Data Siswa | Daftar siswa (muncul jika wali kelas) |
| 5 | Wali Kelas - Absensi | Input absensi (muncul jika wali kelas) |
| 6 | Wali Kelas - Rapor | Finalisasi & cetak rapor (muncul jika wali kelas) |

> Menu Wali Kelas otomatis **sembunyi** jika guru tidak ditugaskan sebagai wali kelas.

---

## C. Alur untuk Role SISWA / ORANG TUA

Akses terbatas — hanya melihat data sendiri.

### 1. Login

| Langkah | Tindakan |
|---------|----------|
| 1.1 | Buka `/login`, masuk dengan email siswa/ortu (contoh: `siswa1@min21.sch.id`) |

---

### 2. Dashboard (`/siswa`)

- Informasi pribadi & kelas
- Statistik: Rata-rata Nilai, Absensi, Total Mapel, Predikat A
- Grafik nilai per mapel
- Tabel daftar nilai semester aktif

---

### 3. Nilai Saya (`/siswa/nilai`)

- Tabel lengkap nilai semua mapel: Pengetahuan, Keterampilan, Sikap, Predikat, Deskripsi

---

### 4. Rapor Saya (`/siswa/rapor`)

| Langkah | Tindakan |
|---------|----------|
| 4.1 | Lihat daftar rapor (per tahun/semester) |
| 4.2 | **Detail** → lihat rapor lengkap |
| 4.3 | **Cetak** → hanya jika status **final** |

> Tombol cetak hanya muncul jika status rapor sudah `final`.

---

### Ringkasan Menu Siswa/Orang Tua

| No | Menu | Fungsi |
|----|------|--------|
| 1 | Dashboard | Info pribadi, statistik, grafik, tabel nilai |
| 2 | Nilai Saya | Detail semua nilai per semester |
| 3 | Rapor Saya | Lihat & cetak rapor final |

---

## D. Alur Lengkap End-to-End

### Tahap 1: Persiapan Data Master (Admin)

```
Login Admin
  → Data Guru
  → Data Kelas + Wali Kelas
  → Data Siswa
  → Mata Pelajaran + KKM
  → Tahun Pelajaran (aktifkan)
  → Semester (aktifkan)
  → Jadwal Mengajar (relasi guru-kelas-mapel)
```

### Tahap 2: Proses Belajar Mengajar (Guru)

```
Login Guru
  → Lihat Jadwal (filter tahun/semester)
  → Input Nilai per siswa
  → Cek Rekap Nilai
```

### Tahap 3: Pengelolaan Rapor (Wali Kelas)

```
Login Wali Kelas
  → Input Absensi (pilih kelas jika multi wali)
  → Buka Rapor per kelas
  → Isi Catatan Wali Kelas (jika perlu)
  → Finalisasi Rapor (draft → final, hitung peringkat)
  → Cetak Rapor
```

### Tahap 4: Sinkronisasi Ranking (Admin)

```
Login Admin
  → Buka menu Rapor
  → Klik "Sinkron Ranking" per kelas
  → Sistem update/create rapor + hitung ulang peringkat semua siswa
```

### Tahap 5: Akses Siswa/Orang Tua

```
Login Siswa/Orang Tua
  → Lihat Dashboard (nilai, statistik, grafik)
  → Lihat Detail Nilai
  → Lihat & Cetak Rapor (jika status final)
```

### Tahap 6: Akhir Tahun Ajaran (Admin)

```
Login Admin
  → Ganti semester / tahun pelajaran aktif
  → Kenaikan Kelas
  → Siapkan data tahun ajaran baru
```

---

## E. Diagram Alur

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
         | CRUD Semua  |    | Input |    |  Lihat   |
         | Data Master |    | Nilai |    |  Nilai   |
         | Jadwal      |    |       |    |  Sendiri |
         | Nilai       |    | +--+--+    |          |
         | Absensi     |    | |  |       |  +-------+--+
         | Rapor       |    | |  +--+    |  | Cetak    |
         | Kenaikan    |    | |     |    |  | Rapor    |
         |             |    | |  +--v--+ |  | (final)  |
         | Sinkron     |    | |  |Wali | |  +----------+
         | Ranking     |    | |  |Kls  | |
         +-------------+    | |  |Absen| |
                            | |  |Rapor| |
                            ++-+  +-----+
```

---

## F. Perhitungan Nilai Otomatis

| Komponen | Rumus |
|----------|-------|
| Nilai Akhir | `(nilai_pengetahuan + nilai_keterampilan) / 2` |
| Predikat A | Nilai >= 90 |
| Predikat B | Nilai 80 - 89 |
| Predikat C | Nilai 70 - 79 |
| Predikat D | Nilai < 70 |
| Rata-rata Rapor | Rata-rata seluruh nilai akhir mapel |
| Peringkat | Urutan rata-rata dalam kelas (1 = tertinggi) |

---

## G. Hak Akses

| Fitur | Admin | Guru | Wali Kelas | Siswa/OT |
|-------|-------|------|------------|----------|
| Kelola Data Guru | Ya | - | - | - |
| Kelola Data Siswa | Ya | - | - | - |
| Kelola Kelas | Ya | - | - | - |
| Kelola Mapel | Ya | - | - | - |
| Kelola Jadwal | Ya | - | - | - |
| Input Nilai | Ya | Ya* | Lihat | - |
| Input Absensi | Ya | - | Ya | - |
| Catatan Wali Kelas | - | - | Ya | - |
| Finalisasi Rapor | Ya | - | Ya | - |
| Cetak Rapor | Ya | - | Ya | Ya** |
| Lihat Nilai Sendiri | - | - | - | Ya |
| Kenaikan Kelas | Ya | - | - | - |
| Sinkron Ranking | Ya | - | - | - |
| Profil Saya | Ya | Ya | Ya | Ya |

> \* Guru hanya input nilai sesuai jadwal mengajarnya  
> \** Siswa/OT hanya cetak rapor dengan status final

---

## H. Fitur Spesifik

### Cascading Dropdown Nilai Rapor
Saat tambah/edit nilai rapor:
1. Pilih **Kelas** → otomatis tampil **Guru** yang mengajar di kelas itu
2. Pilih **Guru** → otomatis tampil **Mata Pelajaran** yang diajar guru tersebut

### Multi Wali Kelas
Guru bisa menjadi wali kelas untuk lebih dari satu kelas. Semua kelas akan tampil dengan navigasi pilih kelas di halaman absensi & rapor.

### Sidebar Adaptif
- Menu **Wali Kelas** otomatis **sembunyi** jika guru tidak ditugaskan sebagai wali kelas
- Menu aktif terdeteksi berdasarkan **nama route** (bukan URL), sehingga tidak ada bentrok antar menu

### Perhitungan Ranking Otomatis
Ranking dihitung ulang setiap kali:
- Admin/tambah/edit nilai rapor
- Guru input nilai
- Admin sinkron ranking per kelas
- Admin finalisasi rapor
