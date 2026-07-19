@extends('layouts.app')

@section('title', 'Edit Rapor')
@section('page-title', 'Edit Rapor')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('rapor.update', $rapor) }}">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-xs text-gray-500 uppercase">Siswa</p>
                    <p class="text-sm font-medium text-gray-800">{{ $rapor->siswa->nama_siswa }} ({{ $rapor->siswa->nis ?? '-' }})</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Kelas</p>
                    <p class="text-sm font-medium text-gray-800">{{ $rapor->kelas->nama_kelas }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Tahun Pelajaran</p>
                    <p class="text-sm font-medium text-gray-800">{{ $rapor->tahunPelajaran->nama_tahun }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Semester</p>
                    <p class="text-sm font-medium text-gray-800">{{ $rapor->semester->nama_semester }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Total Nilai</p>
                    <p class="text-sm font-medium text-gray-800">{{ $rapor->total_nilai }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Rata-rata</p>
                    <p class="text-sm font-medium text-gray-800">{{ number_format($rapor->rata_rata, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Peringkat</p>
                    <p class="text-sm font-medium text-gray-800">{{ $rapor->peringkat ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Status</p>
                    <p><span class="px-2 py-1 text-xs font-semibold rounded-full {{ $rapor->status_rapor == 'final' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ ucfirst($rapor->status_rapor) }}</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Wali Kelas</label>
                    <textarea name="catatan_wali_kelas" rows="4" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm {{ $errors->has('catatan_wali_kelas') ? 'border-red-500' : '' }}">{{ old('catatan_wali_kelas', $rapor->catatan_wali_kelas) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Rapor</label>
                    <select name="status_rapor" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        <option value="draft" @selected(old('status_rapor', $rapor->status_rapor)=='draft')>Draft</option>
                        <option value="final" @selected(old('status_rapor', $rapor->status_rapor)=='final')>Final</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Rapor</label>
                    <input type="date" name="tanggal_rapor" value="{{ old('tanggal_rapor', $rapor->tanggal_rapor ? date('Y-m-d', strtotime($rapor->tanggal_rapor)) : date('Y-m-d')) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                    <i class="ph ph-check"></i> Perbarui Rapor
                </button>
                <a href="{{ route('rapor.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection