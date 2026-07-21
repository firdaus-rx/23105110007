BAB III
ANALISIS DAN PERANCANGAN SISTEM

3.1 Analisis Sistem

Sistem pengelolaan nilai rapor siswa pada MIN 21 Pidie saat ini masih dilakukan secara manual menggunakan Microsoft Excel dan buku agenda nilai. Guru mata pelajaran mencatat nilai siswa secara mandiri di file Excel atau buku nilai. Setiap akhir semester, guru menyerahkan rekap nilai kepada wali kelas dalam bentuk cetak atau file Excel. Wali kelas kemudian merekap seluruh nilai dari setiap guru ke dalam satu file Excel untuk dihitung rata-rata dan peringkat, lalu mengetik ulang nilai ke dalam format rapor secara manual. Kepala sekolah menandatangani rapor yang telah selesai dibuat.

Proses manual ini memiliki beberapa kelemahan. Data nilai rentan hilang karena tersimpan terpisah di masing-masing guru. Perhitungan nilai akhir, predikat, rata-rata rapor, dan peringkat dilakukan secara manual sehingga rawan kesalahan dan memakan waktu lama. Orang tua siswa tidak dapat memantau perkembangan nilai anak secara berkala karena tidak ada akses langsung ke data nilai. Pembuatan rapor sering molor dari jadwal karena proses rekap yang panjang dan berulang.

Berdasarkan permasalahan tersebut, diusulkan pembangunan sistem Smart Academic Dashboard berbasis web menggunakan framework Laravel 12 dengan arsitektur MVC dan database MySQL. Sistem ini menerapkan role-based access control dengan tiga level pengguna yaitu admin, guru, dan siswa/orang tua. Admin memiliki akses penuh terhadap seluruh fitur CRUD meliputi data guru, kelas, siswa, mata pelajaran, tahun pelajaran, semester, jadwal mengajar, nilai rapor, absensi, rapor, dan kenaikan kelas. Guru dapat menginput nilai sesuai jadwal mengajar yang ditugaskan, sedangkan wali kelas memiliki hak tambahan untuk mengelola absensi, mengisi catatan wali kelas, memfinalisasi rapor, dan menaikkan kelas siswa. Siswa dan orang tua dapat melihat nilai, grafik perkembangan nilai per semester, dan mencetak rapor yang telah difinalisasi.

Perhitungan nilai akhir, predikat, rata-rata rapor, dan peringkat dilakukan secara otomatis oleh sistem melalui NilaiService. Nilai akhir dihitung dari rata-rata nilai pengetahuan dan nilai keterampilan. Predikat ditentukan berdasarkan rentang nilai yaitu A untuk nilai 90-100, B untuk 80-89, C untuk 70-79, dan D untuk nilai di bawah 70. Rata-rata rapor dihitung dari seluruh nilai mata pelajaran siswa pada semester yang sama, dan peringkat ditentukan berdasarkan rata-rata nilai siswa dalam satu kelas.

Kebutuhan non-fungsional sistem meliputi keamanan dengan enkripsi password bcrypt dan pembatasan akses berdasarkan role, kegunaan dengan antarmuka responsif menggunakan TailwindCSS dan bahasa Indonesia pada seluruh label dan pesan, serta performa dengan indexing database pada kolom yang sering dicari.

3.2 Perancangan Sistem

Perancangan sistem menggunakan pemodelan UML dengan beberapa diagram. Use case diagram menggambarkan interaksi antara tiga aktor dengan sistem. Admin dapat mengelola data guru, kelas, siswa, mata pelajaran, tahun pelajaran, semester, jadwal mengajar, nilai rapor, absensi, rapor, dan kenaikan kelas. Guru dapat melihat jadwal mengajar, mengelola nilai sesuai jadwal, dan melihat rekap nilai. Wali kelas dapat mengelola absensi dan rapor serta memfinalisasi rapor. Siswa dan orang tua dapat melihat nilai dan rapor serta mencetak rapor yang telah difinalisasi.

