@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">

    {{-- Profile Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-8">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 sm:gap-6">
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg flex items-center justify-center shrink-0">
                <i class="ph ph-user text-white text-3xl sm:text-4xl"></i>
            </div>
            <div class="flex-1 text-center sm:text-left min-w-0">
                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $user->name }}</h3>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-1.5">
                    <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-full capitalize">{{ $user->role }}</span>
                    <span class="text-gray-300 hidden sm:inline">•</span>
                    <span class="text-sm text-gray-400 truncate">{{ $user->email }}</span>
                </div>
                @if($profile)
                <div class="flex flex-wrap justify-center sm:justify-start gap-3 sm:gap-5 mt-4 pt-4 border-t border-gray-100">
                    @if($profile instanceof \App\Models\Guru)
                    <div class="text-center sm:text-left">
                        <p class="text-[11px] text-gray-400 font-medium">NIP</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $profile->nip ?? '-' }}</p>
                    </div>
                    <div class="text-center sm:text-left">
                        <p class="text-[11px] text-gray-400 font-medium">Jenis Kelamin</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $profile->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div class="text-center sm:text-left">
                        <p class="text-[11px] text-gray-400 font-medium">Telepon</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $profile->telepon ?? '-' }}</p>
                    </div>
                    @else
                    <div class="text-center sm:text-left">
                        <p class="text-[11px] text-gray-400 font-medium">NIS</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $profile->nis ?? '-' }}</p>
                    </div>
                    <div class="text-center sm:text-left">
                        <p class="text-[11px] text-gray-400 font-medium">Kelas</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $profile->kelas?->nama_kelas ?? '-' }}</p>
                    </div>
                    <div class="text-center sm:text-left">
                        <p class="text-[11px] text-gray-400 font-medium">Jenis Kelamin</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $profile->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Form Edit --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 sm:px-8 py-4 sm:py-5 border-b border-gray-100">
            <h3 class="text-sm sm:text-base font-semibold text-gray-800 flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                    <i class="ph ph-pencil-circle text-blue-600 text-sm"></i>
                </span>
                Edit Profil
            </h3>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="p-5 sm:p-8">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                <div class="sm:col-span-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Informasi Akun</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                @if($profile)
                <div class="sm:col-span-2">
                    <div class="border-t border-gray-100 my-1"></div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 mt-5">Data Pribadi</p>
                </div>

                @if($profile instanceof \App\Models\Guru)
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">NIP</label>
                    <input type="text" value="{{ $profile->nip ?? '-' }}" readonly class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $profile->telepon) }}" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition">
                </div>
                @elseif($profile instanceof \App\Models\Siswa)
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">NIS</label>
                    <input type="text" value="{{ $profile->nis ?? '-' }}" readonly class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Kelas</label>
                    <input type="text" value="{{ $profile->kelas?->nama_kelas ?? '-' }}" readonly class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-500 cursor-not-allowed">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Alamat</label>
                    <textarea name="alamat" rows="2" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition resize-none">{{ old('alamat', $profile->alamat) }}</textarea>
                </div>
                @endif
                @endif

                <div class="sm:col-span-2">
                    <div class="border-t border-gray-100 my-1"></div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 mt-5">Keamanan</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Password Baru <span class="text-gray-300 font-normal">(opsional)</span></label>
                    <input type="password" name="password" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition" placeholder="Min. 6 karakter">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition" placeholder="Ulangi password">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-5 border-t border-gray-100">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition shadow-sm flex items-center gap-2">
                    <i class="ph ph-check-circle text-base"></i>
                    Simpan Perubahan
                </button>
                <a href="{{ url()->previous() }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
