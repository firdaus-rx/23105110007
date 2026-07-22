@extends('layouts.app')

@section('title', 'Data Kelas')
@section('page-title', 'Data Kelas')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <form method="GET" action="{{ route('kelas.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
            <div class="relative flex-1 sm:flex-none">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kelas..." class="pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none w-full sm:w-64">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                <i class="ph ph-magnifying-glass"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('kelas.index') }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <i class="ph ph-x"></i>
                </a>
            @endif
        </form>
        <a href="{{ route('kelas.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition flex items-center gap-2 whitespace-nowrap">
            <i class="ph ph-plus"></i>Tambah Kelas
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Kelas</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Tingkat</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Wali Kelas</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($kelas as $k)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-800">{{ $k->nama_kelas }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">Kelas {{ $k->tingkat }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">{{ $k->waliKelas?->nama_guru ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('kelas.show', $k) }}" class="p-2 bg-white/70 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Lihat Detail Kelas"><i class="ph ph-eye"></i></a>
                            <a href="{{ route('kelas.edit', $k) }}" class="p-2 bg-white/70 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit Data Kelas"><i class="ph ph-pencil"></i></a>
                            <form method="POST" action="{{ route('kelas.destroy', $k) }}" data-confirm="Hapus kelas {{ $k->nama_kelas }}?">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-white/70 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Data Kelas"><i class="ph ph-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">{{ request('search') ? 'Kelas tidak ditemukan.' : 'Belum ada data kelas.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