Sequence diagram menggambarkan alur interaksi antar objek pada proses login dan input nilai. Pada proses login, pengguna mengirim data email dan password, AuthController memvalidasi kredensial ke database, session dibuat, dan sistem mengarahkan ke dashboard sesuai role. Pada proses input nilai, guru memilih jadwal mengajar, sistem menampilkan daftar siswa, guru mengirim data nilai, NilaiController memanggil NilaiService untuk menghitung nilai akhir dan predikat secara otomatis, kemudian data disimpan ke tabel nilai_rapor.

Class diagram menggambarkan relasi antar model dalam sistem. User memiliki relasi one-to-one dengan Guru dan Siswa. Guru memiliki relasi one-to-many dengan JadwalMengajar, NilaiRapor, dan Kelas sebagai wali kelas. Kelas memiliki relasi one-to-many dengan Siswa, JadwalMengajar, NilaiRapor, dan Rapor. Siswa memiliki relasi one-to-many dengan NilaiRapor, Absensi, dan Rapor. MataPelajaran memiliki relasi one-to-many dengan JadwalMengajar dan NilaiRapor. TahunPelajaran dan Semester masing-masing memiliki relasi one-to-many dengan JadwalMengajar, NilaiRapor, Absensi, dan Rapor. JadwalMengajar, NilaiRapor, Absensi, dan Rapor memiliki relasi belongs-to dengan model terkait.

3.4 Rancangan Database

Perancangan database sistem ini terdiri dari 11 tabel utama dan 3 tabel sistem. Berikut adalah struktur masing-masing tabel berdasarkan implementasi migration.

3.4.1 Tabel Users

| No | Nama Field | Type | Size | Keterangan |
|----|------------|------|------|------------|
| 1 | id | BIGINT | 20 | Primary Key, Auto Increment |
| 2 | name | VARCHAR | 255 | Nama pengguna |
| 3 | email | VARCHAR | 255 | Unique, email login |
| 4 | email_verified_at | TIMESTAMP | - | Nullable |
| 5 | password | VARCHAR | 255 | Hash bcrypt |
| 6 | role | ENUM | - | 'admin','guru','siswa','orang_tua', default 'siswa' |
| 7 | remember_token | VARCHAR | 100 | Nullable |
| 8 | created_at | TIMESTAMP | - | Nullable |
| 9 | updated_at | TIMESTAMP | - | Nullable |

3.4.2 Tabel Guru

| No | Nama Field | Type | Size | Keterangan |
|----|------------|------|------|------------|
| 1 | id | BIGINT | 20 | Primary Key, Auto Increment |
| 2 | user_id | BIGINT | 20 | Foreign Key users, Nullable, nullOnDelete |
| 3 | nip | VARCHAR | 255 | Unique, Nullable |
| 4 | nama_guru | VARCHAR | 255 | Nama guru |
| 5 | jenis_kelamin | ENUM | - | 'L','P' |
| 6 | telepon | VARCHAR | 255 | Nullable |
| 7 | alamat | TEXT | - | Nullable |
| 8 | created_at | TIMESTAMP | - | Nullable |
| 9 | updated_at | TIMESTAMP | - | Nullable |

3.4.3 Tabel Kelas

| No | Nama Field | Type | Size | Keterangan |
|----|------------|------|------|------------|
| 1 | id | BIGINT | 20 | Primary Key, Auto Increment |
| 2 | nama_kelas | VARCHAR | 255 | Nama kelas |
| 3 | tingkat | TINYINT | 4 | Tingkat 1-6 |
| 4 | wali_kelas_id | BIGINT | 20 | Foreign Key gurus, Nullable, nullOnDelete |
| 5 | created_at | TIMESTAMP | - | Nullable |
| 6 | updated_at | TIMESTAMP | - | Nullable |

