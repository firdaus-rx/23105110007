@extends('layouts.app')

@section('title', 'Rapor Saya')
@section('page-title', 'Rapor Saya')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-200">
        <h3 class="font-semibold text-gray-800">Daftar Rapor {{ $siswa->nama_siswa }}</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Semester</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Rata-rata</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Peringkat</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($rapors as $r)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-800">{{ $r->tahunPelajaran->nama_tahun }} - {{ $r->semester->nama_semester }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center font-medium">{{ number_format($r->rata_rata, 2) }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center">{{ $r->peringkat ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-center">
                        @if($r->status_rapor == 'final')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Final</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">Draft</span>
                        @endif
                    </td>
                    <td class="px-4 sm:px-6 py-4 text-center">
                        <a href="{{ route('rapor.cetak', $r) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition" target="_blank">Cetak</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada rapor final.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
