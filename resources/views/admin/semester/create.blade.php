@extends('layouts.app')

@section('title', 'Tambah Semester')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Tambah Semester</h1>
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form method="POST" action="{{ route('semester.store') }}">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Semester <span class="text-red-500">*</span></label>
                    <select name="nama_semester" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        <option value="Ganjil" @selected(old('nama_semester')=='Ganjil')>Ganjil</option>
                        <option value="Genap" @selected(old('nama_semester')=='Genap')>Genap</option>
                    </select>
                </div>
                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="status_aktif" value="1" @checked(old('status_aktif')) class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Aktifkan sebagai semester aktif</span>
                    </label>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Simpan</button>
                <a href="{{ route('semester.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
