<x-app-layout title="Ajukan Izin">
    <div class="max-w-2xl">
        <a href="{{ route('siswa.izin.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-1">Form Pengajuan Izin</h2>
            <p class="text-sm text-slate-500 mb-6">Lengkapi data berikut. Pengajuan akan diverifikasi oleh guru.</p>

            <form method="POST" action="{{ route('siswa.izin.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label for="jenis_izin" class="block text-sm font-medium text-slate-700 mb-1">Jenis Izin</label>
                    <select id="jenis_izin" name="jenis_izin"
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="Sakit" @selected(old('jenis_izin') === 'Sakit')>Sakit</option>
                        <option value="Izin" @selected(old('jenis_izin') === 'Izin')>Izin (keperluan lain)</option>
                    </select>
                    @error('jenis_izin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-slate-700 mb-1">Tanggal Mulai</label>
                        <input id="tanggal_mulai" name="tanggal_mulai" type="date" value="{{ old('tanggal_mulai', date('Y-m-d')) }}"
                               class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error('tanggal_mulai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-slate-700 mb-1">Tanggal Selesai</label>
                        <input id="tanggal_selesai" name="tanggal_selesai" type="date" value="{{ old('tanggal_selesai', date('Y-m-d')) }}"
                               class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error('tanggal_selesai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="alasan" class="block text-sm font-medium text-slate-700 mb-1">Alasan</label>
                    <textarea id="alasan" name="alasan" rows="4"
                              class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                              placeholder="Jelaskan alasan izin...">{{ old('alasan') }}</textarea>
                    @error('alasan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="bukti_lampiran" class="block text-sm font-medium text-slate-700 mb-1">
                        Bukti Lampiran <span class="text-slate-400 font-normal">(opsional)</span>
                    </label>
                    <input id="bukti_lampiran" name="bukti_lampiran" type="file" accept=".jpg,.jpeg,.png,.pdf"
                           class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-1 text-xs text-slate-400">Misal foto surat dokter. Format: JPG, PNG, PDF. Maks 2 MB.</p>
                    @error('bukti_lampiran') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="inline-flex items-center rounded-lg bg-indigo-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-800">
                        Kirim Pengajuan
                    </button>
                    <a href="{{ route('siswa.izin.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
