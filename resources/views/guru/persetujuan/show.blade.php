<x-app-layout title="Detail Permohonan">
    <div class="max-w-3xl">
        <a href="{{ route('guru.persetujuan.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Detail -->
            <div class="md:col-span-2 bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-800">Detail Izin</h2>
                    <x-status-badge :status="$izin->status" />
                </div>
                <dl class="divide-y divide-slate-100 text-sm">
                    <div class="px-6 py-3 grid grid-cols-3 gap-4">
                        <dt class="text-slate-500">Nama Siswa</dt>
                        <dd class="col-span-2 font-medium text-slate-800">{{ $izin->student?->user?->name ?? '—' }}</dd>
                    </div>
                    <div class="px-6 py-3 grid grid-cols-3 gap-4">
                        <dt class="text-slate-500">NISN · Kelas</dt>
                        <dd class="col-span-2 text-slate-800">{{ $izin->student?->nisn }} · {{ $izin->student?->kelas }}</dd>
                    </div>
                    <div class="px-6 py-3 grid grid-cols-3 gap-4">
                        <dt class="text-slate-500">Jenis Izin</dt>
                        <dd class="col-span-2 text-slate-800">{{ $izin->jenis_izin }}</dd>
                    </div>
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
                        <dt class="text-slate-500">Bukti</dt>
                        <dd class="col-span-2">
                            @if ($izin->bukti_lampiran)
                                <a href="{{ Storage::url($izin->bukti_lampiran) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat lampiran</a>
                            @else
                                <span class="text-slate-400">Tidak ada</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Action -->
            <div class="bg-white rounded-xl border border-slate-200 p-5 h-max">
                @if ($izin->isPending())
                    <h3 class="font-semibold text-slate-800 mb-3">Verifikasi</h3>
                    <form method="POST" action="{{ route('guru.persetujuan.update', $izin) }}" class="space-y-3">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label for="catatan_guru" class="block text-sm font-medium text-slate-700 mb-1">Catatan <span class="text-slate-400 font-normal">(opsional)</span></label>
                            <textarea id="catatan_guru" name="catatan_guru" rows="3"
                                      class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                      placeholder="Catatan untuk siswa...">{{ old('catatan_guru') }}</textarea>
                        </div>
                        <button type="submit" name="action" value="approve"
                                class="w-full rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700">
                            Setujui
                        </button>
                        <button type="submit" name="action" value="reject"
                                class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">
                            Tolak
                        </button>
                    </form>
                @else
                    <h3 class="font-semibold text-slate-800 mb-3">Hasil Verifikasi</h3>
                    <div class="text-sm space-y-2">
                        <p><span class="text-slate-500">Status:</span> <x-status-badge :status="$izin->status" /></p>
                        <p><span class="text-slate-500">Diproses oleh:</span> {{ $izin->approver?->name ?? '—' }}</p>
                        <p><span class="text-slate-500">Catatan:</span> {{ $izin->catatan_guru ?: '—' }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
