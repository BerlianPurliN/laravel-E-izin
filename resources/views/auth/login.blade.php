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
                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                placeholder="cth: 0071234567 atau nama@smpn6.sch.id">
            @error('login')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                placeholder="••••••••">
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

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-green-600">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.4 0 11.948 0c3.174.001 6.157 1.237 8.4 3.483 2.243 2.246 3.476 5.23 3.475 8.406-.003 6.591-5.343 11.94-11.938 11.94-2.003-.001-3.973-.507-5.729-1.472L0 24zm6.59-4.846c1.657.983 3.284 1.492 4.974 1.493 5.432 0 9.865-4.437 9.867-9.872.001-2.632-1.021-5.105-2.88-6.967-1.858-1.861-4.331-2.883-6.969-2.884-5.441 0-9.876 4.439-9.879 9.874-.001 2.012.528 3.98 1.533 5.71L2.242 21.75l5.405-1.417zm12.336-7.234c-.316-.158-1.872-.924-2.162-1.027-.29-.105-.502-.158-.713.158-.21.314-.818 1.027-1.003 1.238-.185.21-.37.237-.686.08-1.748-.874-2.87-1.428-4.016-3.393-.301-.518.301-.48.86-1.597.094-.188.048-.353-.024-.51-.072-.158-.713-1.716-.977-2.351-.257-.616-.519-.533-.713-.543-.185-.01-.397-.012-.609-.012-.211 0-.555.08-.846.397-.29.314-1.11 1.084-1.11 2.644 0 1.559 1.135 3.067 1.294 3.278.158.21 2.235 3.413 5.413 4.787.756.327 1.347.523 1.81.67.76.241 1.451.207 1.996.126.608-.09 1.872-.765 2.137-1.467.264-.702.264-1.303.185-1.427-.08-.124-.29-.197-.607-.355z" />
        </svg>

        Registrasi via WhatsApp
    </a>
    <p class="mt-3 text-center text-xs text-slate-400">Akun siswa dibuat oleh Admin. Hubungi admin untuk registrasi.</p>
</x-guest-layout>