<x-guest-layout>
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-cyan-700">Buat Akun</p>
        <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Registrasi peminjam</h2>
        <p class="mt-2 text-sm text-slate-500">Lengkapi data berikut untuk mulai menggunakan layanan perpustakaan digital.</p>
    </div>

    <div class="mt-5 rounded-xl border border-cyan-100 bg-cyan-50/60 px-4 py-3 text-sm text-cyan-900">
        Pastikan email aktif agar notifikasi status peminjaman dapat diterima.
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="name" class="mt-2 block w-full rounded-lg border-slate-300 bg-white px-4 py-3 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-rose-600" />
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-slate-700" />
                <x-text-input id="email" class="mt-2 block w-full rounded-lg border-slate-300 bg-white px-4 py-3 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-600" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('No. Telepon')" class="text-sm font-semibold text-slate-700" />
                <x-text-input id="phone" class="mt-2 block w-full rounded-lg border-slate-300 bg-white px-4 py-3 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600" type="text" name="phone" :value="old('phone')" autocomplete="tel" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2 text-xs text-rose-600" />
            </div>
        </div>

        <div>
            <x-input-label for="address" :value="__('Alamat')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="address" class="mt-2 block w-full rounded-lg border-slate-300 bg-white px-4 py-3 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600" type="text" name="address" :value="old('address')" autocomplete="street-address" />
            <x-input-error :messages="$errors->get('address')" class="mt-2 text-xs text-rose-600" />
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-slate-700" />
                <x-text-input id="password" class="mt-2 block w-full rounded-lg border-slate-300 bg-white px-4 py-3 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-rose-600" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-sm font-semibold text-slate-700" />
                <x-text-input id="password_confirmation" class="mt-2 block w-full rounded-lg border-slate-300 bg-white px-4 py-3 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600"
                    type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-rose-600" />
            </div>
        </div>

        <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-gradient-to-r from-cyan-700 to-sky-700 px-4 py-3 text-sm font-semibold text-white transition hover:brightness-105">
            Daftar Akun
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-semibold text-cyan-700 hover:text-cyan-800">Masuk di sini</a>
    </p>
</x-guest-layout>
