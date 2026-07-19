@extends('layouts.app')

@section('title', 'Input Absensi')
@section('page-title', 'Input Absensi - Wali Kelas')

@section('content')
@if(session('error'))
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">{{ session('error') }}</div>
@endif

@if(isset($kelas))
<div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <p class="text-sm text-blue-700">
        <strong>Kelas {{ $kelas->nama_kelas }}</strong> —
        {{ $tahunAktif->nama_tahun ?? '-' }} / {{ $semesterAktif->nama_semester ?? '-' }}
    </p>
</div>

<form method="POST" action="{{ route('guru.wali.absensi.store') }}">
    @csrf
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Siswa</th>
                        <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Sakit</th>
                        <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Izin</th>
                        <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Alfa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($siswas as $siswa)
                    @php $a = $absensis->get($siswa->id); @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-3 text-sm text-gray-800">{{ $siswa->nama_siswa }}</td>
                        <td class="px-4 sm:px-6 py-3 text-center">
                            <input type="number" name="absensi[{{ $siswa->id }}][sakit]" value="{{ old('absensi.' . $siswa->id . '.sakit', $a->sakit ?? 0) }}" min="0" class="w-20 text-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none mx-auto block">
                        </td>
                        <td class="px-4 sm:px-6 py-3 text-center">
                            <input type="number" name="absensi[{{ $siswa->id }}][izin]" value="{{ old('absensi.' . $siswa->id . '.izin', $a->izin ?? 0) }}" min="0" class="w-20 text-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none mx-auto block">
                        </td>
                        <td class="px-4 sm:px-6 py-3 text-center">
                            <input type="number" name="absensi[{{ $siswa->id }}][alfa]" value="{{ old('absensi.' . $siswa->id . '.alfa', $a->alfa ?? 0) }}" min="0" class="w-20 text-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none mx-auto block">
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada siswa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($siswas->count() > 0)
        <div class="p-4 sm:p-6 border-t border-gray-200">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                <i class="ph ph-check"></i> Simpan Absensi
            </button>
        </div>
        @endif
    </div>
</form>
@else
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <i class="ph ph-clipboard-text text-4xl text-gray-300 block mb-3"></i>
    <p class="text-gray-400">Anda belum ditugaskan sebagai wali kelas.</p>
</div>
@endif
@endsection