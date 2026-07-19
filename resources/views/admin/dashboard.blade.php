@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-500 font-medium">Total Siswa</p>
                <p class="text-2xl sm:text-3xl font-bold text-blue-600 mt-1">{{ $totalSiswa }}</p>
            </div>
            <div class="w-11 h-11 sm:w-13 sm:h-13 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-sm">
                <i class="ph ph-student text-xl sm:text-2xl text-white"></i>
            </div>
        </div>
        <div class="mt-3 text-xs text-gray-400">Terdaftar di sistem</div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-500 font-medium">Total Guru</p>
                <p class="text-2xl sm:text-3xl font-bold text-emerald-600 mt-1">{{ $totalGuru }}</p>
            </div>
            <div class="w-11 h-11 sm:w-13 sm:h-13 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-sm">
                <i class="ph ph-chalkboard-teacher text-xl sm:text-2xl text-white"></i>
            </div>
        </div>
        <div class="mt-3 text-xs text-gray-400">Tenaga pengajar</div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-500 font-medium">Total Kelas</p>
                <p class="text-2xl sm:text-3xl font-bold text-purple-600 mt-1">{{ $totalKelas }}</p>
            </div>
            <div class="w-11 h-11 sm:w-13 sm:h-13 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-sm">
                <i class="ph ph-buildings text-xl sm:text-2xl text-white"></i>
            </div>
        </div>
        <div class="mt-3 text-xs text-gray-400">Rombel aktif</div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-500 font-medium">Mata Pelajaran</p>
                <p class="text-2xl sm:text-3xl font-bold text-orange-600 mt-1">{{ $totalMapel }}</p>
            </div>
            <div class="w-11 h-11 sm:w-13 sm:h-13 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center shadow-sm">
                <i class="ph ph-book text-xl sm:text-2xl text-white"></i>
            </div>
        </div>
        <div class="mt-3 text-xs text-gray-400">Aktif</div>
    </div>
</div>

