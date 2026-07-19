@extends('layouts.app')

@section('title', 'Data Guru')
@section('page-title', 'Data Guru')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <a href="{{ route('guru.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition flex items-center gap-2">
            <i class="ph ph-plus"></i>Tambah Guru
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nama</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">NIP</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Jenis Kelamin</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Telepon</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Akun</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($gurus as $guru)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-800">{{ $guru->nama_guru }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">{{ $guru->nip ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">{{ $guru->telepon ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm">
                        @if($guru->user)
                            <span class="text-gray-800">{{ $guru->user->name }}</span>
                            <span class="text-xs text-gray-400 block">{{ $guru->user->email }}</span>
                        @else
                            <span class="text-gray-400 italic">-</span>
                        @endif
                    </td>
                    <td class="px-4 sm:px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('guru.show', $guru) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Detail">
                                <i class="ph ph-eye"></i>
                            </a>
                            <a href="{{ route('guru.edit', $guru) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                <i class="ph ph-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('guru.destroy', $guru) }}" onsubmit="return confirm('Hapus data guru {{ $guru->nama_guru }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <i class="ph ph-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <i class="ph ph-chalkboard-teacher text-4xl text-gray-300 block mb-3"></i>
                        <p class="text-gray-400">Belum ada data guru.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection