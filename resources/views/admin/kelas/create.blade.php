@extends('layouts.app')

@section('title', 'Tambah Kelas')
@section('page-title', 'Tambah Kelas')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('kelas.store') }}">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kelas" value="{{ old('nama_kelas') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm {{ $errors->has('nama_kelas') ? 'border-red-500' : '' }}">
                    @error('nama_kelas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat <span class="text-red-500">*</span></label>
                    <select name="tingkat" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm {{ $errors->has('tingkat') ? 'border-red-500' : '' }}">
                        <option value="">Pilih...</option>
                        @for($i=1; $i<=6; $i++)
                            <option value="{{ $i }}" @selected(old('tingkat')==$i)>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('tingkat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas</label>
                    <select name="wali_kelas_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm {{ $errors->has('wali_kelas_id') ? 'border-red-500' : '' }}">
                        <option value="">Pilih...</option>
                        @foreach($gurus as $g)
                            <option value="{{ $g->id }}" @selected(old('wali_kelas_id')==$g->id)>{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                    @error('wali_kelas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Simpan</button>
                <a href="{{ route('kelas.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