{{-- Info Semester --}}
<div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-sm p-4 sm:p-6 mb-8 text-white">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div class="flex items-center gap-3">
            <i class="ph ph-calendar text-2xl"></i>
            <div>
                <p class="text-sm text-blue-200">Semester Aktif</p>
                <p class="text-lg font-semibold">{{ $tahunAktif->nama_tahun ?? '-' }} / {{ $semesterAktif->nama_semester ?? '-' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4 text-sm">
            <div class="text-center">
                <p class="text-blue-200">Nilai Tertinggi</p>
                <p class="text-xl font-bold">{{ number_format($nilaiTertinggi, 2) }}</p>
            </div>
            <div class="w-px h-8 bg-blue-500"></div>
            <div class="text-center">
                <p class="text-blue-200">Nilai Terendah</p>
                <p class="text-xl font-bold">{{ number_format($nilaiTerendah, 2) }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Charts Row --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="ph ph-users text-blue-600"></i> Jumlah Siswa per Kelas
        </h3>
        <canvas id="chartSiswa" height="200"></canvas>
        @if(empty($chartKelasLabels))
        <p class="text-center text-gray-400 py-8">Belum ada data kelas.</p>
        @endif
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="ph ph-chart-bar text-emerald-600"></i> Rata-rata Nilai per Kelas
        </h3>
        <canvas id="chartNilai" height="200"></canvas>
        @if(empty($rataNilaiPerKelas))
        <p class="text-center text-gray-400 py-8">Belum ada data nilai.</p>
        @endif
    </div>
</div>

{{-- Quick Actions + Recent Rapors --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Quick Actions --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="ph ph-lightning text-yellow-600"></i> Aksi Cepat
        </h3>
        <div class="space-y-3">
            <a href="{{ route('guru.index') }}" class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition group">
                <div class="w-10 h-10 rounded-lg bg-blue-200 flex items-center justify-center group-hover:bg-blue-300 transition">
                    <i class="ph ph-chalkboard-teacher text-lg text-blue-700"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-blue-800">Data Guru</p>
                    <p class="text-xs text-blue-600">Kelola data guru</p>
                </div>
                <i class="ph ph-caret-right text-blue-400"></i>
            </a>
            <a href="{{ route('kelas.index') }}" class="flex items-center gap-3 p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition group">
                <div class="w-10 h-10 rounded-lg bg-purple-200 flex items-center justify-center group-hover:bg-purple-300 transition">
                    <i class="ph ph-buildings text-lg text-purple-700"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-purple-800">Data Kelas</p>
                    <p class="text-xs text-purple-600">Kelola kelas & wali kelas</p>
                </div>
                <i class="ph ph-caret-right text-purple-400"></i>
            </a>
            <a href="{{ route('siswa.index') }}" class="flex items-center gap-3 p-3 bg-green-50 hover:bg-green-100 rounded-lg transition group">
                <div class="w-10 h-10 rounded-lg bg-green-200 flex items-center justify-center group-hover:bg-green-300 transition">
                    <i class="ph ph-student text-lg text-green-700"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-green-800">Data Siswa</p>
                    <p class="text-xs text-green-600">Kelola data siswa</p>
                </div>
                <i class="ph ph-caret-right text-green-400"></i>
            </a>
            <a href="{{ route('jadwal-mengajar.index') }}" class="flex items-center gap-3 p-3 bg-cyan-50 hover:bg-cyan-100 rounded-lg transition group">
                <div class="w-10 h-10 rounded-lg bg-cyan-200 flex items-center justify-center group-hover:bg-cyan-300 transition">
                    <i class="ph ph-clock text-lg text-cyan-700"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-cyan-800">Jadwal Mengajar</p>
                    <p class="text-xs text-cyan-600">Atur jadwal guru</p>
                </div>
                <i class="ph ph-caret-right text-cyan-400"></i>
            </a>
            <a href="{{ route('rapor.index') }}" class="flex items-center gap-3 p-3 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition group">
                <div class="w-10 h-10 rounded-lg bg-indigo-200 flex items-center justify-center group-hover:bg-indigo-300 transition">
                    <i class="ph ph-certificate text-lg text-indigo-700"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-indigo-800">Rapor</p>
                    <p class="text-xs text-indigo-600">Cetak & finalisasi rapor</p>
                </div>
                <i class="ph ph-caret-right text-indigo-400"></i>
            </a>
        </div>
    </div>

    {{-- Siswa per Kelas (detail) --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="ph ph-barricade text-blue-600"></i> Detail Siswa per Kelas
        </h3>
        <div class="space-y-3">
            @forelse($siswaPerKelas as $kelas)
            <div>
                <div class="flex items-center justify-between text-sm mb-1">
                    <span class="text-gray-700 font-medium">{{ $kelas->nama_kelas }}</span>
                    <span class="text-gray-500">{{ $kelas->siswas_count }} siswa</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full transition-all" style="width: {{ $totalSiswa > 0 ? ($kelas->siswas_count / $totalSiswa) * 100 : 0 }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">Belum ada data kelas.</p>
            @endforelse
        </div>
    </div>

    {{-- Rapor Terbaru --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="ph ph-clock-counter-clockwise text-gray-600"></i> Rapor Terbaru
        </h3>
        @if($recentRapors->count() > 0)
        <div class="space-y-3">
            @foreach($recentRapors as $r)
            <div class="flex items-center justify-between p-2.5 bg-gray-50 rounded-lg">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $r->siswa->nama_siswa }}</p>
                    <p class="text-xs text-gray-500">{{ $r->kelas->nama_kelas }}</p>
                </div>
                <span class="px-2 py-0.5 text-xs font-semibold rounded-full shrink-0 ml-2 {{ $r->status_rapor == 'final' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($r->status_rapor) }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <i class="ph ph-file-text text-3xl text-gray-300 block mb-2"></i>
            <p class="text-sm text-gray-400">Belum ada rapor.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Siswa per Kelas
    const labelsSiswa = @json($chartKelasLabels);
    const dataSiswa = @json($chartKelasSiswa);
    if (labelsSiswa.length > 0) {
        new Chart(document.getElementById('chartSiswa'), {
            type: 'bar',
            data: {
                labels: labelsSiswa,
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: dataSiswa,
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // Chart Nilai per Kelas
    const labelsNilai = @json(array_keys($rataNilaiPerKelas));
    const dataNilai = @json(array_values($rataNilaiPerKelas));
    if (labelsNilai.length > 0) {
        new Chart(document.getElementById('chartNilai'), {
            type: 'bar',
            data: {
                labels: labelsNilai,
                datasets: [{
                    label: 'Rata-rata',
                    data: dataNilai,
                    backgroundColor: dataNilai.map(v => v >= 75 ? 'rgba(16, 185, 129, 0.5)' : 'rgba(239, 68, 68, 0.5)'),
                    borderColor: dataNilai.map(v => v >= 75 ? 'rgba(16, 185, 129, 1)' : 'rgba(239, 68, 68, 1)'),
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, max: 100, ticks: { stepSize: 20 } },
                    x: { grid: { display: false } }
                }
            }
        });
    }
});
</script>
@endpush