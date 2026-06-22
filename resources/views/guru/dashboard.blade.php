<x-app-layout title="Dashboard">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-slate-800">Selamat datang, {{ auth()->user()->name }}</h2>
        <p class="text-sm text-slate-500">Ringkasan permohonan izin siswa.</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach ([
            ['Menunggu Hari Ini', $pendingToday, 'text-amber-700 bg-amber-100'],
            ['Total Menunggu', $totalPending, 'text-indigo-700 bg-indigo-100'],
            ['Disetujui', $approved, 'text-green-700 bg-green-100'],
            ['Ditolak', $rejected, 'text-red-700 bg-red-100'],
        ] as [$label, $value, $color])
            <div class="bg-white rounded-xl border border-slate-200 p-4">
                <span class="inline-flex items-center justify-center min-w-9 h-9 px-2 rounded-lg {{ $color }} text-sm font-bold mb-3">{{ $value }}</span>
                <p class="text-sm text-slate-500">{{ $label }}</p>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl border border-slate-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800">Menunggu Verifikasi</h3>
            <a href="{{ route('guru.persetujuan.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat semua</a>
        </div>
        <ul class="divide-y divide-slate-100">
            @forelse ($recent as $izin)
                <li>
                    <a href="{{ route('guru.persetujuan.show', $izin) }}" class="flex items-center justify-between px-5 py-3 hover:bg-slate-50">
                        <div>
                            <p class="text-sm font-medium text-slate-800">
                                {{ $izin->student?->user?->name ?? 'Siswa' }}
                                <span class="text-slate-400 font-normal">· {{ $izin->student?->kelas }}</span>
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ $izin->jenis_izin }} · {{ $izin->tanggal_mulai->format('d M') }} – {{ $izin->tanggal_selesai->format('d M Y') }}
                            </p>
                        </div>
                        <span class="text-sm text-indigo-600">Proses →</span>
                    </a>
                </li>
            @empty
                <li class="px-5 py-10 text-center text-sm text-slate-400">Tidak ada permohonan yang menunggu. 🎉</li>
            @endforelse
        </ul>
    </div>
</x-app-layout>
