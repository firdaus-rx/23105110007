@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')
@section('page-title', 'Edit Mata Pelajaran')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('mata-pelajaran.update', $mataPelajaran) }}">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mata Pelajaran <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_mapel" value="{{ old('nama_mapel', $mataPelajaran->nama_mapel) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm {{ $errors->has('nama_mapel') ? 'border-red-500' : '' }}">
                    @error('nama_mapel') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Mapel</label>
                    <input type="text" name="kode_mapel" value="{{ old('kode_mapel', $mataPelajaran->kode_mapel) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm {{ $errors->has('kode_mapel') ? 'border-red-500' : '' }}">
                    @error('kode_mapel') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">KKM <span class="text-red-500">*</span></label>
                    <input type="number" name="kkm" value="{{ old('kkm', $mataPelajaran->kkm) }}" min="0" max="100" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm {{ $errors->has('kkm') ? 'border-red-500' : '' }}">
                    @error('kkm') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelompok</label>
                    <input type="text" name="kelompok" value="{{ old('kelompok', $mataPelajaran->kelompok) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm {{ $errors->has('status') ? 'border-red-500' : '' }}">
                        <option value="aktif" @selected(old('status', $mataPelajaran->status)=='aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status', $mataPelajaran->status)=='nonaktif')>Nonaktif</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Perbarui</button>
                <a href="{{ route('mata-pelajaran.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
