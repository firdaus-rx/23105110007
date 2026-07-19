@extends('layouts.app')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-6">
    <form method="GET" action="{{ route('siswa.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Kelas</label>
            <select name="kelas_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" @selected($selectedKelas == $k->id)>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                <i class="ph ph-funnel"></i> Filter
            </button>
            <a href="{{ route('siswa.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                <i class="ph ph-arrows-counter-clockwise"></i>
            </a>
            <a href="{{ route('siswa.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
                <i class="ph ph-plus"></i> Tambah
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">NIS</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nama</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Kelas</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Jenis Kelamin</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Akun</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($siswas as $siswa)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">{{ $siswa->nis ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-800 font-medium">{{ $siswa->nama_siswa }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">{{ $siswa->kelas?->nama_kelas ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm">
                        @if($siswa->user)
                            <span class="text-gray-800">{{ $siswa->user->name }}</span>
                            <span class="text-xs text-gray-400 block">{{ $siswa->user->email }}</span>
                        @else
                            <span class="text-gray-400 italic">-</span>
                        @endif
                    </td>
                    <td class="px-4 sm:px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('siswa.show', $siswa) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="Detail"><i class="ph ph-eye"></i></a>
                            <a href="{{ route('siswa.edit', $siswa) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg" title="Edit"><i class="ph ph-pencil"></i></a>
                            <form method="POST" action="{{ route('siswa.destroy', $siswa) }}" onsubmit="return confirm('Hapus {{ $siswa->nama_siswa }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Hapus"><i class="ph ph-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada data siswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
