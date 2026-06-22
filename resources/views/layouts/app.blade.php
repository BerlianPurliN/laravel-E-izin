@php
    $user = auth()->user();
    $menus = [
        'siswa' => [
            ['route' => 'siswa.dashboard', 'label' => 'Dashboard', 'pattern' => 'siswa.dashboard', 'icon' => 'M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3v-6h6v6h3a1 1 0 001-1V10'],
            ['route' => 'siswa.izin.create', 'label' => 'Ajukan Izin', 'pattern' => 'siswa.izin.create', 'icon' => 'M12 4v16m8-8H4'],
            ['route' => 'siswa.izin.index', 'label' => 'Riwayat Izin', 'pattern' => 'siswa.izin.index', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ],
        'guru' => [
            ['route' => 'guru.dashboard', 'label' => 'Dashboard', 'pattern' => 'guru.dashboard', 'icon' => 'M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3v-6h6v6h3a1 1 0 001-1V10'],
            ['route' => 'guru.persetujuan.index', 'label' => 'Persetujuan Izin', 'pattern' => 'guru.persetujuan.*', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ],
        'admin' => [
            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'pattern' => 'admin.dashboard', 'icon' => 'M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3v-6h6v6h3a1 1 0 001-1V10'],
            ['route' => 'admin.pengguna.index', 'label' => 'Kelola Pengguna', 'pattern' => 'admin.pengguna.*', 'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4z'],
            ['route' => 'admin.rekap.index', 'label' => 'Rekapitulasi', 'pattern' => 'admin.rekap.*', 'icon' => 'M9 17v-6h2v6m4 0V7h2v10M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z'],
        ],
    ];
    $menu = $menus[$user->role] ?? [];
    $roleLabel = ['admin' => 'Admin / Tata Usaha', 'guru' => 'Guru / Wali Kelas', 'siswa' => 'Siswa'][$user->role] ?? $user->role;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ($title ?? '') ? $title.' — ' : '' }}E-Izin SMPN 6 Surabaya</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Figtree', 'ui-sans-serif', 'system-ui', 'sans-serif'] } } }
        };
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-800">
<div x-data="{ sidebarOpen: false }" class="min-h-screen lg:flex">

    <!-- Overlay (mobile) -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 z-20 bg-slate-900/50 lg:hidden"></div>

    <!-- Sidebar -->
    <aside x-cloak
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-30 w-64 bg-indigo-800 text-indigo-100 transform transition-transform duration-200 lg:translate-x-0 lg:static lg:inset-auto lg:z-auto flex flex-col">
        <div class="h-16 flex items-center gap-2 px-5 border-b border-indigo-700">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.42A12 12 0 0112 21a12 12 0 01-6.16-10.42L12 14z" />
            </svg>
            <div class="leading-tight">
                <p class="text-white font-semibold text-sm">E-Izin</p>
                <p class="text-indigo-300 text-xs">SMPN 6 Surabaya</p>
            </div>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            @foreach ($menu as $item)
                @php $active = request()->routeIs($item['pattern']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                          {{ $active ? 'bg-white text-indigo-800 shadow' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="p-3 border-t border-indigo-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-indigo-100 hover:bg-indigo-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top bar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-10">
            <div class="flex items-center gap-3 min-w-0">
                <button @click="sidebarOpen = true" class="lg:hidden text-slate-500 hover:text-slate-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-slate-800 truncate">{{ $title ?? 'Dashboard' }}</h1>
            </div>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 text-sm">
                    <span class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-semibold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                    <span class="hidden sm:block text-left leading-tight">
                        <span class="block font-medium text-slate-700">{{ $user->name }}</span>
                        <span class="block text-xs text-slate-400">{{ $roleLabel }}</span>
                    </span>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-cloak @click.outside="open = false"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-100 py-1">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">Profil & Password</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-slate-50">Keluar</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 sm:p-6">
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <p class="font-medium mb-1">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>
<style>[x-cloak]{display:none !important;}</style>
</body>
</html>
