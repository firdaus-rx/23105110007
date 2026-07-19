@extends('layouts.app')

@section('title', 'Data Siswa - Wali Kelas')
@section('page-title', 'Data Siswa - Wali Kelas')

@section('content')
@if(session('error'))
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">{{ session('error') }}</div>
@endif

@if(isset($kelas))
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="ph ph-buildings text-2xl text-blue-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Kelas</p>
                <p class="text-lg font-semibold text-gray-800">{{ $kelas->nama_kelas }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="ph ph-users text-2xl text-green-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jumlah Siswa</p>
                <p class="text-lg font-semibold text-gray-800">{{ $siswas->count() }} siswa</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="ph ph-chalkboard-teacher text-2xl text-purple-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Wali Kelas</p>
                <p class="text-lg font-semibold text-gray-800">{{ $kelas->waliKelas?->nama_guru ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Daftar Siswa</h3>
            <div class="flex gap-2">
                <a href="{{ route('guru.wali.absensi') }}" class="px-3 py-1.5 bg-orange-600 hover:bg-orange-700 text-white text-xs font-medium rounded-lg transition">
                    <i class="ph ph-clipboard-text"></i> Input Absensi
                </a>
                <a href="{{ route('guru.wali.rapor') }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition">
                    <i class="ph ph-certificate"></i> Rapor
                </a>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">NIS</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Siswa</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Jenis Kelamin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($siswas as $s)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">{{ $s->nis ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-800 font-medium">{{ $s->nama_siswa }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-6 py-12 text-center text-gray-400">Belum ada siswa di kelas ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@else
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <i class="ph ph-users text-4xl text-gray-300 block mb-3"></i>
    <p class="text-gray-400">Anda belum ditugaskan sebagai wali kelas.</p>
</div>
@endif
@endsection