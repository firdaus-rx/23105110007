@extends('layouts.app')

@section('title', 'Detail Siswa')
@section('page-title', 'Detail Siswa')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-xs text-gray-500 uppercase">NIS</p><p class="text-sm font-medium mt-1">{{ $siswa->nis ?? '-' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">NISN</p><p class="text-sm font-medium mt-1">{{ $siswa->nisn ?? '-' }}</p></div>
            <div class="col-span-2"><p class="text-xs text-gray-500 uppercase">Nama</p><p class="text-sm font-medium mt-1">{{ $siswa->nama_siswa }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Kelas</p><p class="text-sm font-medium mt-1">{{ $siswa->kelas?->nama_kelas ?? '-' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Jenis Kelamin</p><p class="text-sm font-medium mt-1">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Tempat Lahir</p><p class="text-sm font-medium mt-1">{{ $siswa->tempat_lahir ?? '-' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Tanggal Lahir</p><p class="text-sm font-medium mt-1">{{ $siswa->tanggal_lahir ? date('d/m/Y', strtotime($siswa->tanggal_lahir)) : '-' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Agama</p><p class="text-sm font-medium mt-1">{{ $siswa->agama ?? '-' }}</p></div>
            <div class="col-span-2"><p class="text-xs text-gray-500 uppercase">Alamat</p><p class="text-sm font-medium mt-1">{{ $siswa->alamat ?? '-' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Nama Ayah</p><p class="text-sm font-medium mt-1">{{ $siswa->nama_ayah ?? '-' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Nama Ibu</p><p class="text-sm font-medium mt-1">{{ $siswa->nama_ibu ?? '-' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Telepon Orang Tua</p><p class="text-sm font-medium mt-1">{{ $siswa->telepon_orang_tua ?? '-' }}</p></div>
        </div>

        @if($siswa->user)
        <div class="mt-6 pt-4 border-t border-gray-200">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Data Akun Pengguna</h4>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-xs text-gray-500 uppercase">Nama Akun</p><p class="text-sm font-medium text-gray-800 mt-1">{{ $siswa->user->name }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Email</p><p class="text-sm font-medium text-gray-800 mt-1">{{ $siswa->user->email }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Role</p>
                    <p class="text-sm mt-1">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">{{ ucfirst($siswa->user->role) }}</span>
                    </p>
                </div>
            </div>
        </div>
        @else
        <div class="mt-6 pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-400 italic">Belum terhubung dengan akun pengguna.</p>
        </div>
        @endif

        <div class="flex items-center gap-3 mt-6 pt-4 border-t">
            <a href="{{ route('siswa.edit', $siswa) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition"><i class="ph ph-pencil"></i> Edit</a>
            <a href="{{ route('siswa.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition"><i class="ph ph-arrow-left"></i> Kembali</a>
        </div>
    </div>
</div>
@endsection