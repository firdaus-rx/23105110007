@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <i class="ph ph-book-open text-5xl text-blue-600 mb-4 inline-block"></i>
            <h1 class="text-2xl font-bold text-gray-800">Smart Academic</h1>
            <p class="text-gray-500 mt-1">MIN 21 Pidie</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Masuk ke Akun Anda</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <i class="ph ph-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm"
                            placeholder="Masukkan email">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <i class="ph ph-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" name="password" required
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm"
                            placeholder="Masukkan password">
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition text-sm">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
