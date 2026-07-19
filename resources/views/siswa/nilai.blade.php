@extends('layouts.app')

@section('title', 'Nilai Saya')
@section('page-title', 'Nilai Saya')

@section('content')
@forelse($nilaiPerTahun as $group)
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-blue-800">
                    Tahun Pelajaran {{ $group->tahun }} - Semester {{ $group->semester }}
                </h3>
                <p class="text-xs text-blue-600 mt-0.5">{{ $group->nilais->count() }} mata pelajaran</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">Rata-rata</p>
                <p class="text-lg font-bold text-blue-700">{{ number_format($group->rata_rata, 2) }}</p>
            </div>
        </div>
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
                @foreach($group->nilais as $n)
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
            <tfoot class="bg-gray-100 font-semibold">
                <tr>
                    <td class="px-4 sm:px-6 py-3 text-sm text-right text-gray-700" colspan="4">Rata-rata Semester</td>
                    <td class="px-4 sm:px-6 py-3 text-sm text-center text-blue-700">{{ number_format($group->rata_rata, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@empty
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <i class="ph ph-file-text text-4xl text-gray-300 block mb-3"></i>
    <p class="text-gray-400">Belum ada data nilai.</p>
</div>
@endforelse
@endsection
