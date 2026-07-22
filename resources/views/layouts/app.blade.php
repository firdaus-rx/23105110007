<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Smart Academic') - MIN 21 Pidie</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:opsz@14..32&display=swap">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-100 font-sans antialiased">

    @auth
    <div id="app">
        {{-- Mobile backdrop --}}
        <div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-black/50 lg:hidden hidden transition-opacity" onclick="toggleSidebar()"></div>

        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 flex flex-col -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-between px-6 h-16 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <i class="ph ph-book-open text-2xl text-blue-600"></i>
                    <div>
                        <h1 class="font-bold text-sm text-gray-800 leading-tight">Smart Academic</h1>
                        <p class="text-xs text-gray-500">MIN 21 Pidie</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="lg:hidden p-1 text-gray-400 hover:text-gray-600 rounded-lg">
                    <i class="ph ph-x text-xl"></i>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto p-4 space-y-1 scrollbar-thin">
                @php $role = Auth::user()->role; @endphp

                @if($role === 'admin')
                    <x-nav-link href="{{ route('admin.dashboard') }}" icon="ph-chart-bar" label="Dashboard" route="admin.dashboard" />
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-6 mb-2">Master Data</p>
                    <x-nav-link href="{{ url('/admin/guru') }}" icon="ph-chalkboard-teacher" label="Data Guru" route="guru.*" />
                    <x-nav-link href="{{ url('/admin/kelas') }}" icon="ph-buildings" label="Data Kelas" route="kelas.*" />
                    <x-nav-link href="{{ url('/admin/siswa') }}" icon="ph-student" label="Data Siswa" route="siswa.*" />
                    <x-nav-link href="{{ url('/admin/mata-pelajaran') }}" icon="ph-book" label="Mata Pelajaran" route="mata-pelajaran.*" />
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-4 mb-2">Pengaturan</p>
                    <x-nav-link href="{{ url('/admin/tahun-pelajaran') }}" icon="ph-calendar" label="Tahun Pelajaran" route="tahun-pelajaran.*" />
                    <x-nav-link href="{{ url('/admin/semester') }}" icon="ph-calendar-blank" label="Semester" route="semester.*" />
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-4 mb-2">Akademik</p>
                    <x-nav-link href="{{ url('/admin/jadwal-mengajar') }}" icon="ph-clock" label="Jadwal Mengajar" route="jadwal-mengajar.*" />
                    <x-nav-link href="{{ url('/admin/nilai-rapor') }}" icon="ph-file-text" label="Nilai Rapor" route="nilai-rapor.*" />
                    <x-nav-link href="{{ url('/admin/absensi') }}" icon="ph-clipboard-text" label="Absensi" route="absensi.*" />
                    <x-nav-link href="{{ url('/admin/rapor') }}" icon="ph-certificate" label="Rapor" route="rapor.*" />
                    <x-nav-link href="{{ route('admin.kenaikan-kelas') }}" icon="ph-arrow-fat-up" label="Kenaikan Kelas" route="admin.kenaikan-kelas*" />

                @elseif($role === 'guru')
                    @php $guru = \App\Models\Guru::where('user_id', auth()->id())->first(); @endphp
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Guru</p>
                    <x-nav-link href="{{ route('guru.dashboard') }}" icon="ph-chart-bar" label="Dashboard" route="guru.dashboard" />
                    <x-nav-link href="{{ route('guru.jadwal') }}" icon="ph-clock" label="Jadwal Mengajar" route="guru.jadwal" />
                    <x-nav-link href="{{ route('guru.nilai.rekap') }}" icon="ph-file-text" label="Rekap Nilai" route="guru.nilai.*" />
                    @if($guru && \App\Models\Kelas::where('wali_kelas_id', $guru->id)->exists())
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-4 mb-2">Wali Kelas</p>
                    <x-nav-link href="{{ route('guru.wali.index') }}" icon="ph-users" label="Data Siswa" route="guru.wali.index" />
                    <x-nav-link href="{{ route('guru.wali.absensi') }}" icon="ph-clipboard-text" label="Absensi" route="guru.wali.absensi*" />
                    <x-nav-link href="{{ route('guru.wali.rapor') }}" icon="ph-certificate" label="Rapor" route="guru.wali.rapor*" />
                    @endif

                @elseif(in_array($role, ['siswa', 'orang_tua']))
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Siswa / Orang Tua</p>
                    <x-nav-link href="{{ route('siswa.dashboard') }}" icon="ph-chart-bar" label="Dashboard" route="siswa.dashboard" />
                    <x-nav-link href="{{ route('siswa.nilai') }}" icon="ph-file-text" label="Nilai Saya" route="siswa.nilai" />
                    <x-nav-link href="{{ route('siswa.rapor') }}" icon="ph-certificate" label="Rapor Saya" route="siswa.rapor*" />
                @endif

                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-4 mb-2">Akun</p>
                <x-nav-link href="{{ route('profile') }}" icon="ph-user-circle" label="Profil Saya" route="profile*" />
            </nav>

            <div class="p-4 border-t border-gray-200 space-y-1">
                <a href="{{ route('profile') }}" class="flex items-center gap-3 w-full px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition lg:hidden">
                    <i class="ph ph-user-circle text-lg"></i>
                    <span>Profil Saya</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition">
                        <i class="ph ph-sign-out text-lg"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main wrapper --}}
        <div id="main-wrapper" class="lg:pl-64 min-h-screen flex flex-col">
            {{-- Navbar --}}
            <header class="sticky top-0 z-30 flex items-center justify-between h-16 px-4 sm:px-6 bg-white border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        <i class="ph ph-list text-xl"></i>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-800 truncate">@yield('page-title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('profile') }}" class="flex items-center gap-3 group">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition">
                            <i class="ph ph-user text-blue-600 text-sm"></i>
                        </div>
                        <div class="text-sm hidden sm:block">
                            <p class="font-medium text-gray-700 group-hover:text-blue-600 transition">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                    </a>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-x-hidden">
                @include('partials.alert')
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="px-4 sm:px-6 lg:px-8 py-4 border-t border-gray-200 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} MIN 21 Pidie. Smart Academic Dashboard.
            </footer>
        </div>
    </div>

    <script>
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const confirmText = form.getAttribute('data-confirm');
            if (confirmText) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: confirmText,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, lanjutkan!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.removeAttribute('data-confirm');
                        form.submit();
                    }
                });
            }
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden', window.innerWidth < 1024 && !sidebar.classList.contains('-translate-x-full'));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');

            // On resize >= lg, always show sidebar
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        });
    </script>
    @endauth

    @guest
        <main>
            @yield('content')
        </main>
    @endguest

    @stack('scripts')
    @vite('resources/js/app.js')
</body>
</html>