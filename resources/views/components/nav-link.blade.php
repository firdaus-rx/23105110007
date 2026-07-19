@props(['href', 'icon', 'label'])

@php
    $currentUrl = url()->current();
    $isActive = $currentUrl === $href || $currentUrl === url($href) || request()->is(trim(parse_url($href, PHP_URL_PATH) ?: $href, '/') . '*');
@endphp

<a href="{{ $href }}" class="flex items-center gap-3 px-3 py-2.5 text-sm rounded-lg transition {{ $isActive ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-800' }}"
   onclick="if(window.innerWidth < 1024) { document.getElementById('sidebar').classList.add('-translate-x-full'); document.getElementById('sidebar-backdrop').classList.add('hidden'); }">
    <i class="ph {{ $icon }} text-lg {{ $isActive ? 'text-blue-600' : '' }}"></i>
    <span>{{ $label }}</span>
</a>