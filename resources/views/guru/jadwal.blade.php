@extends('layouts.app')

@section('title', 'Jadwal Mengajar')
@section('page-title', 'Jadwal Mengajar')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
    <form method="GET" action="{{ route('guru.jadwal') }}" class="flex flex-wrap items-end gap-3">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-medium text-gray-500 mb-1.5 tracking-wide uppercase">Tahun Pelajaran</label>
            <div class="relative">
                <select name="tahun_pelajaran_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition appearance-none">
                    <option value="">Aktif: {{ $tahunAktif?->nama_tahun ?? '-' }}</option>
                    <option value="">Aktif: {{ $tahunAktif?->nama_tahun ?? '-' }}</option>
                    @foreach($allTahun as $t)
                        <option value="{{ $t->id }}" @selected(request('tahun_pelajaran_id') == $t->id)>{{ $t->nama_tahun }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex-1 min-w-[180px]">
            <label class="block text-xs font-medium text-gray-500 mb-1.5 tracking-wide uppercase">Semester</label>
            <div class="relative">
                <select name="semester_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition appearance-none">
                    <option value="">Aktif: {{ $semesterAktif?->nama_semester ?? '-' }}</option>
                    @foreach($allSemester as $s)
                        <option value="{{ $s->id }}" @selected(request('semester_id') == $s->id)>{{ $s->nama_semester }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition shadow-sm">
                <i class="ph ph-funnel"></i> Filter
            </button>
            <a href="{{ route('guru.jadwal') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-xl transition">
                <i class="ph ph-arrows-counter-clockwise"></i>
            </a>
        </div>
    </form>
</div>

@forelse($jadwals as $kelas => $items)
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-5 hover:shadow-md transition">
    <div class="px-5 sm:px-6 py-4 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-sm flex items-center justify-center">
                    <i class="ph ph-buildings text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Kelas {{ $kelas }}</h3>
                    <p class="text-xs text-gray-400">{{ $items->count() }} mata pelajaran</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full">
                    <i class="ph ph-calendar"></i>
                    {{ $items->first()->tahunPelajaran->nama_tahun }}
                </span>
                <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 text-xs font-medium rounded-full">
                    <i class="ph ph-clock"></i>
                    {{ $items->first()->semester->nama_semester }}
                </span>
            </div>
        </div>
    </div>
    <div class="divide-y divide-gray-50">
        @foreach($items as $j)
        <div class="flex items-center justify-between px-5 sm:px-6 py-3.5 hover:bg-gray-50/80 transition group">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-blue-100 transition">
                    <i class="ph ph-book-open text-sm text-gray-500 group-hover:text-blue-600 transition"></i>
                </div>
                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition">{{ $j->mataPelajaran->nama_mapel }}</span>
            </div>
            <a href="{{ route('guru.nilai.index', $j) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-xl transition shadow-sm">
                <i class="ph ph-pencil-simple text-sm"></i> Input Nilai
            </a>
        </div>
        @endforeach
    </div>
</div>
@empty
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-14 text-center">
    <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-4">
        <i class="ph ph-clock text-3xl text-gray-300"></i>
    </div>
    <p class="text-gray-400 font-medium">Belum ada jadwal mengajar</p>
    <p class="text-xs text-gray-300 mt-1">Untuk periode yang dipilih</p>
</div>
@endforelse
@endsection
