@extends('layouts.app')

@section('title', 'Detail Guru')
@section('page-title', 'Detail Guru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-xs text-gray-500 uppercase">Nama Guru</p><p class="text-sm font-medium text-gray-800 mt-1">{{ $guru->nama_guru }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">NIP</p><p class="text-sm font-medium text-gray-800 mt-1">{{ $guru->nip ?? '-' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Jenis Kelamin</p><p class="text-sm font-medium text-gray-800 mt-1">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Telepon</p><p class="text-sm font-medium text-gray-800 mt-1">{{ $guru->telepon ?? '-' }}</p></div>
            <div class="col-span-2"><p class="text-xs text-gray-500 uppercase">Alamat</p><p class="text-sm font-medium text-gray-800 mt-1">{{ $guru->alamat ?? '-' }}</p></div>
        </div>

        @if($guru->user)
        <div class="mt-6 pt-4 border-t border-gray-200">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Data Akun Pengguna</h4>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-xs text-gray-500 uppercase">Nama Akun</p><p class="text-sm font-medium text-gray-800 mt-1">{{ $guru->user->name }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Email</p><p class="text-sm font-medium text-gray-800 mt-1">{{ $guru->user->email }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Role</p>
                    <p class="text-sm mt-1">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $guru->user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst($guru->user->role) }}
                        </span>
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
            <a href="{{ route('guru.edit', $guru) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition"><i class="ph ph-pencil"></i> Edit</a>
            <a href="{{ route('guru.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition"><i class="ph ph-arrow-left"></i> Kembali</a>
        </div>
    </div>
</div>
@endsection