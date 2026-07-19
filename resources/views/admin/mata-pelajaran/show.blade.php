@extends('layouts.app')

@section('title', 'Detail Mata Pelajaran')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Detail Mata Pelajaran</h1>
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-xs text-gray-500 uppercase">Nama Mapel</p><p class="text-sm font-medium mt-1">{{ $mataPelajaran->nama_mapel }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Kode Mapel</p><p class="text-sm font-medium mt-1">{{ $mataPelajaran->kode_mapel ?? '-' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">KKM</p><p class="text-sm font-medium mt-1">{{ $mataPelajaran->kkm }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Kelompok</p><p class="text-sm font-medium mt-1">{{ $mataPelajaran->kelompok ?? '-' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Status</p>
                <p class="text-sm font-medium mt-1">
                    <span class="px-2 py-1 text-xs rounded-full {{ $mataPelajaran->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($mataPelajaran->status) }}
                    </span>
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3 mt-6 pt-4 border-t">
            <a href="{{ route('mata-pelajaran.edit', $mataPelajaran) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition"><i class="ph ph-pencil"></i> Edit</a>
            <a href="{{ route('mata-pelajaran.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition"><i class="ph ph-arrow-left"></i> Kembali</a>
        </div>
    </div>
</div>
@endsection
