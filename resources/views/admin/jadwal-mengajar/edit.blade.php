@extends('layouts.app')

@section('title', 'Edit Jadwal Mengajar')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Jadwal Mengajar</h1>
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form method="POST" action="{{ route('jadwal-mengajar.update', $jadwalMengajar) }}">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Guru <span class="text-red-500">*</span></label>
                    <select name="guru_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        @foreach($gurus as $g)
                            <option value="{{ $g->id }}" @selected(old('guru_id', $jadwalMengajar->guru_id)==$g->id)>{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                    <select name="kelas_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" @selected(old('kelas_id', $jadwalMengajar->kelas_id)==$k->id)>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran <span class="text-red-500">*</span></label>
                    <select name="mata_pelajaran_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        @foreach($mataPelajarans as $m)
                            <option value="{{ $m->id }}" @selected(old('mata_pelajaran_id', $jadwalMengajar->mata_pelajaran_id)==$m->id)>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Pelajaran <span class="text-red-500">*</span></label>
                    <select name="tahun_pelajaran_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        @foreach($tahunPelajarans as $t)
                            <option value="{{ $t->id }}" @selected(old('tahun_pelajaran_id', $jadwalMengajar->tahun_pelajaran_id)==$t->id)>{{ $t->nama_tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semester <span class="text-red-500">*</span></label>
                    <select name="semester_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        @foreach($semesters as $s)
                            <option value="{{ $s->id }}" @selected(old('semester_id', $jadwalMengajar->semester_id)==$s->id)>{{ $s->nama_semester }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Perbarui</button>
                <a href="{{ route('jadwal-mengajar.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
