@extends('layouts.app')

@section('title', 'Data Siswa - Wali Kelas')
@section('page-title', 'Data Siswa - Wali Kelas')

@section('content')
@if(session('error'))
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">{{ session('error') }}</div>
@endif

@if(isset($kelasList) && $kelasList->isNotEmpty())
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="ph ph-buildings text-2xl text-blue-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Kelas</p>
                <p class="text-lg font-semibold text-gray-800">{{ $kelasList->count() }} kelas</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="ph ph-users text-2xl text-green-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Siswa</p>
                <p class="text-lg font-semibold text-gray-800">{{ collect($siswaPerKelas)->flatten()->count() }} siswa</p>
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
                <p class="text-lg font-semibold text-gray-800">{{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>
</div>

@foreach($kelasList as $kelas)
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="px-5 sm:px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 shadow-sm flex items-center justify-center">
                <i class="ph ph-buildings text-white text-sm"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Kelas {{ $kelas->nama_kelas }}</h3>
                <p class="text-xs text-gray-400">{{ $siswaPerKelas[$kelas->id]->count() }} siswa</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('guru.wali.absensi', ['kelas_id' => $kelas->id]) }}" class="px-3 py-1.5 bg-orange-50 hover:bg-orange-100 text-orange-700 text-xs font-medium rounded-lg transition">
                <i class="ph ph-clipboard-text"></i> Absensi
            </a>
            <a href="{{ route('guru.wali.rapor', ['kelas_id' => $kelas->id]) }}" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-medium rounded-lg transition">
                <i class="ph ph-certificate"></i> Rapor
            </a>
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
                @forelse($siswaPerKelas[$kelas->id] as $s)
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
@endforeach
@else
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <i class="ph ph-users text-4xl text-gray-300 block mb-3"></i>
    <p class="text-gray-400">Anda belum ditugaskan sebagai wali kelas.</p>
</div>
@endif
@endsection
