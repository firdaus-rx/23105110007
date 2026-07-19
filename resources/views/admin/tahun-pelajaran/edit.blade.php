@extends('layouts.app')

@section('title', 'Edit Tahun Pelajaran')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Tahun Pelajaran</h1>
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form method="POST" action="{{ route('tahun-pelajaran.update', $tahunPelajaran) }}">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tahun Pelajaran <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_tahun" value="{{ old('nama_tahun', $tahunPelajaran->nama_tahun) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                </div>
                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="status_aktif" value="1" @checked(old('status_aktif', $tahunPelajaran->status_aktif)) class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Aktifkan sebagai tahun pelajaran aktif</span>
                    </label>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Perbarui</button>
                <a href="{{ route('tahun-pelajaran.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
