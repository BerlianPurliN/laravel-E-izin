<x-app-layout title="Ubah Pengguna">
    <div class="max-w-2xl">
        <a href="{{ route('admin.pengguna.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <div class="bg-white rounded-xl border border-slate-200 p-6"
             x-data="{ role: '{{ old('role', $user->role) }}' }">
            <h2 class="text-lg font-semibold text-slate-800 mb-6">Ubah Data: {{ $user->name }}</h2>

            <form method="POST" action="{{ route('admin.pengguna.update', $user) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="role" class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                    <select id="role" name="role" x-model="role"
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="siswa" @selected(old('role', $user->role) === 'siswa')>Siswa</option>
                        <option value="guru" @selected(old('role', $user->role) === 'guru')>Guru / Wali Kelas</option>
                    </select>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                           class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                           class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                </div>

                <div class="grid sm:grid-cols-2 gap-4" x-show="role === 'siswa'" x-cloak>
                    <div>
                        <label for="nisn" class="block text-sm font-medium text-slate-700 mb-1">NISN</label>
                        <input id="nisn" name="nisn" type="text" value="{{ old('nisn', $user->student?->nisn) }}"
                               class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="kelas" class="block text-sm font-medium text-slate-700 mb-1">Kelas</label>
                        <input id="kelas" name="kelas" type="text" value="{{ old('kelas', $user->student?->kelas) }}" placeholder="cth: 7A"
                               class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="rounded-lg bg-indigo-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-800">Simpan Perubahan</button>
                    <a href="{{ route('admin.pengguna.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Batal</a>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100">
                <form method="POST" action="{{ route('admin.pengguna.reset-password', $user) }}"
                      onsubmit="return confirm('Reset password {{ $user->name }} menjadi default (password)?')">
                    @csrf @method('PUT')
                    <button type="submit" class="text-sm text-amber-600 hover:underline">Reset password ke default</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
