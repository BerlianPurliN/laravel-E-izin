<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — E-Izin SMPN 6 Surabaya</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Figtree', 'ui-sans-serif', 'system-ui', 'sans-serif'] } } }
        };
    </script>
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-700 to-indigo-900 p-4">
    <div class="w-full max-w-md">
        <div class="text-center text-white mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 mb-3">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.42A12 12 0 0112 21a12 12 0 01-6.16-10.42L12 14z" />
                </svg>
            </div>
            <h1 class="text-2xl font-semibold">E-Izin SMPN 6 Surabaya</h1>
            <p class="text-indigo-200 text-sm mt-1">Sistem Perizinan Siswa Digital</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl px-6 py-8 sm:px-8">
            {{ $slot }}
        </div>

        <p class="text-center text-indigo-200 text-xs mt-6">&copy; {{ date('Y') }} SMP Negeri 6 Surabaya</p>
    </div>
</body>
</html>
