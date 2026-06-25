<x-guest-layout>
    <h2 class="text-lg font-semibold text-slate-800 mb-1">Masuk ke Akun Anda</h2>
    <p class="text-sm text-slate-500 mb-6">Gunakan NISN (siswa) atau email untuk masuk.</p>

    @if (session('status'))
    <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-2 text-sm text-green-800">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="login" class="block text-sm font-medium text-slate-700 mb-1">NISN atau Email</label>
            <input id="login" name="login" type="text" value="{{ old('login') }}" required autofocus
                autocomplete="username"
                class="block w-full rounded-lg border border-indigo-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-1"
                placeholder="siswa@smpn6.sch.id">
            @error('login')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <div class="relative">
                <input id="password" name="password" type="password" required autocomplete="current-password"
                    class="block w-full rounded-lg border border-indigo-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm pr-24 py-1"
                    placeholder="••••••••">
                <button type="button" onclick="const password = document.getElementById('password'); password.type = password.type === 'password' ? 'text' : 'password'; this.textContent = password.type === 'password' ? 'Tampilkan' : 'Sembunyikan';"
                    class="absolute inset-y-0 right-0 m-1 rounded-lg bg-slate-100 px-3 text-xs font-medium text-slate-600 hover:bg-slate-200 transition">
                    Tampilkan
                </button>
            </div>
            @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <label for="remember" class="flex items-center gap-2 text-sm text-slate-600">
            <input id="remember" type="checkbox" name="remember"
                class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            Ingat saya
        </label>

        <button type="submit"
            class="w-full inline-flex justify-center items-center rounded-lg bg-indigo-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
            Masuk
        </button>
    </form>


    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-200"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-white px-3 text-xs text-slate-400">Belum punya akun?</span>
        </div>
    </div>

    <a href="https://wa.me/6285648528427?text=Halo%20admin,%20saya%20ingin%20melakukan%20registrasi%20e-izin" target="_blank" rel="noopener"
        class="w-full inline-flex justify-center items-center gap-2 rounded-lg border border-green-600 bg-green-50 px-4 py-2.5 text-sm font-semibold text-green-700 hover:bg-green-100 transition">
        Registrasi via WhatsApp
    </a>
    <p class="mt-3 text-center text-xs text-slate-400">Akun siswa dibuat oleh Admin. Hubungi admin untuk registrasi.</p>
</x-guest-layout>