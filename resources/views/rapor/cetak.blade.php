<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor - {{ $rapor->siswa->nama_siswa }}</title>
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 30px 40px;
            color: #000000;
            background: #ffffff;
            line-height: 1.6;
            font-size: 12pt;
        }

        /* KOP SURAT SEDERHANA */
        .kop-surat {
            text-align: center;
            border-bottom: 2px solid #000000;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .kop-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .logo-sekolah {
            flex-shrink: 0;
        }

        .logo-sekolah img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .kop-text {
            flex: 1;
            text-align: center;
        }

        .kop-text .nama-sekolah {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }

        .kop-text .alamat-sekolah {
            font-size: 11pt;
            margin: 2px 0;
        }

        .kop-text .detail-sekolah {
            font-size: 10pt;
        }

        /* JUDUL */
        .judul-dokumen {
            text-align: center;
            margin: 15px 0 10px 0;
        }

        .judul-dokumen h1 {
            font-size: 14pt;
            text-transform: uppercase;
            font-weight: bold;
            margin: 0;
            text-decoration: underline;
        }

        .judul-dokumen .sub-judul {
            font-size: 11pt;
            margin-top: 3px;
        }

        /* INFO SISWA */
        .info-siswa {
            margin: 15px 0 20px 0;
            padding: 8px 0;
        }

        .info-siswa table {
            width: 100%;
            font-size: 11pt;
            border-collapse: collapse;
        }

        .info-siswa td {
            padding: 2px 5px;
            vertical-align: top;
        }

        .info-siswa td:first-child {
            width: 140px;
            font-weight: bold;
        }

        /* TABEL NILAI */
        .table-nilai {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 11pt;
        }

        .table-nilai th {
            background: #e8e8e8;
            color: #000000;
            padding: 6px 10px;
            border: 1px solid #000000;
            font-weight: bold;
            text-align: center;
        }

        .table-nilai td {
            padding: 5px 10px;
            border: 1px solid #000000;
            text-align: center;
        }

        .table-nilai td:nth-child(2) {
            text-align: left;
        }

        .table-nilai tr:nth-child(even) {
            background: #f5f5f5;
        }

        /* INFO TAMBAHAN */
        .info-tambahan {
            display: flex;
            gap: 40px;
            padding: 8px 0;
            margin: 10px 0;
            font-size: 11pt;
            border-top: 1px solid #cccccc;
            border-bottom: 1px solid #cccccc;
        }

        .info-tambahan div {
            flex: 1;
        }

        /* TABEL ABSENSI */
        .table-absensi {
            width: 40%;
            border-collapse: collapse;
            margin: 12px 0;
            font-size: 11pt;
        }

        .table-absensi th {
            background: #e8e8e8;
            color: #000000;
            padding: 5px 10px;
            border: 1px solid #000000;
            text-align: center;
            font-weight: bold;
        }

        .table-absensi td {
            padding: 4px 10px;
            border: 1px solid #000000;
            text-align: center;
        }

        .table-absensi td:first-child {
            font-weight: bold;
            text-align: left;
        }

        /* CATATAN */
        .catatan-wali {
            margin: 15px 0;
            padding: 10px 15px;
            border: 1px solid #cccccc;
        }

        .catatan-wali p:first-child {
            font-weight: bold;
            margin-bottom: 3px;
        }

        /* FOOTER TANDA TANGAN */
        .footer-ttd {
            margin-top: 35px;
            padding-top: 15px;
            page-break-inside: avoid;
        }

        .footer-ttd table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-ttd td {
            width: 50%;
            text-align: center;
            padding: 10px 15px;
            vertical-align: bottom;
        }

        .ttd-wrapper {
            display: inline-block;
            width: 100%;
            max-width: 280px;
            page-break-inside: avoid;
        }

        .ttd-label {
            font-weight: bold;
            margin-bottom: 30px;
            display: block;
        }

        .ttd-line {
            border-top: 1px solid #000000;
            width: 200px;
            margin: 5px auto;
            display: block;
        }

        .ttd-nama {
            font-weight: bold;
            margin-top: 5px;
            display: block;
        }

        .ttd-nip {
            font-size: 10pt;
            margin-top: 2px;
            display: block;
        }

        .ttd-space {
            display: block;
            height: 30px;
        }

        /* TOMBOL */
        .no-print {
            margin-bottom: 20px;
            text-align: right;
        }

        .btn-print {
            padding: 8px 20px;
            background: #4a4a4a;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 11pt;
            font-family: 'Times New Roman', Times, serif;
        }

        .btn-print:hover {
            background: #2a2a2a;
        }

        .btn-back {
            padding: 8px 20px;
            background: #888888;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 11pt;
            margin-left: 8px;
            display: inline-block;
            font-family: 'Times New Roman', Times, serif;
        }

        .btn-back:hover {
            background: #666666;
        }

        /* CETAK */
        @media print {
            body {
                padding: 20px 30px;
            }

            .no-print {
                display: none !important;
            }

            .table-nilai th {
                background: #e8e8e8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .table-absensi th {
                background: #e8e8e8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .table-nilai tr:nth-child(even) {
                background: #f5f5f5 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .kop-surat {
                border-bottom: 2px solid #000000 !important;
            }

            .ttd-line {
                border-top: 1px solid #000000 !important;
            }

            .footer-ttd {
                page-break-inside: avoid;
            }

            .ttd-wrapper {
                page-break-inside: avoid;
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
                font-size: 10pt;
            }

            .kop-content {
                flex-direction: column;
                gap: 8px;
            }

            .logo-sekolah img {
                width: 50px;
                height: 50px;
            }

            .kop-text .nama-sekolah {
                font-size: 14pt;
            }

            .info-siswa td:first-child {
                width: 100px;
            }

            .table-absensi {
                width: 100%;
            }

            .info-tambahan {
                flex-direction: column;
                gap: 5px;
            }

            .footer-ttd td {
                display: block;
                width: 100%;
                padding: 15px 10px;
            }

            .ttd-line {
                width: 160px;
            }

            .ttd-wrapper {
                max-width: 100%;
            }
        }

        @media print {
            @page {
                size: 210mm 330mm;
                /* Lebar dan Tinggi Kertas F4 */
                margin: 15mm;
                /* Sesuaikan margin sesuai kebutuhan */
            }

            /* Mencegah terpotongnya konten di browser berbasis Chrome */
            html,
            body {
                width: 210mm;
                height: 330mm;
            }
        }
    </style>
