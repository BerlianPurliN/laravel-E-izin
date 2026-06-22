<x-app-layout title="Detail Izin">
    <div class="max-w-2xl">
        <a href="{{ route('siswa.izin.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Riwayat
        </a>

        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800">Izin {{ $izin->jenis_izin }}</h2>
                <x-status-badge :status="$izin->status" />
            </div>

            <dl class="divide-y divide-slate-100 text-sm">
                <div class="px-6 py-3 grid grid-cols-3 gap-4">
                    <dt class="text-slate-500">Periode</dt>
                    <dd class="col-span-2 text-slate-800">
                        {{ $izin->tanggal_mulai->format('d M Y') }} – {{ $izin->tanggal_selesai->format('d M Y') }}
                        <span class="text-slate-400">({{ $izin->durationInDays() }} hari)</span>
                    </dd>
                </div>
                <div class="px-6 py-3 grid grid-cols-3 gap-4">
                    <dt class="text-slate-500">Alasan</dt>
                    <dd class="col-span-2 text-slate-800">{{ $izin->alasan }}</dd>
                </div>
                <div class="px-6 py-3 grid grid-cols-3 gap-4">
                    <dt class="text-slate-500">Bukti Lampiran</dt>
                    <dd class="col-span-2">
                        @if ($izin->bukti_lampiran)
                            <a href="{{ Storage::url($izin->bukti_lampiran) }}" target="_blank"
                               class="inline-flex items-center gap-1 text-indigo-600 hover:underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                Lihat lampiran
                            </a>
                        @else
                            <span class="text-slate-400">Tidak ada lampiran</span>
                        @endif
                    </dd>
                </div>
                <div class="px-6 py-3 grid grid-cols-3 gap-4">
                    <dt class="text-slate-500">Diajukan</dt>
                    <dd class="col-span-2 text-slate-800">{{ $izin->created_at->format('d M Y H:i') }}</dd>
                </div>
                @if (! $izin->isPending())
                    <div class="px-6 py-3 grid grid-cols-3 gap-4">
                        <dt class="text-slate-500">Diproses oleh</dt>
                        <dd class="col-span-2 text-slate-800">{{ $izin->approver?->name ?? '—' }}</dd>
                    </div>
                    <div class="px-6 py-3 grid grid-cols-3 gap-4">
                        <dt class="text-slate-500">Catatan Guru</dt>
                        <dd class="col-span-2 text-slate-800">{{ $izin->catatan_guru ?: '—' }}</dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>
</x-app-layout>
