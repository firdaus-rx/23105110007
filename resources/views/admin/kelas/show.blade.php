@extends('layouts.app')

@section('title', 'Detail Kelas')
@section('page-title', 'Detail Kelas')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-xs text-gray-500 uppercase">Nama Kelas</p><p class="text-sm font-medium mt-1">{{ $kelas->nama_kelas }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Tingkat</p><p class="text-sm font-medium mt-1">Kelas {{ $kelas->tingkat }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Wali Kelas</p><p class="text-sm font-medium mt-1">{{ $kelas->waliKelas?->nama_guru ?? '-' }}</p></div>
        </div>
        <div class="flex items-center gap-3 mt-6 pt-4 border-t">
            <a href="{{ route('kelas.edit', $kelas) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition">Edit</a>
            <a href="{{ route('kelas.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">Kembali</a>
        </div>
    </div>
</div>
@endsection
