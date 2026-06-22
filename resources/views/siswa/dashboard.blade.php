<x-app-layout title="Dashboard">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-slate-800">Halo, {{ auth()->user()->name }} 👋</h2>
        <p class="text-sm text-slate-500">
            @if ($student)
                NISN {{ $student->nisn }} · Kelas {{ $student->kelas }}
            @else
                Akun Anda belum terhubung dengan data siswa. Hubungi Tata Usaha.
            @endif
        </p>
    </div>

    <!-- Stat cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach ([
            ['Total Izin', $total, 'bg-slate-100 text-slate-700'],
            ['Menunggu', $pending, 'bg-amber-100 text-amber-700'],
            ['Diterima', $approved, 'bg-green-100 text-green-700'],
            ['Ditolak', $rejected, 'bg-red-100 text-red-700'],
        ] as [$label, $value, $color])
            <div class="bg-white rounded-xl border border-slate-200 p-4">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg {{ $color }} text-sm font-bold mb-3">
                    {{ $value }}
                </span>
                <p class="text-sm text-slate-500">{{ $label }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Quick action -->
        <div class="bg-indigo-700 rounded-xl p-6 text-white flex flex-col justify-between">
            <div>
                <h3 class="font-semibold text-lg">Ajukan Izin Baru</h3>
                <p class="text-indigo-200 text-sm mt-1">Sakit atau ada keperluan? Ajukan izin secara online.</p>
            </div>
            <a href="{{ route('siswa.izin.create') }}"
               class="mt-4 inline-flex items-center gap-2 bg-white text-indigo-700 font-medium text-sm rounded-lg px-4 py-2 hover:bg-indigo-50 w-max">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Buat Pengajuan
            </a>
        </div>

        <!-- Recent -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800">Izin Terbaru</h3>
                <a href="{{ route('siswa.izin.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat semua</a>
            </div>
            <ul class="divide-y divide-slate-100">
                @forelse ($latest as $izin)
                    <li>
                        <a href="{{ route('siswa.izin.show', $izin) }}" class="flex items-center justify-between px-5 py-3 hover:bg-slate-50">
                            <div>
                                <p class="text-sm font-medium text-slate-800">{{ $izin->jenis_izin }}</p>
                                <p class="text-xs text-slate-500">
                                    {{ $izin->tanggal_mulai->format('d M Y') }} – {{ $izin->tanggal_selesai->format('d M Y') }}
                                </p>
                            </div>
                            <x-status-badge :status="$izin->status" />
                        </a>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-slate-400">Belum ada pengajuan izin.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
