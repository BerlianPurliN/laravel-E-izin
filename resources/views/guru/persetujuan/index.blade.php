<x-app-layout title="Persetujuan Izin">
    <p class="text-sm text-slate-500 mb-4">Daftar permohonan izin yang masuk dari siswa.</p>

    <!-- Filter tabs -->
    <div class="flex flex-wrap gap-2 mb-4">
        @foreach (['Pending' => 'Menunggu', 'Approved' => 'Disetujui', 'Rejected' => 'Ditolak', 'all' => 'Semua'] as $key => $label)
            <a href="{{ route('guru.persetujuan.index', ['status' => $key]) }}"
               class="px-3 py-1.5 rounded-lg text-sm font-medium border
                      {{ $status === $key ? 'bg-indigo-700 text-white border-indigo-700' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-left">
                    <tr>
                        <th class="px-5 py-3 font-medium">Siswa</th>
                        <th class="px-5 py-3 font-medium">Kelas</th>
                        <th class="px-5 py-3 font-medium">Jenis</th>
                        <th class="px-5 py-3 font-medium">Periode</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($requests as $izin)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-medium text-slate-800">{{ $izin->student?->user?->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-slate-600">{{ $izin->student?->kelas ?? '—' }}</td>
                            <td class="px-5 py-3 text-slate-600">{{ $izin->jenis_izin }}</td>
                            <td class="px-5 py-3 text-slate-600 whitespace-nowrap">
                                {{ $izin->tanggal_mulai->format('d M') }} – {{ $izin->tanggal_selesai->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3"><x-status-badge :status="$izin->status" /></td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('guru.persetujuan.show', $izin) }}"
                                   class="inline-flex items-center rounded-lg bg-indigo-50 text-indigo-700 font-medium px-3 py-1.5 hover:bg-indigo-100">
                                    {{ $izin->isPending() ? 'Proses' : 'Detail' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-slate-400">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $requests->links() }}</div>
</x-app-layout>
