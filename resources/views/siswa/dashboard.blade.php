@extends('layouts.app')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')

@section('content')
@if(session('error'))
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">{{ session('error') }}</div>
@endif

{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-500">Nama</p>
                <p class="text-base sm:text-lg font-semibold text-gray-800 mt-1 truncate">{{ $siswa->nama_siswa ?? '-' }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="ph ph-user text-xl sm:text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-500">Kelas</p>
                <p class="text-base sm:text-lg font-semibold text-gray-800 mt-1">{{ $siswa->kelas->nama_kelas ?? '-' }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="ph ph-buildings text-xl sm:text-2xl text-green-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-500">Rata-rata Nilai</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1 {{ $rataRata >= 75 ? 'text-green-600' : 'text-red-600' }}">{{ number_format($rataRata, 2) }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                <i class="ph ph-chart-bar text-xl sm:text-2xl text-amber-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-500">Absensi (S/I/A)</p>
                <p class="text-base sm:text-lg font-semibold text-gray-800 mt-1">{{ $absensi->sakit ?? 0 }} / {{ $absensi->izin ?? 0 }} / {{ $absensi->alfa ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="ph ph-clipboard-text text-xl sm:text-2xl text-red-600"></i>
            </div>
        </div>
    </div>
</div>

{{-- Additional Stats + Chart --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Mini Stats --}}
    <div class="grid grid-cols-2 gap-4 content-start">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-xs text-gray-500">Mata Pelajaran</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalMapel }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-xs text-gray-500">Predikat A</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $predikatA }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-xs text-gray-500">Total Absensi</p>
            <p class="text-2xl font-bold text-orange-600 mt-1">{{ $totalAbsensi }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-xs text-gray-500">NIS</p>
            <p class="text-sm font-bold text-gray-700 mt-1 truncate">{{ $siswa->nis ?? '-' }}</p>
        </div>
    </div>

    {{-- Chart --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="ph ph-chart-bar text-blue-600"></i> Nilai {{ $tahunAktif->nama_tahun ?? '' }} {{ $semesterAktif->nama_semester ?? '' }}
        </h3>
        <canvas id="chartNilaiSiswa" height="200"></canvas>
        @if($nilais->isEmpty())
        <p class="text-center text-gray-400 py-8">Belum ada data nilai.</p>
        @endif
    </div>
</div>

{{-- Table Nilai --}}
@if($nilais->count() > 0)
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-200 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">Daftar Nilai</h3>
        <a href="{{ route('siswa.nilai') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
            Lihat Semua <i class="ph ph-caret-right"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
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
                @foreach($nilais as $n)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-800">{{ $n->mataPelajaran->nama_mapel }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center text-gray-600">{{ $n->nilai_pengetahuan ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center text-gray-600">{{ $n->nilai_keterampilan ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center text-gray-600">{{ $n->nilai_sikap ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($n->predikat == 'A') bg-green-100 text-green-700
                            @elseif($n->predikat == 'B') bg-blue-100 text-blue-700
                            @elseif($n->predikat == 'C') bg-amber-100 text-amber-700
                            @else bg-red-100 text-red-700
                            @endif">{{ $n->predikat ?? '-' }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <i class="ph ph-chart-bar text-4xl text-gray-300 block mb-3"></i>
    <p class="text-gray-400">Belum ada data nilai untuk semester aktif.</p>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const labels = @json($chartLabels);
    const pengetahuan = @json($chartNilaiPengetahuan);
    const keterampilan = @json($chartNilaiKeterampilan);
    if (labels.length === 0) return;

    const ctx = document.getElementById('chartNilaiSiswa').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pengetahuan',
                    data: pengetahuan,
                    backgroundColor: 'rgba(59, 130, 246, 0.6)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                },
                {
                    label: 'Keterampilan',
                    data: keterampilan,
                    backgroundColor: 'rgba(16, 185, 129, 0.6)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top', labels: { boxWidth: 12, padding: 12 } }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: { stepSize: 20 }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10 } }
                }
            }
        }
    });
});
</script>
@endpush