3.4.4 Tabel Siswa

| No | Nama Field | Type | Size | Keterangan |
|----|------------|------|------|------------|
| 1 | id | BIGINT | 20 | Primary Key, Auto Increment |
| 2 | user_id | BIGINT | 20 | Foreign Key users, Nullable, nullOnDelete |
| 3 | kelas_id | BIGINT | 20 | Foreign Key kelas, Nullable, nullOnDelete |
| 4 | nis | VARCHAR | 255 | Unique, Nullable |
| 5 | nisn | VARCHAR | 255 | Unique, Nullable |
| 6 | nama_siswa | VARCHAR | 255 | Nama siswa |
| 7 | tempat_lahir | VARCHAR | 255 | Nullable |
| 8 | tanggal_lahir | DATE | - | Nullable |
| 9 | jenis_kelamin | ENUM | - | 'L','P' |
| 10 | agama | VARCHAR | 255 | Nullable |
| 11 | alamat | TEXT | - | Nullable |
| 12 | nama_ayah | VARCHAR | 255 | Nullable |
| 13 | nama_ibu | VARCHAR | 255 | Nullable |
| 14 | telepon_orang_tua | VARCHAR | 255 | Nullable |
| 15 | created_at | TIMESTAMP | - | Nullable |
| 16 | updated_at | TIMESTAMP | - | Nullable |

3.4.5 Tabel Mata Pelajaran

| No | Nama Field | Type | Size | Keterangan |
|----|------------|------|------|------------|
| 1 | id | BIGINT | 20 | Primary Key, Auto Increment |
| 2 | kode_mapel | VARCHAR | 255 | Unique, Nullable |
| 3 | nama_mapel | VARCHAR | 255 | Nama mata pelajaran |
| 4 | kkm | INT | 11 | Default 75 |
| 5 | kelompok | VARCHAR | 255 | Nullable |
| 6 | status | ENUM | - | 'aktif','nonaktif', default 'aktif' |
| 7 | created_at | TIMESTAMP | - | Nullable |
| 8 | updated_at | TIMESTAMP | - | Nullable |

3.4.6 Tabel Tahun Pelajaran

| No | Nama Field | Type | Size | Keterangan |
|----|------------|------|------|------------|
| 1 | id | BIGINT | 20 | Primary Key, Auto Increment |
| 2 | nama_tahun | VARCHAR | 255 | Unique |
| 3 | status_aktif | BOOLEAN | - | Default false |
| 4 | created_at | TIMESTAMP | - | Nullable |
| 5 | updated_at | TIMESTAMP | - | Nullable |

3.4.7 Tabel Semester

| No | Nama Field | Type | Size | Keterangan |
|----|------------|------|------|------------|
| 1 | id | BIGINT | 20 | Primary Key, Auto Increment |
| 2 | nama_semester | ENUM | - | 'Ganjil','Genap' |
| 3 | status_aktif | BOOLEAN | - | Default false |
| 4 | created_at | TIMESTAMP | - | Nullable |
| 5 | updated_at | TIMESTAMP | - | Nullable |

3.4.8 Tabel Jadwal Mengajar

| No | Nama Field | Type | Size | Keterangan |
|----|------------|------|------|------------|
| 1 | id | BIGINT | 20 | Primary Key, Auto Increment |
| 2 | guru_id | BIGINT | 20 | Foreign Key gurus, Cascade |
| 3 | kelas_id | BIGINT | 20 | Foreign Key kelas, Cascade |
| 4 | mata_pelajaran_id | BIGINT | 20 | Foreign Key mata_pelajarans, Cascade |
| 5 | tahun_pelajaran_id | BIGINT | 20 | Foreign Key tahun_pelajarans, Cascade |
| 6 | semester_id | BIGINT | 20 | Foreign Key semesters, Cascade |
| 7 | created_at | TIMESTAMP | - | Nullable |
| 8 | updated_at | TIMESTAMP | - | Nullable |

Unique Constraint: (guru_id, kelas_id, mata_pelajaran_id, tahun_pelajaran_id, semester_id)

3.4.9 Tabel Nilai Rapor

| No | Nama Field | Type | Size | Keterangan |
|----|------------|------|------|------------|
| 1 | id | BIGINT | 20 | Primary Key, Auto Increment |
| 2 | siswa_id | BIGINT | 20 | Foreign Key siswas, Cascade |
| 3 | guru_id | BIGINT | 20 | Foreign Key gurus, Cascade |
| 4 | kelas_id | BIGINT | 20 | Foreign Key kelas, Cascade |
| 5 | mata_pelajaran_id | BIGINT | 20 | Foreign Key mata_pelajarans, Cascade |
| 6 | tahun_pelajaran_id | BIGINT | 20 | Foreign Key tahun_pelajarans, Cascade |
| 7 | semester_id | BIGINT | 20 | Foreign Key semesters, Cascade |
| 8 | nilai_pengetahuan | INT | 11 | Nullable, 0-100 |
| 9 | nilai_keterampilan | INT | 11 | Nullable, 0-100 |
| 10 | nilai_sikap | VARCHAR | 255 | Nullable |
| 11 | predikat | VARCHAR | 255 | Nullable |
| 12 | deskripsi | TEXT | - | Nullable |
| 13 | created_at | TIMESTAMP | - | Nullable |
| 14 | updated_at | TIMESTAMP | - | Nullable |

Unique Constraint: (siswa_id, mata_pelajaran_id, tahun_pelajaran_id, semester_id)

3.4.10 Tabel Absensi

| No | Nama Field | Type | Size | Keterangan |
|----|------------|------|------|------------|
| 1 | id | BIGINT | 20 | Primary Key, Auto Increment |
| 2 | siswa_id | BIGINT | 20 | Foreign Key siswas, Cascade |
| 3 | kelas_id | BIGINT | 20 | Foreign Key kelas, Cascade |
| 4 | tahun_pelajaran_id | BIGINT | 20 | Foreign Key tahun_pelajarans, Cascade |
| 5 | semester_id | BIGINT | 20 | Foreign Key semesters, Cascade |
| 6 | sakit | INT | 11 | Default 0 |
| 7 | izin | INT | 11 | Default 0 |
| 8 | alfa | INT | 11 | Default 0 |
| 9 | created_at | TIMESTAMP | - | Nullable |
| 10 | updated_at | TIMESTAMP | - | Nullable |

Unique Constraint: (siswa_id, tahun_pelajaran_id, semester_id)

3.4.11 Tabel Rapor

| No | Nama Field | Type | Size | Keterangan |
|----|------------|------|------|------------|
| 1 | id | BIGINT | 20 | Primary Key, Auto Increment |
| 2 | siswa_id | BIGINT | 20 | Foreign Key siswas, Cascade |
| 3 | kelas_id | BIGINT | 20 | Foreign Key kelas, Cascade |
| 4 | tahun_pelajaran_id | BIGINT | 20 | Foreign Key tahun_pelajarans, Cascade |
| 5 | semester_id | BIGINT | 20 | Foreign Key semesters, Cascade |
| 6 | total_nilai | INT | 11 | Default 0 |
| 7 | rata_rata | DECIMAL | 5,2 | Default 0 |
| 8 | peringkat | INT | 11 | Nullable |
| 9 | catatan_wali_kelas | TEXT | - | Nullable |
| 10 | status_rapor | ENUM | - | 'draft','final', default 'draft' |
| 11 | tanggal_rapor | DATE | - | Nullable |
| 12 | created_at | TIMESTAMP | - | Nullable |
| 13 | updated_at | TIMESTAMP | - | Nullable |

Unique Constraint: (siswa_id, kelas_id, tahun_pelajaran_id, semester_id)
