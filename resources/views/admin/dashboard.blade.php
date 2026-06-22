<x-app-layout title="Dashboard">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-slate-800">Dashboard Admin / Tata Usaha</h2>
        <p class="text-sm text-slate-500">Ringkasan perizinan bulan {{ now()->translatedFormat('F Y') }}.</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach ([
            ['Izin Bulan Ini', $totalMonth, 'text-indigo-700 bg-indigo-100'],
            ['Menunggu', $pending, 'text-amber-700 bg-amber-100'],
            ['Disetujui', $approved, 'text-green-700 bg-green-100'],
            ['Ditolak', $rejected, 'text-red-700 bg-red-100'],
        ] as [$label, $value, $color])
            <div class="bg-white rounded-xl border border-slate-200 p-4">
                <span class="inline-flex items-center justify-center min-w-9 h-9 px-2 rounded-lg {{ $color }} text-sm font-bold mb-3">{{ $value }}</span>
                <p class="text-sm text-slate-500">{{ $label }}</p>
            </div>
        @endforeach
    </div>

    <!-- Simple status bar chart -->
    @php $maxBar = max(1, $pending, $approved, $rejected); @endphp
    <div class="grid lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 p-5">
            <h3 class="font-semibold text-slate-800 mb-4">Distribusi Status Izin</h3>
            <div class="space-y-3 text-sm">
                @foreach ([['Menunggu', $pending, 'bg-amber-400'], ['Disetujui', $approved, 'bg-green-500'], ['Ditolak', $rejected, 'bg-red-500']] as [$label, $value, $bar])
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-slate-600">{{ $label }}</span>
                            <span class="font-medium text-slate-800">{{ $value }}</span>
                        </div>
                        <div class="h-2.5 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full {{ $bar }} rounded-full" style="width: {{ round($value / $maxBar * 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 flex flex-col justify-center gap-4">
            <div class="flex items-center gap-3">
                <span class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">{{ $totalStudents }}</span>
                <div><p class="text-sm font-medium text-slate-800">Siswa Terdaftar</p></div>
            </div>
            <div class="flex items-center gap-3">
                <span class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">{{ $totalGuru }}</span>
                <div><p class="text-sm font-medium text-slate-800">Guru / Wali Kelas</p></div>
            </div>
            <a href="{{ route('admin.rekap.index') }}" class="mt-2 text-sm text-indigo-600 hover:underline">Lihat rekapitulasi lengkap →</a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800">Aktivitas Izin Terbaru</h3>
            <a href="{{ route('admin.rekap.index') }}" class="text-sm text-indigo-600 hover:underline">Rekap</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-left">
                    <tr>
                        <th class="px-5 py-3 font-medium">Siswa</th>
                        <th class="px-5 py-3 font-medium">Kelas</th>
                        <th class="px-5 py-3 font-medium">Jenis</th>
                        <th class="px-5 py-3 font-medium">Tanggal</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recent as $izin)
                        <tr>
                            <td class="px-5 py-3 font-medium text-slate-800">{{ $izin->student?->user?->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-slate-600">{{ $izin->student?->kelas ?? '—' }}</td>
                            <td class="px-5 py-3 text-slate-600">{{ $izin->jenis_izin }}</td>
                            <td class="px-5 py-3 text-slate-600 whitespace-nowrap">{{ $izin->tanggal_mulai->format('d M Y') }}</td>
                            <td class="px-5 py-3"><x-status-badge :status="$izin->status" /></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada data izin.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
