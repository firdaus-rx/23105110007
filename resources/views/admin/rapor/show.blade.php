@extends('layouts.app')

@section('title', 'Detail Rapor')
@section('page-title', 'Detail Rapor')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-semibold text-gray-800">Rapor {{ $rapor->siswa->nama_siswa }}</h3>
            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $rapor->status_rapor == 'final' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ ucfirst($rapor->status_rapor) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div><p class="text-xs text-gray-500 uppercase">Nama Siswa</p><p class="text-sm font-medium mt-1">{{ $rapor->siswa->nama_siswa }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">NIS / NISN</p><p class="text-sm font-medium mt-1">{{ $rapor->siswa->nis ?? '-' }} / {{ $rapor->siswa->nisn ?? '-' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Kelas</p><p class="text-sm font-medium mt-1">{{ $rapor->kelas->nama_kelas }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Wali Kelas</p><p class="text-sm font-medium mt-1">{{ $rapor->kelas->waliKelas?->nama_guru ?? '-' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Tahun Pelajaran</p><p class="text-sm font-medium mt-1">{{ $rapor->tahunPelajaran->nama_tahun }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Semester</p><p class="text-sm font-medium mt-1">{{ $rapor->semester->nama_semester }}</p></div>
        </div>

        {{-- Tabel Nilai --}}
        <div class="mt-6 pt-4 border-t border-gray-200">
            <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <i class="ph ph-file-text text-blue-600"></i> Daftar Nilai
            </h4>
            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Mata Pelajaran</th>
                            <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Pengetahuan</th>
                            <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Keterampilan</th>
                            <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Sikap</th>
                            <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Predikat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($nilais as $n)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 sm:px-6 py-3 text-sm text-gray-800">{{ $n->mataPelajaran->nama_mapel }}</td>
                            <td class="px-4 sm:px-6 py-3 text-sm text-center">{{ $n->nilai_pengetahuan ?? '-' }}</td>
                            <td class="px-4 sm:px-6 py-3 text-sm text-center">{{ $n->nilai_keterampilan ?? '-' }}</td>
                            <td class="px-4 sm:px-6 py-3 text-sm text-center">{{ $n->nilai_sikap ?? '-' }}</td>
                            <td class="px-4 sm:px-6 py-3 text-sm text-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($n->predikat == 'A') bg-green-100 text-green-700
                                    @elseif($n->predikat == 'B') bg-blue-100 text-blue-700
                                    @elseif($n->predikat == 'C') bg-amber-100 text-amber-700
                                    @else bg-red-100 text-red-700
                                    @endif">{{ $n->predikat ?? '-' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada data nilai.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Absensi --}}
        <div class="mt-6 pt-4 border-t border-gray-200">
            <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <i class="ph ph-clipboard-text text-orange-600"></i> Catatan Absensi
            </h4>
            @if($absensi)
            <div class="grid grid-cols-3 gap-4">
                <div class="p-4 bg-red-50 rounded-lg text-center">
                    <p class="text-xs text-red-600 font-medium">Sakit</p>
                    <p class="text-2xl font-bold text-red-700 mt-1">{{ $absensi->sakit }} <span class="text-sm font-normal">hari</span></p>
                </div>
                <div class="p-4 bg-yellow-50 rounded-lg text-center">
                    <p class="text-xs text-yellow-600 font-medium">Izin</p>
                    <p class="text-2xl font-bold text-yellow-700 mt-1">{{ $absensi->izin }} <span class="text-sm font-normal">hari</span></p>
                </div>
                <div class="p-4 bg-orange-50 rounded-lg text-center">
                    <p class="text-xs text-orange-600 font-medium">Alfa</p>
                    <p class="text-2xl font-bold text-orange-700 mt-1">{{ $absensi->alfa }} <span class="text-sm font-normal">hari</span></p>
                </div>
            </div>
            @else
            <p class="text-sm text-gray-400 italic">Belum ada data absensi.</p>
            @endif
        </div>

        {{-- Summary --}}
        <div class="mt-6 pt-4 border-t border-gray-200">
            <div class="grid grid-cols-3 gap-4">
                <div class="p-4 bg-blue-50 rounded-lg text-center">
                    <p class="text-xs text-blue-600 uppercase font-medium">Total Nilai</p>
                    <p class="text-2xl font-bold text-blue-700 mt-1">{{ $rapor->total_nilai }}</p>
                </div>
                <div class="p-4 bg-green-50 rounded-lg text-center">
                    <p class="text-xs text-green-600 uppercase font-medium">Rata-rata</p>
                    <p class="text-2xl font-bold text-green-700 mt-1">{{ number_format($rapor->rata_rata, 2) }}</p>
                </div>
                <div class="p-4 bg-purple-50 rounded-lg text-center">
                    <p class="text-xs text-purple-600 uppercase font-medium">Peringkat</p>
                    <p class="text-2xl font-bold text-purple-700 mt-1">{{ $rapor->peringkat ?? '-' }}</p>
                </div>
            </div>
        </div>

        @if($rapor->catatan_wali_kelas)
        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <p class="text-xs text-gray-500 uppercase font-medium mb-2">Catatan Wali Kelas</p>
            <p class="text-sm text-gray-700">{{ $rapor->catatan_wali_kelas }}</p>
        </div>
        @endif

        @if($rapor->tanggal_rapor)
        <div class="mt-4 text-sm text-gray-500">
            Tanggal rapor: {{ date('d/m/Y', strtotime($rapor->tanggal_rapor)) }}
        </div>
        @endif

        <div class="flex items-center gap-3 mt-6 pt-4 border-t">
            <a href="{{ route('rapor.edit', $rapor) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition">
                <i class="ph ph-pencil"></i> Edit
            </a>
            <a href="{{ route('rapor.cetak', $rapor) }}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                <i class="ph ph-printer"></i> Cetak
            </a>
            <a href="{{ route('rapor.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                <i class="ph ph-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection