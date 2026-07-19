@extends('layouts.app')

@section('title', 'Rapor - Wali Kelas')
@section('page-title', 'Rapor - Wali Kelas')

@section('content')
@if(session('error'))
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">{{ session('error') }}</div>
@endif

@if(isset($kelas))
<div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <p class="text-sm text-blue-700">
        <strong>Kelas {{ $kelas->nama_kelas }}</strong> —
        {{ $tahunAktif->nama_tahun ?? '-' }} / {{ $semesterAktif->nama_semester ?? '-' }}
    </p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Siswa</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Total Nilai</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Rata-rata</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Peringkat</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($rapors as $r)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-800 font-medium">{{ $r->siswa->nama_siswa }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center">{{ $r->total_nilai }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center font-medium">{{ number_format($r->rata_rata, 2) }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center">{{ $r->peringkat ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $r->status_rapor == 'final' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($r->status_rapor) }}
                        </span>
                    </td>
                    <td class="px-4 sm:px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            @if($r->status_rapor != 'final')
                            <form method="POST" action="{{ route('guru.wali.rapor.finalisasi', $r) }}" onsubmit="return confirm('Finalisasi rapor {{ $r->siswa->nama_siswa }}?')">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition">
                                    <i class="ph ph-check-circle"></i> Finalisasi
                                </button>
                            </form>
                            @else
                            <a href="{{ route('rapor.cetak', $r) }}" target="_blank" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition">
                                <i class="ph ph-printer"></i> Cetak
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada rapor.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@else
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <i class="ph ph-certificate text-4xl text-gray-300 block mb-3"></i>
    <p class="text-gray-400">Anda belum ditugaskan sebagai wali kelas.</p>
</div>
@endif
@endsection