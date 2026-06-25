<x-app-layout title="Tambah Pengguna">
    <div class="max-w-2xl">
        <a href="{{ route('admin.pengguna.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <div class="bg-white rounded-xl border border-slate-200 p-6" x-data="{ role: '{{ old('role', 'siswa') }}' }">
            <h2 class="text-lg font-semibold text-slate-800 mb-6">Tambah Pengguna Baru</h2>

            <form method="POST" action="{{ route('admin.pengguna.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="role" class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                    <select id="role" name="role" x-model="role"
                            class="block w-full rounded-lg border border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2">
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru / Wali Kelas</option>
                    </select>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}"
                           class="block w-full rounded-lg border border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2"
                           placeholder="cth: Budi Santoso">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                           pattern=".*@smpn6\.sch\.id$"
                           title="Email harus menggunakan domain @smpn6.sch.id"
                           class="block w-full rounded-lg border border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2"
                           placeholder="cth: siswa8@smpn6.sch.id">
                </div>

                <div class="grid sm:grid-cols-2 gap-4" x-show="role === 'siswa'" x-cloak>
                    <div>
                        <label for="nisn" class="block text-sm font-medium text-slate-700 mb-1">NISN</label>
                        <input id="nisn" name="nisn" type="text" value="{{ old('nisn') }}"
                               pattern="[0-9]+" maxlength="10"
                               title="NISN hanya boleh berisi angka"
                               class="block w-full rounded-lg border border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2"
                               placeholder="cth: 1234567890">
                    </div>
                    <div>
                        <label for="kelas" class="block text-sm font-medium text-slate-700 mb-1">Kelas</label>
                        <input id="kelas" name="kelas" type="text" value="{{ old('kelas') }}" placeholder="cth: 7A" maxlength="3"
                               class="block w-full rounded-lg border border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input id="password" name="password" type="text" value="{{ old('password') }}"
                           class="block w-full rounded-lg border border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2"
                           placeholder="Minimal 6 karakter">
                    <p class="mt-1 text-xs text-slate-400">Informasikan password ini ke pengguna. Bisa direset kemudian.</p>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="rounded-lg bg-indigo-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-800">Simpan</button>
                    <a href="{{ route('admin.pengguna.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
