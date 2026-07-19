@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Absensi</h1>
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form method="POST" action="{{ route('absensi.update', $absensi) }}">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Siswa <span class="text-red-500">*</span></label>
                    <select name="siswa_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        @foreach($siswas as $s)
                            <option value="{{ $s->id }}" @selected(old('siswa_id', $absensi->siswa_id)==$s->id)>{{ $s->nama_siswa }} ({{ $s->nis ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                    <select name="kelas_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" @selected(old('kelas_id', $absensi->kelas_id)==$k->id)>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Pelajaran <span class="text-red-500">*</span></label>
                    <select name="tahun_pelajaran_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        @foreach($tahunPelajarans as $t)
                            <option value="{{ $t->id }}" @selected(old('tahun_pelajaran_id', $absensi->tahun_pelajaran_id)==$t->id)>{{ $t->nama_tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semester <span class="text-red-500">*</span></label>
                    <select name="semester_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        @foreach($semesters as $s)
                            <option value="{{ $s->id }}" @selected(old('semester_id', $absensi->semester_id)==$s->id)>{{ $s->nama_semester }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sakit</label>
                        <input type="number" name="sakit" value="{{ old('sakit', $absensi->sakit) }}" min="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Izin</label>
                        <input type="number" name="izin" value="{{ old('izin', $absensi->izin) }}" min="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alfa</label>
                        <input type="number" name="alfa" value="{{ old('alfa', $absensi->alfa) }}" min="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Perbarui</button>
                <a href="{{ route('absensi.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
