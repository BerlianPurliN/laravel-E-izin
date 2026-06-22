<x-app-layout title="Kelola Pengguna">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
        <div class="flex flex-wrap gap-2">
            @foreach (['' => 'Semua', 'guru' => 'Guru', 'siswa' => 'Siswa'] as $key => $label)
                <a href="{{ route('admin.pengguna.index', array_filter(['role' => $key])) }}"
                   class="px-3 py-1.5 rounded-lg text-sm font-medium border
                          {{ ($role ?? '') === $key ? 'bg-indigo-700 text-white border-indigo-700' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
        <a href="{{ route('admin.pengguna.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-700 text-white text-sm font-medium rounded-lg px-4 py-2 hover:bg-indigo-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pengguna
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-left">
                    <tr>
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium">Email</th>
                        <th class="px-5 py-3 font-medium">Role</th>
                        <th class="px-5 py-3 font-medium">NISN / Kelas</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $u)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-medium text-slate-800">{{ $u->name }}</td>
                            <td class="px-5 py-3 text-slate-600">{{ $u->email }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $u->role === 'guru' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ ucfirst($u->role) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-slate-600">
                                @if ($u->student)
                                    {{ $u->student->nisn }} · {{ $u->student->kelas }}
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.pengguna.edit', $u) }}" class="text-indigo-600 hover:underline">Ubah</a>

                                    <form method="POST" action="{{ route('admin.pengguna.reset-password', $u) }}"
                                          onsubmit="return confirm('Reset password {{ $u->name }} menjadi default (password)?')">
                                        @csrf @method('PUT')
                                        <button type="submit" class="text-amber-600 hover:underline">Reset Pass</button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.pengguna.destroy', $u) }}"
                                          onsubmit="return confirm('Hapus {{ $u->name }} beserta seluruh data izinnya?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</x-app-layout>
