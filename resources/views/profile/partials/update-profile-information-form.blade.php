@php
    $profileFieldKeys = ['name', 'username', 'email', 'phone', 'address', 'nip', 'nis', 'kelas'];
    $hasProfileErrors = $errors->hasAny($profileFieldKeys);
@endphp

<section x-data="{ editing: {{ $hasProfileErrors ? 'true' : 'false' }} }">
    <header>
        <h2 class="text-lg font-semibold text-slate-900">Informasi Profil</h2>
        <p class="mt-1 text-sm text-slate-500">Perbarui data profil sesuai peran akun Anda.</p>
    </header>

    <div x-show="!editing" class="mt-6 space-y-4">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nama</p>
                <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->name }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Username</p>
                <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->username ?: '-' }}</p>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</p>
            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->email }}</p>
        </div>

        @if ($user->role === 'admin')
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">NIP</p>
                <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->nip ?: '-' }}</p>
            </div>
        @elseif ($user->role === 'peminjam')
            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nomor Telepon</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->phone ?: '-' }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">NIS</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->nis ?: '-' }}</p>
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kelas</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->kelas ?: '-' }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Alamat</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->address ?: '-' }}</p>
                </div>
            </div>
        @endif

        <button type="button" @click="editing = true" class="inline-flex items-center rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-900">
            Edit Profil
        </button>
    </div>

    <form x-show="editing" method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <x-input-label for="name" value="Nama" class="text-sm font-medium text-slate-700" />
                <x-text-input id="name" name="name" type="text" class="mt-2 block w-full rounded-xl border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2 text-xs" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="username" value="Username" class="text-sm font-medium text-slate-700" />
                <x-text-input id="username" name="username" type="text" class="mt-2 block w-full rounded-xl border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600" :value="old('username', $user->username)" required autocomplete="username" />
                <x-input-error class="mt-2 text-xs" :messages="$errors->get('username')" />
            </div>
        </div>

        <div>
            <x-input-label for="email" value="Email" class="text-sm font-medium text-slate-700" />
            <x-text-input id="email" name="email" type="email" class="mt-2 block w-full rounded-xl border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2 text-xs" :messages="$errors->get('email')" />
        </div>

        @if ($user->role === 'admin')
            <div>
                <x-input-label for="nip" value="NIP" class="text-sm font-medium text-slate-700" />
                <x-text-input id="nip" name="nip" type="text" class="mt-2 block w-full rounded-xl border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600" :value="old('nip', $user->nip)" required />
                <x-input-error class="mt-2 text-xs" :messages="$errors->get('nip')" />
            </div>
        @elseif ($user->role === 'peminjam')
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input-label for="phone" value="Nomor Telepon" class="text-sm font-medium text-slate-700" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-2 block w-full rounded-xl border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600" :value="old('phone', $user->phone)" />
                    <x-input-error class="mt-2 text-xs" :messages="$errors->get('phone')" />
                </div>

                <div>
                    <x-input-label for="nis" value="NIS" class="text-sm font-medium text-slate-700" />
                    <x-text-input id="nis" name="nis" type="text" class="mt-2 block w-full rounded-xl border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600" :value="old('nis', $user->nis)" required />
                    <x-input-error class="mt-2 text-xs" :messages="$errors->get('nis')" />
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input-label for="kelas" value="Kelas" class="text-sm font-medium text-slate-700" />
                    <x-text-input id="kelas" name="kelas" type="text" class="mt-2 block w-full rounded-xl border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600" :value="old('kelas', $user->kelas)" required />
                    <x-input-error class="mt-2 text-xs" :messages="$errors->get('kelas')" />
                </div>

                <div>
                    <x-input-label for="address" value="Alamat" class="text-sm font-medium text-slate-700" />
                    <x-text-input id="address" name="address" type="text" class="mt-2 block w-full rounded-xl border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600" :value="old('address', $user->address)" />
                    <x-input-error class="mt-2 text-xs" :messages="$errors->get('address')" />
                </div>
            </div>
        @endif

        <div class="flex items-center gap-3">
            <button type="button" @click="editing = false" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Batal
            </button>
            <button type="submit" class="inline-flex items-center rounded-xl bg-cyan-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-800">
                Simpan Profil
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-600"
                >Profil tersimpan.</p>
            @endif
        </div>
    </form>
</section>
