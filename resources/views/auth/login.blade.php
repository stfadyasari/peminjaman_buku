<x-guest-layout>
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-cyan-700">Selamat Datang</p>
        <h2 class="mt-2 text-[2rem] font-bold tracking-tight text-slate-900">Masuk ke akun Anda</h2>
        <p class="mt-2 text-sm text-slate-500">Gunakan akun terdaftar untuk mengakses dashboard perpustakaan.</p>
    </div>

    <div class="mt-5 rounded-xl border border-cyan-100 bg-cyan-50/60 px-4 py-3 text-sm text-cyan-900">
        Login aman untuk admin dan peminjam dengan akses sesuai peran.
    </div>

    <x-auth-session-status class="mt-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="email" class="mt-2 block w-full rounded-lg border-slate-300 bg-white px-4 py-3.5 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-600" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="password" class="mt-2 block w-full rounded-lg border-slate-300 bg-white px-4 py-3.5 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600"
                type="password"
                name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-rose-600" />
        </div>

        <div class="flex items-center justify-between gap-3">
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-cyan-600 shadow-sm focus:ring-cyan-500" name="remember">
                Ingat saya
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-cyan-700 transition hover:text-cyan-800" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-gradient-to-r from-cyan-700 to-sky-700 px-4 py-3.5 text-sm font-semibold text-white transition hover:brightness-105">
            Masuk
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-semibold text-cyan-700 hover:text-cyan-800">Daftar sekarang</a>
    </p>
</x-guest-layout>
