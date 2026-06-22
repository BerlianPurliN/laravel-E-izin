<x-app-layout title="Rekapitulasi">
    <p class="text-sm text-slate-500 mb-4">Rekap seluruh perizinan siswa. Gunakan filter lalu ekspor ke CSV bila perlu.</p>

    <!-- Filter -->
    <form method="GET" action="{{ route('admin.rekap.index') }}"
          class="bg-white rounded-xl border border-slate-200 p-4 mb-4 grid sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
        <div>
            <label for="kelas" class="block text-xs font-medium text-slate-500 mb-1">Kelas</label>
            <select id="kelas" name="kelas" class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Semua</option>
                @foreach ($kelasList as $kelas)
                    <option value="{{ $kelas }}" @selected(($filters['kelas'] ?? '') === $kelas)>{{ $kelas }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status" class="block text-xs font-medium text-slate-500 mb-1">Status</label>
            <select id="status" name="status" class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Semua</option>
                @foreach (['Pending' => 'Menunggu', 'Approved' => 'Diterima', 'Rejected' => 'Ditolak'] as $val => $lbl)
                    <option value="{{ $val }}" @selected(($filters['status'] ?? '') === $val)>{{ $lbl }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="dari" class="block text-xs font-medium text-slate-500 mb-1">Dari Tanggal</label>
            <input id="dari" name="dari" type="date" value="{{ $filters['dari'] ?? '' }}"
                   class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <label for="sampai" class="block text-xs font-medium text-slate-500 mb-1">Sampai Tanggal</label>
            <input id="sampai" name="sampai" type="date" value="{{ $filters['sampai'] ?? '' }}"
                   class="block w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 rounded-lg bg-indigo-700 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-800">Filter</button>
            <a href="{{ route('admin.rekap.index') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">Reset</a>
        </div>
    </form>

    <div class="flex justify-end mb-3">
        <a href="{{ route('admin.rekap.export', request()->query()) }}"
           class="inline-flex items-center gap-2 rounded-lg bg-green-600 text-white text-sm font-medium px-4 py-2 hover:bg-green-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M4 4h16v16H4z" />
            </svg>
            Ekspor CSV
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-left">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama</th>
                        <th class="px-4 py-3 font-medium">NISN</th>
                        <th class="px-4 py-3 font-medium">Kelas</th>
                        <th class="px-4 py-3 font-medium">Jenis</th>
                        <th class="px-4 py-3 font-medium">Periode</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium">Diproses Oleh</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($requests as $izin)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $izin->student?->user?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $izin->student?->nisn ?? '—' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $izin->student?->kelas ?? '—' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $izin->jenis_izin }}</td>
                            <td class="px-4 py-3 text-slate-600 whitespace-nowrap">
                                {{ $izin->tanggal_mulai->format('d M') }} – {{ $izin->tanggal_selesai->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3"><x-status-badge :status="$izin->status" /></td>
                            <td class="px-4 py-3 text-slate-600">{{ $izin->approver?->name ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-10 text-center text-slate-400">Tidak ada data sesuai filter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $requests->links() }}</div>
</x-app-layout>
