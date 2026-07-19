@extends('layouts.app')

@section('title', 'Jadwal Mengajar')
@section('page-title', 'Jadwal Mengajar')

@section('content')
@forelse($jadwals as $kelas => $items)
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-200 flex items-center justify-center">
                    <i class="ph ph-buildings text-xl text-blue-700"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-blue-800">Kelas {{ $kelas }}</h3>
                    <p class="text-xs text-blue-600">{{ $items->count() }} mata pelajaran</p>
                </div>
            </div>
            <span class="text-xs text-gray-500">{{ $items->first()->tahunPelajaran->nama_tahun }} / {{ $items->first()->semester->nama_semester }}</span>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Mata Pelajaran</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($items as $j)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-800">{{ $j->mataPelajaran->nama_mapel }}</td>
                    <td class="px-4 sm:px-6 py-4 text-center">
                        <a href="{{ route('guru.nilai.index', $j) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition">
                            <i class="ph ph-pencil-simple"></i> Input Nilai
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <i class="ph ph-clock text-4xl text-gray-300 block mb-3"></i>
    <p class="text-gray-400">Belum ada jadwal mengajar.</p>
</div>
@endforelse
@endsection
