# Smart Academic Dashboard — MIN 21 Pidie

**Sistem Pengelolaan Nilai Rapor Siswa Berbasis Web**

---

## Daftar Isi

1. [Arsitektur Sistem](#1-arsitektur-sistem)
2. [Struktur Database](#2-struktur-database)
3. [Relasi Model](#3-relasi-model)
4. [Flowchart Sistem](#4-flowchart-sistem)
5. [Fitur & Modul](#5-fitur--modul)
6. [Hak Akses & Role](#6-hak-akses--role)
7. [Route & Endpoint](#7-route--endpoint)
8. [Alur CRUD](#8-alur-crud)
9. [Perhitungan Nilai](#9-perhitungan-nilai)
10. [Validasi](#10-validasi)
11. [Teknologi](#11-teknologi)
12. [Cara Instalasi](#12-cara-instalasi)

---

## 1. Arsitektur Sistem

### Arsitektur Umum

```
┌─────────────────────────────────────────────────────────────┐
│                     Browser (Client)                        │
│              Blade + TailwindCSS + Chart.js                  │
└──────────────────┬──────────────────────────────────────────┘
                   │ HTTP Request (GET/POST/PUT/DELETE)
                   ▼
┌─────────────────────────────────────────────────────────────┐
│                   Laravel 12 (Server)                        │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌────────────┐  │
│  │  Routes  │→ │Middleware│→ │Controller│→ │   Model    │  │
│  │ web.php  │  │  Auth,   │  │          │  │ (Eloquent) │  │
│  │          │  │  Role    │  │          │  │            │  │
│  └──────────┘  └──────────┘  └──────────┘  └──────┬─────┘  │
│                                                    │        │
│  ┌─────────────────────────────────────────────────▼──────┐ │
│  │                    MySQL Database                        │ │
│  │  11 tabel utama + 3 tabel sistem (cache, jobs, session)│ │
│  └────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────┘
```

### Diagram Alur Request

```
User → Login → Session → Request → Middleware Auth
    ↓                                     ↓
  Role: admin/guru/siswa         RoleMiddleware (cek role)
    ↓                                     ↓
  View Blade + Data              Controller → Model → Database
    ↓                                     ↓
  Render HTML + CSS/JS           Response JSON/Redirect/View
```

---

## 2. Struktur Database

### 2.1 Tabel `users`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | Auto increment |
| name | varchar(255) | Nama pengguna |
| email | varchar(255) | Email login (unique) |
| password | varchar(255) | Hash |
| role | enum('admin','guru','siswa','orang_tua') | Hak akses |
| remember_token | varchar(100) | Remember me |
| created_at | timestamp | |
| updated_at | timestamp | |

### 2.2 Tabel `gurus`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | |
| user_id | bigint (FK → users) | Nullable, nullOnDelete |
| nip | varchar(255) | Unique, nullable |
| nama_guru | varchar(255) | |
| jenis_kelamin | enum('L','P') | |
| telepon | varchar(255) | Nullable |
| alamat | text | Nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

### 2.3 Tabel `kelas`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | |
| nama_kelas | varchar(255) | Contoh: I A, II B |
| tingkat | tinyint | 1-6 |
| wali_kelas_id | bigint (FK → gurus) | Nullable, nullOnDelete |
| created_at | timestamp | |
| updated_at | timestamp | |

### 2.4 Tabel `siswas`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | |
| user_id | bigint (FK → users) | Nullable |
| kelas_id | bigint (FK → kelas) | Nullable |
| nis | varchar(255) | Unique, nullable |
| nisn | varchar(255) | Unique, nullable |
| nama_siswa | varchar(255) | |
| tempat_lahir | varchar(100) | Nullable |
| tanggal_lahir | date | Nullable |
| jenis_kelamin | enum('L','P') | |
| agama | varchar(50) | Nullable |
| alamat | text | Nullable |
| nama_ayah | varchar(255) | Nullable |
| nama_ibu | varchar(255) | Nullable |
| telepon_orang_tua | varchar(20) | Nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

### 2.5 Tabel `mata_pelajarans`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | |
| kode_mapel | varchar(255) | Unique, nullable |
| nama_mapel | varchar(255) | |
| kkm | integer | Default 75 |
| kelompok | varchar(100) | Nullable (A/B) |
| status | enum('aktif','nonaktif') | Default 'aktif' |
| created_at | timestamp | |
| updated_at | timestamp | |

### 2.6 Tabel `tahun_pelajarans`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | |
| nama_tahun | varchar(255) | Unique, contoh: 2025/2026 |
| status_aktif | boolean | Default false |
| created_at | timestamp | |
| updated_at | timestamp | |

### 2.7 Tabel `semesters`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | |
| nama_semester | enum('Ganjil','Genap') | |
| status_aktif | boolean | Default false |
| created_at | timestamp | |
| updated_at | timestamp | |

### 2.8 Tabel `jadwal_mengajars`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | |
| guru_id | bigint (FK → gurus) | Cascade |
| kelas_id | bigint (FK → kelas) | Cascade |
| mata_pelajaran_id | bigint (FK → mata_pelajarans) | Cascade |
| tahun_pelajaran_id | bigint (FK → tahun_pelajarans) | Cascade |
| semester_id | bigint (FK → semesters) | Cascade |
| created_at | timestamp | |
| updated_at | timestamp | |
| **UNIQUE** | (guru_id, kelas_id, mata_pelajaran_id, tahun_pelajaran_id, semester_id) | |

### 2.9 Tabel `nilai_rapors`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | |
| siswa_id | bigint (FK → siswas) | Cascade |
| guru_id | bigint (FK → gurus) | Cascade |
| kelas_id | bigint (FK → kelas) | Cascade |
| mata_pelajaran_id | bigint (FK → mata_pelajarans) | Cascade |
| tahun_pelajaran_id | bigint (FK → tahun_pelajarans) | Cascade |
| semester_id | bigint (FK → semesters) | Cascade |
| nilai_pengetahuan | integer | Nullable, 0-100 |
| nilai_keterampilan | integer | Nullable, 0-100 |
| nilai_sikap | varchar(50) | Nullable |
| predikat | varchar(10) | A/B/C/D |
| deskripsi | text | Nullable |
| created_at | timestamp | |
| updated_at | timestamp | |
| **UNIQUE** | (siswa_id, mata_pelajaran_id, tahun_pelajaran_id, semester_id) | |

### 2.10 Tabel `absensis`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | |
| siswa_id | bigint (FK → siswas) | Cascade |
| kelas_id | bigint (FK → kelas) | Cascade |
| tahun_pelajaran_id | bigint (FK → tahun_pelajarans) | Cascade |
| semester_id | bigint (FK → semesters) | Cascade |
| sakit | integer | Default 0 |
| izin | integer | Default 0 |
| alfa | integer | Default 0 |
| created_at | timestamp | |
| updated_at | timestamp | |
| **UNIQUE** | (siswa_id, tahun_pelajaran_id, semester_id) | |

### 2.11 Tabel `rapors`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | |
| siswa_id | bigint (FK → siswas) | Cascade |
| kelas_id | bigint (FK → kelas) | Cascade |
| tahun_pelajaran_id | bigint (FK → tahun_pelajarans) | Cascade |
| semester_id | bigint (FK → semesters) | Cascade |
| total_nilai | integer | Default 0 |
| rata_rata | decimal(5,2) | Default 0 |
| peringkat | integer | Nullable |
| catatan_wali_kelas | text | Nullable |
| status_rapor | enum('draft','final') | Default 'draft' |
| tanggal_rapor | date | Nullable |
| created_at | timestamp | |
| updated_at | timestamp | |
| **UNIQUE** | (siswa_id, kelas_id, tahun_pelajaran_id, semester_id) | |

---

## 3. Relasi Model

```
User
  ├── hasOne → Guru
  └── hasOne → Siswa

Guru
  ├── belongsTo → User
  ├── hasMany → JadwalMengajar
  ├── hasMany → NilaiRapor
  └── hasMany → Kelas (sebagai waliKelas)

Kelas
  ├── belongsTo → Guru (waliKelas)
  ├── hasMany → Siswa
  ├── hasMany → JadwalMengajar
  ├── hasMany → NilaiRapor
  └── hasMany → Rapor

Siswa
  ├── belongsTo → User
  ├── belongsTo → Kelas
  ├── hasMany → NilaiRapor
  ├── hasMany → Absensi
  └── hasMany → Rapor

MataPelajaran
  ├── hasMany → JadwalMengajar
  └── hasMany → NilaiRapor

TahunPelajaran
  ├── hasMany → JadwalMengajar
  ├── hasMany → NilaiRapor
  ├── hasMany → Absensi
  └── hasMany → Rapor

Semester
  ├── hasMany → JadwalMengajar
  ├── hasMany → NilaiRapor
  ├── hasMany → Absensi
  └── hasMany → Rapor

JadwalMengajar
  ├── belongsTo → Guru
  ├── belongsTo → Kelas
  ├── belongsTo → MataPelajaran
  ├── belongsTo → TahunPelajaran
  └── belongsTo → Semester

NilaiRapor
  ├── belongsTo → Siswa
  ├── belongsTo → Guru
  ├── belongsTo → Kelas
  ├── belongsTo → MataPelajaran
  ├── belongsTo → TahunPelajaran
  └── belongsTo → Semester

Absensi
  ├── belongsTo → Siswa
  ├── belongsTo → Kelas
  ├── belongsTo → TahunPelajaran
  └── belongsTo → Semester

Rapor
  ├── belongsTo → Siswa
  ├── belongsTo → Kelas
  ├── belongsTo → TahunPelajaran
  └── belongsTo → Semester
```

---

## 4. Flowchart Sistem

### 4.1 Flowchart Login & Autentikasi

```
┌──────────────┐
│   Buka App   │
└──────┬───────┘
       ▼
┌──────────────┐
│ Halaman Awal │
│  Welcome     │
└──────┬───────┘
       ▼
┌──────────────┐
│  Login Form  │ ←─── Masukkan Email + Password
└──────┬───────┘
       ▼
┌──────────────────────┐     Salah
│  Validasi Credential │─────────────────→ Kembali ke Login + Error
└──────┬───────────────┘
       │ Benar
       ▼
┌──────────────────┐
│  Cek Role User   │
└──────┬───────────┘
       │
       ├──── admin ────→ Redirect ke /admin/dashboard
       │
       ├──── guru ─────→ Redirect ke /guru/dashboard
       │
       └──── siswa ────→ Redirect ke /siswa/dashboard
```

### 4.2 Flowchart Manajemen Data (Admin)

```
┌──────────────────────────────┐
│   Admin Dashboard            │
│   (Statistik + Chart)        │
└──────┬───────────────────────┘
       │
       ├── Master Data ─────────────────────────────────────┐
       │   ├── Data Guru  (CRUD Guru + User Account)        │
       │   ├── Data Kelas (CRUD Kelas + Wali Kelas)        │
       │   ├── Data Siswa (CRUD Siswa + User Account)      │
       │   └── Mata Pelajaran (CRUD Mapel + KKM)          │
       │                                                   │
       ├── Pengaturan ─────────────────────────────────────┐
       │   ├── Tahun Pelajaran (CRUD + Set Aktif)          │
       │   └── Semester (CRUD + Set Aktif)                 │
       │                                                   │
       └── Akademik ───────────────────────────────────────┐
           ├── Jadwal Mengajar (Atur Guru → Kelas → Mapel) │
           ├── Nilai Rapor (Input/Bulk Nilai Siswa)       │
           ├── Absensi (Input/Bulk Absensi)               │
           ├── Rapor (Generate + Finalisasi)              │
           └── Kenaikan Kelas (Promote Siswa)             │
```

### 4.3 Flowchart Input Nilai (Guru)

```
┌──────────────────────┐
│   Login sebagai Guru │
└──────┬───────────────┘
       ▼
┌──────────────────────┐
│  Dashboard Guru      │
│  - Kartu Statistik   │
│  - Kelas Saya (card) │
└──────┬───────────────┘
       │
       ├──→ Jadwal Mengajar (Daftar jadwal per kelas)
       │
       └──→ Pilih Kelas → Daftar Mapel
                │
                ▼
         ┌──────────────────┐
         │ Input Nilai       │
         │ - Table Siswa     │
         │ - Pengetahuan     │
         │ - Keterampilan    │
         │ - Sikap           │
         └──────┬───────────┘
                ▼
         ┌──────────────────┐
         │ Simpan (Bulk)     │
         │ → NilaiService    │
         │ → Hitung Predikat │
         │ → Update Rapor    │
         └──────┬───────────┘
                ▼
         ┌──────────────────┐
         │ Success Redirect  │
         └──────────────────┘
```

### 4.4 Flowchart Wali Kelas

```
┌──────────────────────┐
│   Login sebagai Guru │
│   (Wali Kelas)       │
└──────┬───────────────┘
       ▼
┌─────────────────────────────────────┐
│  Menu Wali Kelas                    │
│  ┌──────────┐ ┌──────────┐ ┌──────┐ │
│  │ Absensi  │ │  Rapor   │ │ Cetak│ │
│  └──────────┘ └──────────┘ └──────┘ │
└──────┬──────────────────────────────┘
       │
       ├── Absensi ──→ Form Bulk Absensi (Sakit/Izin/Alfa)
       │                   per Siswa → Simpan
       │
       ├── Rapor ────→ Tabel Rapor Siswa
       │                ├── Finalisasi (set status final)
       │                └── Cetak (view print)
       │
       └── Cetak ────→ View Print Rapor (CSS Print)
```

### 4.5 Flowchart Siswa/Orang Tua

```
┌──────────────────────┐
│   Login sebagai      │
│   Siswa / Orang Tua  │
└──────┬───────────────┘
       ▼
┌──────────────────────┐
│  Dashboard Siswa     │
│  - Stat Cards        │
│  - Chart Nilai       │
│  - Tabel Nilai       │
└──────┬───────────────┘
       │
       ├── Nilai Saya ──→ Tabel Nilai per Semester
       │                    (Group by Tahun/Semester)
       │
       └── Rapor Saya ──→ Daftar Rapor Final
                            └── Cetak Rapor (PDF/Print)
```

### 4.6 Flowchart Perhitungan Nilai

```
┌────────────────────────┐
│  Input Nilai           │
│  - Pengetahuan (P)     │
│  - Keterampilan (K)    │
└──────┬─────────────────┘
       ▼
┌────────────────────────┐
│  Nilai Akhir = (P+K)/2 │
└──────┬─────────────────┘
       ▼
┌────────────────────────┐
│  Predikat              │
│  A = 90-100            │
│  B = 80-89             │
│  C = 70-79             │
│  D = < 70              │
└──────┬─────────────────┘
       ▼
┌────────────────────────┐
│  Update Rapor Siswa    │
│  - Total Nilai         │
│  - Rata-rata           │
└──────┬─────────────────┘
       ▼
┌────────────────────────┐
│  Hitung Peringkat      │
│  (Per Kelas/Tahun/Sem) │
└────────────────────────┘
```

### 4.7 Flowchart Kenaikan Kelas

```
┌──────────────────────────┐
│  Admin → Kenaikan Kelas  │
└──────┬───────────────────┘
       ▼
┌──────────────────────────┐
│  Pilih Tahun & Semester  │
│  Asal                    │
└──────┬───────────────────┘
       ▼
┌──────────────────────────┐
│  Tampilkan Pratinjau     │
│  - Per Kelas             │
│  - Daftar Siswa          │
│  - Kelas Tujuan          │
│  - Checkbox per Siswa    │
└──────┬───────────────────┘
       ▼
┌──────────────────────────┐
│  Pilih Siswa → Naikkan   │
└──────┬───────────────────┘
       ▼
┌──────────────────────────┐
│  Proses (Transaction)    │
│  - Cari kelas tingkat+1  │
│  - Update kelas_id siswa │
│  - Jika tingkat 6 → LULUS│
└──────┬───────────────────┘
       ▼
┌──────────────────────────┐
│  "X naik, Y lulus"       │
│  → Redirect + Success    │
└──────────────────────────┘
```

---

## 5. Fitur & Modul

### 5.1 Modul Admin

| Modul | Deskripsi | Method |
|-------|-----------|--------|
| **Dashboard** | Statistik: total siswa, guru, kelas, mapel + chart | GET |
| **Data Guru** | CRUD guru + buat/update akun user langsung | GET, POST, PUT, DELETE |
| **Data Kelas** | CRUD kelas + tentukan wali kelas | GET, POST, PUT, DELETE |
| **Data Siswa** | CRUD siswa + buat/update akun user langsung | GET, POST, PUT, DELETE |
| **Mata Pelajaran** | CRUD mapel + KKM + status aktif/nonaktif | GET, POST, PUT, DELETE |
| **Tahun Pelajaran** | CRUD tahun + toggle status aktif | GET, POST, PUT, DELETE |
| **Semester** | CRUD semester + toggle status aktif | GET, POST, PUT, DELETE |
| **Jadwal Mengajar** | Atur guru → kelas → mapel per tahun/semester | GET, POST, PUT, DELETE |
| **Nilai Rapor** | Input/bulk nilai siswa per kelas + mapel | GET, POST, PUT, DELETE |
| **Absensi** | Input absensi per siswa (sakit/izin/alfa) | GET, POST, PUT, DELETE |
| **Rapor** | Generate rapor, finalisasi, cetak | GET, POST, PUT, DELETE |
| **Kenaikan Kelas** | Naikkan siswa ke kelas berikutnya | GET, POST |

### 5.2 Modul Guru

| Modul | Deskripsi |
|-------|-----------|
| **Dashboard** | Stat: kelas diajar, total siswa, mapel, jadwal + chart nilai |
| **Jadwal Mengajar** | Daftar jadwal per kelas (group by kelas) |
| **Input Nilai** | Pilih jadwal → input nilai per siswa (pengetahuan, keterampilan, sikap) |
| **Rekap Nilai** | Rata-rata nilai per kelas/mapel |
| **Wali Kelas - Data Siswa** | Lihat daftar siswa kelas walinya |
| **Wali Kelas - Absensi** | Input absensi bulk per kelas |
| **Wali Kelas - Rapor** | Finalisasi & cetak rapor |

### 5.3 Modul Siswa / Orang Tua

| Modul | Deskripsi |
|-------|-----------|
| **Dashboard** | Stat cards + chart nilai per mapel + tabel nilai semester aktif |
| **Nilai Saya** | Riwayat nilai per semester (group by tahun/semester) |
| **Rapor Saya** | Daftar rapor final + cetak |

---

## 6. Hak Akses & Role

| Role | Dashboard | CRUD Data | Input Nilai | Absensi | Rapor | Kenaikan Kelas |
|------|-----------|-----------|-------------|---------|-------|----------------|
| **Admin** | ✅ Statistik lengkap | ✅ Semua | ✅ | ✅ | ✅ Finalisasi & Cetak | ✅ |
| **Guru** | ✅ Terbatas | ❌ | ✅ Kelas diajar | ✅ Wali kelas | ✅ Wali kelas | ❌ |
| **Siswa** | ✅ Pribadi | ❌ | ❌ | ❌ | ✅ Lihat & Cetak | ❌ |
| **Orang Tua** | ✅ Lihat anak | ❌ | ❌ | ❌ | ✅ Lihat & Cetak | ❌ |

---

## 7. Route & Endpoint

### 7.1 Public Routes

| Method | URI | Nama Route | Controller |
|--------|-----|------------|------------|
| GET | `/` | - | Welcome |
| GET | `/login` | `login` | AuthController@showLogin |
| POST | `/login` | - | AuthController@login |
| POST | `/logout` | `logout` | AuthController@logout |
| GET | `/rapor/{rapor}/cetak` | `rapor.cetak` | RaporController@cetak |

### 7.2 Admin Routes (`/admin/*`) — middleware: auth, role:admin

| Method | URI | Nama Route | Controller |
|--------|-----|------------|------------|
| GET | `/admin` | `admin.dashboard` | Admin\DashboardController@index |
| GET/POST/PUT/DELETE | `/admin/guru` | `guru.*` | Admin\GuruController (resource) |
| GET/POST/PUT/DELETE | `/admin/kelas` | `kelas.*` | Admin\KelasController (resource) |
| GET/POST/PUT/DELETE | `/admin/siswa` | `siswa.*` | Admin\SiswaController (resource) |
| GET/POST/PUT/DELETE | `/admin/mata-pelajaran` | `mata-pelajaran.*` | Admin\MataPelajaranController (resource) |
| GET/POST/PUT/DELETE | `/admin/tahun-pelajaran` | `tahun-pelajaran.*` | Admin\TahunPelajaranController (resource) |
| GET/POST/PUT/DELETE | `/admin/semester` | `semester.*` | Admin\SemesterController (resource) |
| GET/POST/PUT/DELETE | `/admin/jadwal-mengajar` | `jadwal-mengajar.*` | Admin\JadwalMengajarController (resource) |
| GET/POST/PUT/DELETE | `/admin/nilai-rapor` | `nilai-rapor.*` | Admin\NilaiRaporController (resource) |
| GET/POST/PUT/DELETE | `/admin/absensi` | `absensi.*` | Admin\AbsensiController (resource) |
| GET/POST/PUT/DELETE | `/admin/rapor` | `rapor.*` | Admin\RaporController (resource) |
| GET | `/admin/kenaikan-kelas` | `admin.kenaikan-kelas` | Admin\KenaikanKelasController@index |
| POST | `/admin/kenaikan-kelas/promote` | `admin.kenaikan-kelas.promote` | Admin\KenaikanKelasController@promote |
| GET | `/admin/nilai-rapor/get-siswa/{kelas}` | `nilai-rapor.get-siswa` | Admin\NilaiRaporController@getSiswaByKelas |
| GET | `/admin/rapor/get-siswa/{kelas}` | `rapor.get-siswa` | Admin\RaporController@getSiswaByKelas |
| GET | `/admin/rapor/get-data/{siswa}` | `rapor.get-data` | Admin\RaporController@getRaporData |

### 7.3 Guru Routes (`/guru/*`) — middleware: auth, role:guru

| Method | URI | Nama Route | Controller |
|--------|-----|------------|------------|
| GET | `/guru` | `guru.dashboard` | Guru\DashboardController@index |
| GET | `/guru/jadwal` | `guru.jadwal` | Guru\DashboardController@jadwal |
| GET | `/guru/nilai/{jadwal}` | `guru.nilai.index` | Guru\NilaiController@index |
| POST | `/guru/nilai/{jadwal}` | `guru.nilai.store` | Guru\NilaiController@store |
| GET | `/guru/rekap` | `guru.nilai.rekap` | Guru\NilaiController@rekap |
| GET | `/guru/wali-kelas` | `guru.wali.index` | Guru\WaliKelasController@index |
| GET | `/guru/wali-kelas/absensi` | `guru.wali.absensi` | Guru\WaliKelasController@absensi |
| POST | `/guru/wali-kelas/absensi` | `guru.wali.absensi.store` | Guru\WaliKelasController@storeAbsensi |
| GET | `/guru/wali-kelas/rapor` | `guru.wali.rapor` | Guru\WaliKelasController@rapor |
| PUT | `/guru/wali-kelas/rapor/{rapor}` | `guru.wali.rapor.update` | Guru\WaliKelasController@updateRapor |
| POST | `/guru/wali-kelas/rapor/{rapor}/finalisasi` | `guru.wali.rapor.finalisasi` | Guru\WaliKelasController@finalisasi |

### 7.4 Siswa Routes (`/siswa/*`) — middleware: auth, role:siswa,orang_tua

| Method | URI | Nama Route | Controller |
|--------|-----|------------|------------|
| GET | `/siswa` | `siswa.dashboard` | Siswa\DashboardController@index |
| GET | `/siswa/nilai` | `siswa.nilai` | Siswa\DashboardController@nilai |
| GET | `/siswa/rapor` | `siswa.rapor` | Siswa\DashboardController@rapor |

---

## 8. Alur CRUD

### 8.1 Create (Tambah Data)

```
1. User klik tombol "Tambah"
2. GET → Controller@create → return view create
3. Form menampilkan field sesuai migration
4. User isi data + submit
5. POST → Controller@store
   ├── Validasi (FormRequest / inline)
   ├── Jika validasi gagal → back with errors
   └── Jika validasi lolos → create record
         └── Redirect → index + flash success
```

### 8.2 Read (Lihat Data)

```
1. GET → Controller@index
   ├── Query: Model::with(relasi)->latest()->get()
   ├── Group/filter sesuai parameter request
   └── return view index compact(data)

2. GET → Controller@show($id)
   ├── Route model binding
   ├── Load relasi
   └── return view show compact(model)
```

### 8.3 Update (Edit Data)

```
1. User klik "Edit"
2. GET → Controller@edit($id)
   ├── Load relasi
   └── return view edit compact(model)

3. Form pre-filled with data
4. User ubah + submit
5. PUT/PATCH → Controller@update($id)
   ├── Validasi (same rules + ignore current ID)
   ├── Jika gagal → back with errors
   └── Jika lolos → update record
         └── Redirect → index + flash success
```

### 8.4 Delete (Hapus Data)

```
1. User klik "Hapus" → confirm dialog
2. DELETE → Controller@destroy($id)
   ├── Route model binding
   ├── Model::delete()
   └── Redirect → index + flash success
```

---

## 9. Perhitungan Nilai

### 9.1 Nilai Akhir

```
Nilai Akhir = (Nilai Pengetahuan + Nilai Keterampilan) / 2
```

### 9.2 Predikat

| Rentang | Predikat |
|---------|----------|
| 90 - 100 | A (Sangat Baik) |
| 80 - 89 | B (Baik) |
| 70 - 79 | C (Cukup) |
| < 70 | D (Kurang) |

### 9.3 Deskripsi

```
Jika Nilai Akhir ≥ KKM:
  "Siswa mampu menguasai materi {nama_mapel} dengan baik."
Jika Nilai Akhir < KKM:
  "Siswa perlu bimbingan lebih dalam memahami materi {nama_mapel}."
```

### 9.4 Rata-rata Rapor

```
Rata-rata = Rata-rata dari semua Nilai Akhir siswa
           pada suatu semester / tahun pelajaran
```

### 9.5 Peringkat

```
Peringkat dihitung berdasarkan urutan Rata-rata
siswa dalam satu Kelas, Tahun Pelajaran, dan Semester yang sama.
Peringkat 1 = nilai rata-rata tertinggi.
```

---

## 10. Validasi

### 10.1 Unique Rules

| Field | Tabel | Scope |
|-------|-------|-------|
| email | users | Global unique |
| nip | gurus | Unique, ignore current ID saat update |
| nis | siswas | Unique, ignore current ID saat update |
| nisn | siswas | Unique, ignore current ID saat update |
| kode_mapel | mata_pelajarans | Unique, ignore current ID saat update |
| nama_tahun | tahun_pelajarans | Unique, ignore current ID saat update |

### 10.2 Range Validation

| Field | Min | Max |
|-------|-----|-----|
| nilai_pengetahuan | 0 | 100 |
| nilai_keterampilan | 0 | 100 |
| kkm | 0 | 100 |
| sakit/izin/alfa | 0 | - |

### 10.3 Enum Validation

| Field | Values |
|-------|--------|
| role | admin, guru, siswa, orang_tua |
| jenis_kelamin | L, P |
| nama_semester | Ganjil, Genap |
| status (mapel) | aktif, nonaktif |
| status_rapor | draft, final |

### 10.4 Duplicate Prevention

| Fitur | Unique Key |
|-------|------------|
| Jadwal Mengajar | (guru_id, kelas_id, mata_pelajaran_id, tahun_pelajaran_id, semester_id) |
| Nilai Rapor | (siswa_id, mata_pelajaran_id, tahun_pelajaran_id, semester_id) |
| Absensi | (siswa_id, tahun_pelajaran_id, semester_id) |
| Rapor | (siswa_id, kelas_id, tahun_pelajaran_id, semester_id) |

---

## 11. Teknologi

| Komponen | Teknologi |
|----------|-----------|
| Framework | Laravel 12 |
| Bahasa | PHP 8.2+ |
| Database | MySQL |
| Frontend | Blade + TailwindCSS 4 + Vite |
| Icons | Phosphor Icons (CDN) |
| Chart | Chart.js (CDN) |
| Auth | Manual (Session-based) |
| Middleware | Custom RoleMiddleware |

### Package

```json
{
  "require": {
    "php": "^8.2",
    "laravel/framework": "^12.0",
    "laravel/tinker": "^2.10.1"
  },
  "devDependencies": {
    "@tailwindcss/vite": "^4.0.0",
    "tailwindcss": "^4.0.0",
    "vite": "^7.0.7"
  }
}
```

---

## 12. Cara Instalasi

### 12.1 Prasyarat

- PHP 8.2+
- Composer
- MySQL / MariaDB
- Node.js 18+ & NPM

### 12.2 Langkah Instalasi

```bash
# 1. Clone project
git clone <repository-url> smart-academic
cd smart-academic

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Konfigurasi database di .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=smart_academic
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Buat database
mysql -u root -p -e "CREATE DATABASE smart_academic"

# 8. Migrate + seed
php artisan migrate --seed

# 9. Build frontend
npm run build

# 10. Jalankan server
php artisan serve
# Akses: http://localhost:8000
```

### 12.3 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@min21.sch.id | admin123 |
| Guru | guru1@min21.sch.id | guru123 |
| Siswa | siswa1@min21.sch.id | siswa123 |

---

## Diagram Relasi Database (ERD)

```
┌─────────┐       ┌─────────┐       ┌──────────┐
│  users  │──1:1──│  gurus  │──1:M──│  kelas   │
└─────────┘       └─────────┘       └──────────┘
     │1:1                               │1:M
     │                                  ├──────────┐
     │                                  │          │
┌─────────┐                        ┌────────┐  ┌──────────┐
│ siswas  │────────────────────────│ jadwal │  │  rapors  │
└─────────┘  1:M                   │mengajar│  └──────────┘
     │                             └────────┘
     │1:M                               │1:M
     │                                  │
┌──────────┐                       ┌──────────┐
│ absensis │                       │nilai_rapor│
└──────────┘                       └──────────┘

┌────────────────┐    1:M     ┌────────────────┐
│ mata_pelajarans│────────────│  nilai_rapors  │
└────────────────┘            └────────────────┘

┌─────────────────┐    1:M    ┌───────────────────┐
│ tahun_pelajarans│───────────│ jadwal_mengajars  │
└─────────────────┘           └───────────────────┘
        │1:M                         │
        ├────────────────────────────┤
        │                            │
┌─────────────────┐            ┌──────────┐
│   semesters     │────────────│ absensis │
└─────────────────┘            └──────────┘
```

---

## Struktur Direktori

```
smart-academic/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AbsensiController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── GuruController.php
│   │   │   │   ├── JadwalMengajarController.php
│   │   │   │   ├── KelasController.php
│   │   │   │   ├── KenaikanKelasController.php
│   │   │   │   ├── MataPelajaranController.php
│   │   │   │   ├── NilaiRaporController.php
│   │   │   │   ├── RaporController.php
│   │   │   │   ├── SemesterController.php
│   │   │   │   └── SiswaController.php
│   │   │   ├── Guru/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── NilaiController.php
│   │   │   │   └── WaliKelasController.php
│   │   │   ├── Siswa/
│   │   │   │   └── DashboardController.php
│   │   │   ├── AuthController.php
│   │   │   └── RaporController.php
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php
│   │   └── Requests/
│   │       ├── StoreAbsensiRequest.php
│   │       ├── StoreGuruRequest.php
│   │       ├── StoreJadwalRequest.php
│   │       ├── StoreKelasRequest.php
│   │       ├── StoreMapelRequest.php
│   │       ├── StoreNilaiRequest.php
│   │       ├── StoreRaporRequest.php
│   │       └── StoreSiswaRequest.php
│   ├── Models/
│   │   ├── Absensi.php
│   │   ├── Guru.php
│   │   ├── JadwalMengajar.php
│   │   ├── Kelas.php
│   │   ├── MataPelajaran.php
│   │   ├── NilaiRapor.php
│   │   ├── Rapor.php
│   │   ├── Semester.php
│   │   ├── Siswa.php
│   │   ├── TahunPelajaran.php
│   │   └── User.php
│   └── Services/
│       └── NilaiService.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2024_01_01_000001_create_gurus_table.php
│   │   ├── 2024_01_01_000002_create_kelas_table.php
│   │   ├── 2024_01_01_000003_create_siswas_table.php
│   │   ├── 2024_01_01_000004_create_mata_pelajarans_table.php
│   │   ├── 2024_01_01_000005_create_tahun_pelajarans_table.php
│   │   ├── 2024_01_01_000006_create_semesters_table.php
│   │   ├── 2024_01_01_000007_create_jadwal_mengajars_table.php
│   │   ├── 2024_01_01_000008_create_nilai_rapors_table.php
│   │   ├── 2024_01_01_000009_create_absensis_table.php
│   │   └── 2024_01_01_000010_create_rapors_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── GuruSeeder.php
│       ├── JadwalMengajarSeeder.php
│       ├── KelasSeeder.php
│       ├── MataPelajaranSeeder.php
│       ├── NilaiRaporSeeder.php
│       ├── SemesterSeeder.php
│       ├── SiswaSeeder.php
│       ├── TahunPelajaranSeeder.php
│       └── UserSeeder.php
├── resources/views/
│   ├── admin/
│   │   ├── absensi/ (create, edit, index)
│   │   ├── guru/ (create, edit, index, show)
│   │   ├── jadwal-mengajar/ (create, edit, index)
│   │   ├── kelas/ (create, edit, index)
│   │   ├── kenaikan-kelas/ (index)
│   │   ├── mata-pelajaran/ (create, edit, index, show)
│   │   ├── nilai-rapor/ (create, edit, index)
│   │   ├── rapor/ (create, edit, index, show)
│   │   ├── semester/ (create, edit, index)
│   │   ├── siswa/ (create, edit, index, show)
│   │   ├── tahun-pelajaran/ (create, edit, index)
│   │   └── dashboard.blade.php
│   ├── guru/
│   │   ├── nilai/ (index, rekap)
│   │   ├── wali/ (absensi, index, rapor)
│   │   ├── dashboard.blade.php
│   │   └── jadwal.blade.php
│   ├── siswa/
│   │   ├── dashboard.blade.php
│   │   ├── nilai.blade.php
│   │   └── rapor.blade.php
│   ├── layouts/
│   │   └── app.blade.php
│   ├── partials/
│   │   ├── alert.blade.php
│   │   ├── navbar.blade.php
│   │   └── sidebar.blade.php
│   ├── components/
│   │   └── nav-link.blade.php
│   ├── rapor/
│   │   └── cetak.blade.php
│   └── auth/
│       └── login.blade.php
└── routes/
    └── web.php
```

---

## Credits

**Smart Academic Dashboard** — Sistem Pengelolaan Nilai Rapor Siswa Berbasis Web
**MIN 21 Pidie** — 2025/2026

Dibangun menggunakan Laravel 12 + TailwindCSS 4 + Blade + MySQL
