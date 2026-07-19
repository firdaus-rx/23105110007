@php
    $role = Auth::user()->role;
@endphp

<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 flex flex-col">
    <div class="flex items-center gap-3 px-6 h-16 border-b border-gray-200">
        <i class="ph ph-book-open text-2xl text-blue-600"></i>
        <div>
            <h1 class="font-bold text-sm text-gray-800 leading-tight">Smart Academic</h1>
            <p class="text-xs text-gray-500">MIN 21 Pidie</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto p-4 space-y-1">
        @if($role === 'admin')
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Admin</p>
            <x-nav-link href="{{ route('admin.dashboard') }}" icon="ph-chart-bar" label="Dashboard" />
            <x-nav-link href="{{ url('/admin/guru') }}" icon="ph-chalkboard-teacher" label="Data Guru" />
            <x-nav-link href="{{ url('/admin/kelas') }}" icon="ph-buildings" label="Data Kelas" />
            <x-nav-link href="{{ url('/admin/siswa') }}" icon="ph-student" label="Data Siswa" />
            <x-nav-link href="{{ url('/admin/mata-pelajaran') }}" icon="ph-book" label="Mata Pelajaran" />
            <x-nav-link href="{{ url('/admin/tahun-pelajaran') }}" icon="ph-calendar" label="Tahun Pelajaran" />
            <x-nav-link href="{{ url('/admin/semester') }}" icon="ph-calendar-blank" label="Semester" />
            <x-nav-link href="{{ url('/admin/jadwal-mengajar') }}" icon="ph-clock" label="Jadwal Mengajar" />
            <x-nav-link href="{{ url('/admin/nilai-rapor') }}" icon="ph-file-text" label="Nilai Rapor" />
            <x-nav-link href="{{ url('/admin/absensi') }}" icon="ph-clipboard-text" label="Absensi" />
            <x-nav-link href="{{ url('/admin/rapor') }}" icon="ph-certificate" label="Rapor" />

        @elseif($role === 'guru')
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Guru</p>
            <x-nav-link href="{{ route('guru.dashboard') }}" icon="ph-chart-bar" label="Dashboard" />
            <x-nav-link href="{{ route('guru.jadwal') }}" icon="ph-clock" label="Jadwal Mengajar" />
            <x-nav-link href="{{ route('guru.nilai.rekap') }}" icon="ph-file-text" label="Rekap Nilai" />
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-4 mb-2">Wali Kelas</p>
            <x-nav-link href="{{ route('guru.wali.index') }}" icon="ph-users" label="Data Siswa" />
            <x-nav-link href="{{ route('guru.wali.absensi') }}" icon="ph-clipboard-text" label="Absensi" />
            <x-nav-link href="{{ route('guru.wali.rapor') }}" icon="ph-certificate" label="Rapor" />

        @elseif(in_array($role, ['siswa', 'orang_tua']))
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Siswa / Orang Tua</p>
            <x-nav-link href="{{ route('siswa.dashboard') }}" icon="ph-chart-bar" label="Dashboard" />
            <x-nav-link href="{{ route('siswa.nilai') }}" icon="ph-file-text" label="Nilai Saya" />
            <x-nav-link href="{{ route('siswa.rapor') }}" icon="ph-certificate" label="Rapor Saya" />
        @endif
    </nav>

    <div class="p-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition">
                <i class="ph ph-sign-out text-lg"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
