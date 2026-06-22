<x-app-layout title="Riwayat Izin">
    <div class="flex items-center justify-between mb-5">
        <p class="text-sm text-slate-500">Daftar seluruh pengajuan izin yang pernah Anda buat.</p>
        <a href="{{ route('siswa.izin.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-700 text-white text-sm font-medium rounded-lg px-4 py-2 hover:bg-indigo-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Ajukan Izin
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-left">
                    <tr>
                        <th class="px-5 py-3 font-medium">Jenis</th>
                        <th class="px-5 py-3 font-medium">Tanggal</th>
                        <th class="px-5 py-3 font-medium">Alasan</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($requests as $izin)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-medium text-slate-800">{{ $izin->jenis_izin }}</td>
                            <td class="px-5 py-3 text-slate-600 whitespace-nowrap">
                                {{ $izin->tanggal_mulai->format('d M Y') }}<br>
                                <span class="text-xs text-slate-400">s/d {{ $izin->tanggal_selesai->format('d M Y') }}</span>
                            </td>
                            <td class="px-5 py-3 text-slate-600 max-w-xs truncate">{{ $izin->alasan }}</td>
                            <td class="px-5 py-3"><x-status-badge :status="$izin->status" /></td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('siswa.izin.show', $izin) }}" class="text-indigo-600 hover:underline">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada pengajuan izin.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $requests->links() }}</div>
</x-app-layout>
