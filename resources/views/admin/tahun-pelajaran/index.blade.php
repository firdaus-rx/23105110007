@extends('layouts.app')

@section('title', 'Tahun Pelajaran')
@section('page-title', 'Tahun Pelajaran')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-200 flex justify-between items-center">
        <a href="{{ route('tahun-pelajaran.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition flex items-center gap-2">
            <i class="ph ph-plus"></i>Tambah Tahun Pelajaran
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Tahun</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($tahunPelajarans as $t)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-800">{{ $t->nama_tahun }}</td>
                    <td class="px-4 sm:px-6 py-4 text-center">
                        @if($t->status_aktif)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Aktif</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-500">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 sm:px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('tahun-pelajaran.edit', $t) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg" title="Edit"><i class="ph ph-pencil"></i></a>
                            <form method="POST" action="{{ route('tahun-pelajaran.destroy', $t) }}" onsubmit="return confirm('Hapus {{ $t->nama_tahun }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Hapus"><i class="ph ph-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-6 py-12 text-center text-gray-400">Belum ada data tahun pelajaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
