@extends('layouts.app')

@section('title', 'Mata Pelajaran')
@section('page-title', 'Mata Pelajaran')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <form method="GET" action="{{ route('mata-pelajaran.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
            <div class="relative flex-1 sm:flex-none">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari mapel..." class="pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none w-full sm:w-64">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                <i class="ph ph-magnifying-glass"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('mata-pelajaran.index') }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="ph ph-x"></i>
                </a>
            @endif
        </form>
        <a href="{{ route('mata-pelajaran.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition flex items-center gap-2 whitespace-nowrap">
            <i class="ph ph-plus"></i>Tambah Mapel
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Kode</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Mapel</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">KKM</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Kelompok</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($mataPelajarans as $mapel)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">{{ $mapel->kode_mapel ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-800 font-medium">{{ $mapel->nama_mapel }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">{{ $mapel->kkm }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">{{ $mapel->kelompok ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $mapel->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($mapel->status) }}
                        </span>
                    </td>
                    <td class="px-4 sm:px-6 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('mata-pelajaran.show', $mapel) }}" class="p-2 bg-white/70 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Lihat Detail Mapel"><i class="ph ph-eye"></i></a>
                            <a href="{{ route('mata-pelajaran.edit', $mapel) }}" class="p-2 bg-white/70 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit Mata Pelajaran"><i class="ph ph-pencil"></i></a>
                            <form method="POST" action="{{ route('mata-pelajaran.destroy', $mapel) }}" data-confirm="Hapus {{ $mapel->nama_mapel }}?">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-white/70 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Mata Pelajaran"><i class="ph ph-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">{{ request('search') ? 'Mata pelajaran tidak ditemukan.' : 'Belum ada data mata pelajaran.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
