<header class="sticky top-0 z-40 flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200">
    <div>
        <h2 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
    </div>

    <div class="flex items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="ph ph-user text-blue-600 text-sm"></i>
            </div>
            <div class="text-sm">
                <p class="font-medium text-gray-700">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400 capitalize">{{ Auth::user()->role }}</p>
            </div>
        </div>
    </div>
</header>
