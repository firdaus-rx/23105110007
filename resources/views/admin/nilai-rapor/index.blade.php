@extends('layouts.app')

@section('title', 'Nilai Rapor')
@section('page-title', 'Nilai Rapor')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-6">
    <form method="GET" action="{{ route('nilai-rapor.index') }}" class="grid grid-cols-1 sm:grid-cols-5 gap-4">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Kelas</label>
            <select name="kelas_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" @selected(request('kelas_id') == $k->id)>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Mata Pelajaran</label>
            <select name="mata_pelajaran_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">Semua Mapel</option>
                @foreach($mataPelajarans as $m)
                    <option value="{{ $m->id }}" @selected(request('mata_pelajaran_id') == $m->id)>{{ $m->nama_mapel }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Tahun Pelajaran</label>
            <select name="tahun_pelajaran_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">Aktif: {{ $tahunAktif->nama_tahun ?? '-' }}</option>
                @foreach($tahunPelajarans as $t)
                    <option value="{{ $t->id }}" @selected(request('tahun_pelajaran_id') == $t->id)>{{ $t->nama_tahun }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Semester</label>
            <select name="semester_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">Aktif: {{ $semesterAktif->nama_semester ?? '-' }}</option>
                @foreach($semesters as $s)
                    <option value="{{ $s->id }}" @selected(request('semester_id') == $s->id)>{{ $s->nama_semester }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition flex-1">
                <i class="ph ph-funnel"></i> Filter
            </button>
            <a href="{{ route('nilai-rapor.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                <i class="ph ph-arrows-counter-clockwise"></i>
            </a>
            <a href="{{ route('nilai-rapor.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
                <i class="ph ph-plus"></i>
            </a>
        </div>
    </form>
</div>

@forelse($nilais as $kelas => $items)
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-teal-50 to-teal-100 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-teal-200 flex items-center justify-center">
                    <i class="ph ph-file-text text-xl text-teal-700"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-teal-800">Kelas {{ $kelas }}</h3>
                    <p class="text-xs text-teal-600">{{ count($items) }} data nilai</p>
                </div>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Siswa</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Mapel</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Pengetahuan</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Keterampilan</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Predikat</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($items as $nilai)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-800">{{ $nilai->siswa->nama_siswa }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">{{ $nilai->mataPelajaran->nama_mapel }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center">{{ $nilai->nilai_pengetahuan ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center">{{ $nilai->nilai_keterampilan ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($nilai->predikat == 'A') bg-green-100 text-green-700
                            @elseif($nilai->predikat == 'B') bg-blue-100 text-blue-700
                            @elseif($nilai->predikat == 'C') bg-amber-100 text-amber-700
                            @else bg-red-100 text-red-700
                            @endif">{{ $nilai->predikat ?? '-' }}</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('nilai-rapor.edit', $nilai) }}" class="p-2 bg-white/70 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit Nilai"><i class="ph ph-pencil"></i></a>
                            <form method="POST" action="{{ route('nilai-rapor.destroy', $nilai) }}" data-confirm="Hapus nilai {{ $nilai->siswa->nama_siswa }} - {{ $nilai->mataPelajaran->nama_mapel }}?">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-white/70 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Nilai"><i class="ph ph-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <i class="ph ph-file-text text-4xl text-gray-300 block mb-3"></i>
    <p class="text-gray-400">Belum ada data nilai.</p>
</div>
@endforelse
@endsection