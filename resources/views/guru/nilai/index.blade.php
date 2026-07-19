@extends('layouts.app')

@section('title')
    Input Nilai - {{ $jadwal->mataPelajaran->nama_mapel }}
@endsection

@section('page-title')
    Input Nilai: {{ $jadwal->kelas->nama_kelas }} - {{ $jadwal->mataPelajaran->nama_mapel }}
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-200">
        <p class="text-sm text-gray-600">Tahun Pelajaran: {{ $jadwal->tahunPelajaran->nama_tahun }} | Semester: {{ $jadwal->semester->nama_semester }}</p>
    </div>
    <form method="POST" action="{{ route('guru.nilai.store', $jadwal) }}">
        @csrf
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Siswa</th>
                        <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Pengetahuan (0-100)</th>
                        <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Keterampilan (0-100)</th>
                        <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Sikap</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($siswas as $siswa)
                    @php $n = $nilais->get($siswa->id); @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-3 text-sm text-gray-800">{{ $siswa->nama_siswa }}</td>
                        <td class="px-4 sm:px-6 py-3">
                            <input type="number" name="nilai[{{ $siswa->id }}][nilai_pengetahuan]" value="{{ old('nilai.' . $siswa->id . '.nilai_pengetahuan', $n->nilai_pengetahuan ?? '') }}" min="0" max="100" class="w-24 text-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none mx-auto block">
                        </td>
                        <td class="px-4 sm:px-6 py-3">
                            <input type="number" name="nilai[{{ $siswa->id }}][nilai_keterampilan]" value="{{ old('nilai.' . $siswa->id . '.nilai_keterampilan', $n->nilai_keterampilan ?? '') }}" min="0" max="100" class="w-24 text-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none mx-auto block">
                        </td>
                        <td class="px-4 sm:px-6 py-3">
                            <input type="text" name="nilai[{{ $siswa->id }}][nilai_sikap]" value="{{ old('nilai.' . $siswa->id . '.nilai_sikap', $n->nilai_sikap ?? '') }}" class="w-28 text-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none mx-auto block" placeholder="Baik">
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">Tidak ada siswa di kelas ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($siswas->count() > 0)
        <div class="p-4 sm:p-6 border-t border-gray-200">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Simpan Semua Nilai</button>
        </div>
        @endif
    </form>
</div>
@endsection
