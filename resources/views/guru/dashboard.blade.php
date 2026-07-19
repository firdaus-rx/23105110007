@extends('layouts.app')

@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard Guru')

@section('content')
{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-500">Kelas Diajar</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $totalKelas }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="ph ph-buildings text-xl sm:text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-500">Total Siswa</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $totalSiswa }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="ph ph-users text-xl sm:text-2xl text-green-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-500">Mata Pelajaran</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $totalMapel }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="ph ph-book text-xl sm:text-2xl text-purple-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-500">Total Jadwal</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $totalJadwal }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="ph ph-clock text-xl sm:text-2xl text-orange-600"></i>
            </div>
        </div>
    </div>
</div>

{{-- Chart + Aksi Cepat --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="ph ph-chart-bar text-blue-600"></i> Rata-rata Nilai per Kelas
        </h3>
        <canvas id="chartNilai" height="200"></canvas>
        @if(empty($chartLabels))
        <p class="text-center text-gray-400 py-8">Belum ada data nilai.</p>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="ph ph-lightning text-yellow-600"></i> Aksi Cepat
        </h3>
        <div class="space-y-3">
            <a href="{{ route('guru.jadwal') }}" class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition group">
                <div class="w-10 h-10 rounded-lg bg-blue-200 flex items-center justify-center group-hover:bg-blue-300 transition">
                    <i class="ph ph-clock text-lg text-blue-700"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-blue-800">Jadwal Mengajar</p>
                    <p class="text-xs text-blue-600">Lihat jadwal lengkap</p>
                </div>
                <i class="ph ph-caret-right text-blue-400"></i>
            </a>
            <a href="{{ route('guru.nilai.rekap') }}" class="flex items-center gap-3 p-3 bg-green-50 hover:bg-green-100 rounded-lg transition group">
                <div class="w-10 h-10 rounded-lg bg-green-200 flex items-center justify-center group-hover:bg-green-300 transition">
                    <i class="ph ph-file-text text-lg text-green-700"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-green-800">Rekap Nilai</p>
                    <p class="text-xs text-green-600">Lihat ringkasan nilai</p>
                </div>
                <i class="ph ph-caret-right text-green-400"></i>
            </a>
            <a href="{{ route('guru.wali.index') }}" class="flex items-center gap-3 p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition group">
                <div class="w-10 h-10 rounded-lg bg-purple-200 flex items-center justify-center group-hover:bg-purple-300 transition">
                    <i class="ph ph-users text-lg text-purple-700"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-purple-800">Wali Kelas</p>
                    <p class="text-xs text-purple-600">Absensi & Rapor</p>
                </div>
                <i class="ph ph-caret-right text-purple-400"></i>
            </a>
        </div>
    </div>
</div>

{{-- Kelas Cards --}}
@if($jadwalsGroup->count() > 0)
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <i class="ph ph-buildings text-blue-600"></i> Kelas Saya
    </h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($jadwalsGroup as $kelas => $items)
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-semibold text-gray-800">Kelas {{ $kelas }}</h4>
                <span class="text-xs text-gray-500">{{ $items->count() }} mapel</span>
            </div>
            <div class="space-y-1.5 mb-3">
                @foreach($items as $j)
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">{{ $j->mataPelajaran->nama_mapel }}</span>
                    <a href="{{ route('guru.nilai.index', $j) }}" class="text-blue-600 hover:text-blue-800" title="Input Nilai">
                        <i class="ph ph-pencil-simple"></i>
                    </a>
                </div>
                @endforeach
            </div>
            <a href="{{ route('guru.nilai.rekap') }}" class="block w-full text-center text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 py-2 rounded-lg transition">
                Lihat Rekap Nilai
            </a>
        </div>
        @endforeach
    </div>
</div>
@else
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <i class="ph ph-clock text-4xl text-gray-300 block mb-3"></i>
    <p class="text-gray-400">Belum ada jadwal mengajar untuk semester aktif.</p>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const labels = @json($chartLabels);
    const data = @json($chartData);
    if (labels.length === 0) return;

    const ctx = document.getElementById('chartNilai').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rata-rata Nilai',
                data: data,
                backgroundColor: 'rgba(59, 130, 246, 0.6)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: { stepSize: 20 }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endpush