<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Academic - MIN 21 Pidie</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-blue-50 min-h-screen">
    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <div class="text-center max-w-2xl">
            <i class="ph ph-book-open text-7xl text-blue-600 mb-6 inline-block"></i>
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Smart Academic</h1>
            <p class="text-xl text-gray-600 mb-2">Sistem Pengelolaan Nilai Rapor Siswa</p>
            <p class="text-gray-500 mb-8">MIN 21 Pidie</p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                    <i class="ph ph-sign-in mr-2"></i>Masuk
                </a>
            </div>
        </div>

        <div class="mt-16 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} MIN 21 Pidie. All rights reserved.
        </div>
    </div>
</body>
</html>