</head>

<body>
    <!-- TOMBOL (TIDAK TERCETAK) -->
    <div class="no-print">
        <button onclick="window.print()" class="btn-print">
            <i class="ph ph-printer"></i> Cetak
        </button>
        <a href="{{ url()->previous() }}" class="btn-back">
            <i class="ph ph-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <div class="kop-content">
            <div class="logo-sekolah">
                <img src="{{ asset('logo-man.png') }}" alt="Logo Sekolah">
            </div>
            <div class="kop-text">
                <div class="nama-sekolah">{{ config('school.name') }}</div>
                <div class="alamat-sekolah">{{ config('school.address') }}</div>
                <div class="detail-sekolah">
                    NPSN: {{ config('school.npsn') ?? '-' }} |
                    NSS: {{ config('school.nss') ?? '-' }} |
                    Telp: {{ config('school.phone') ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <!-- JUDUL -->
    <div class="judul-dokumen">
        <h1>LAPORAN HASIL BELAJAR</h1>
    </div>

    <!-- INFO SISWA -->
    <div class="info-siswa">
        <table>
            <tr>
                <td>Nama Siswa</td>
                <td>: {{ $rapor->siswa->nama_siswa }}</td>
            </tr>
            <tr>
                <td>NIS / NISN</td>
                <td>: {{ $rapor->siswa->nis ?? '-' }} / {{ $rapor->siswa->nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>: {{ $rapor->kelas->nama_kelas }}</td>
            </tr>
            <tr>
                <td>Semester</td>
                <td>: {{ $rapor->semester->nama_semester }}</td>
            </tr>
            <tr>
                <td>Tahun Pelajaran</td>
                <td>: {{ $rapor->tahunPelajaran->nama_tahun }}</td>
            </tr>
        </table>
    </div>

    <!-- TABEL NILAI -->
    <table class="table-nilai">
        <thead>
            <tr>
                <th style="width:35px">No</th>
                <th style="width:40%">Mata Pelajaran</th>
                <th style="width:55px">KKM</th>
                <th style="width:75px">Pengetahuan</th>
                <th style="width:75px">Keterampilan</th>
                <th style="width:65px">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nilais as $index => $nilai)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $nilai->mataPelajaran->nama_mapel }}</td>
                    <td>{{ $nilai->mataPelajaran->kkm }}</td>
                    <td>{{ $nilai->nilai_pengetahuan ?? '-' }}</td>
                    <td>{{ $nilai->nilai_keterampilan ?? '-' }}</td>
                    <td>{{ $nilai->predikat ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:15px;">Belum ada nilai</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- INFO TAMBAHAN -->
    <div class="info-tambahan">
        <div>
            <strong>Rata-rata Nilai:</strong>
            {{ number_format($rapor->rata_rata, 2) }}
        </div>
        <div>
            <strong>Peringkat Kelas:</strong>
            {{ $rapor->peringkat ?? '-' }}
        </div>
        <div>
            <strong>Status:</strong>
            @if ($rapor->rata_rata >= 75)
                Tuntas
            @else
                Belum Tuntas
            @endif
        </div>
    </div>

    <!-- ABSENSI -->
    @if ($absensi)
        <div>
            <table class="table-absensi">
                <thead>
                    <tr>
                        <th colspan="4">Rekapitulasi Absensi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sakit</td>
                        <td>{{ $absensi->sakit }} hari</td>
                        <td>Izin</td>
                        <td>{{ $absensi->izin }} hari</td>
                    </tr>
                    <tr>
                        <td>Alfa</td>
                        <td>{{ $absensi->alfa }} hari</td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    <!-- CATATAN -->
    @if ($rapor->catatan_wali_kelas)
        <div class="catatan-wali">
            <p>Catatan Wali Kelas:</p>
            <p>{{ $rapor->catatan_wali_kelas }}</p>
        </div>
    @endif

    <!-- TANDA TANGAN -->
    <div class="footer-ttd">
        <table>
            <tr>
                <td>
                    <div class="ttd-wrapper">
                        <span class="ttd-label">Wali Kelas</span>
                        <span class="ttd-space"></span>
                        <span class="ttd-line"></span>
                        <span class="ttd-nama">{{ $rapor->kelas->waliKelas?->nama_guru ?? '-' }}</span>
                        <span class="ttd-nip">NIP. {{ $rapor->kelas->waliKelas?->nip ?? '-' }}</span>
                    </div>
                </td>
                <td>
                    <div class="ttd-wrapper">
                        <span class="ttd-label">Kepala Sekolah</span>
                        <span class="ttd-space"></span>
                        <span class="ttd-line"></span>
                        <span class="ttd-nama">{{ config('school.headmaster') }}</span>
                        <span class="ttd-nip">NIP. {{ config('school.headmaster_nip') }}</span>
                    </div>
                </td>
            </tr>
        </table>

        <!-- TANGGAL CETAK -->
        <div
            style="text-align:center;margin-top:25px;padding-top:8px;border-top:1px solid #dddddd;font-size:10pt;color:#666666;">
            Dicetak pada: {{ now()->format('d F Y H:i') }}
        </div>
    </div>
</body>

</html>
