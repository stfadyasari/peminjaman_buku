@php
    $isEdit = isset($member);
@endphp

<form
    method="POST"
    action="{{ $isEdit ? route('admin.members.update', $member) : route('admin.members.store') }}"
    class="mt-6 space-y-5"
>
    @csrf
    @if ($isEdit)
        @method('PATCH')
    @endif

    <div>
        <label for="name" class="text-sm font-semibold text-slate-700">Nama Lengkap</label>
        <input id="name" name="name" type="text" value="{{ old('name', $member->name ?? '') }}" class="mt-2 w-full rounded-2xl border-slate-200/90 bg-white/90 px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-blue-500 focus:ring-blue-500">
        @error('name')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $member->email ?? '') }}" class="mt-2 w-full rounded-2xl border-slate-200/90 bg-white/90 px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-blue-500 focus:ring-blue-500">
        @error('email')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="phone" class="text-sm font-semibold text-slate-700">No. Telepon</label>
            <input id="phone" name="phone" type="text" value="{{ old('phone', $member->phone ?? '') }}" class="mt-2 w-full rounded-2xl border-slate-200/90 bg-white/90 px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-blue-500 focus:ring-blue-500">
            @error('phone')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password" class="text-sm font-semibold text-slate-700">{{ $isEdit ? 'Password Baru' : 'Password' }}</label>
            <input id="password" name="password" type="password" class="mt-2 w-full rounded-2xl border-slate-200/90 bg-white/90 px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-blue-500 focus:ring-blue-500">
            <p class="mt-1 text-xs text-slate-500">{{ $isEdit ? 'Kosongkan jika tidak ingin mengubah password.' : 'Minimal 6 karakter.' }}</p>
            @error('password')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="address" class="text-sm font-semibold text-slate-700">Alamat</label>
        <textarea id="address" name="address" rows="4" class="mt-2 w-full rounded-2xl border-slate-200/90 bg-white/90 px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-blue-500 focus:ring-blue-500">{{ old('address', $member->address ?? '') }}</textarea>
        @error('address')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex flex-col gap-3 sm:flex-row">
        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-[0_18px_35px_-22px_rgba(37,99,235,0.9)] transition duration-200 hover:-translate-y-0.5 hover:scale-[1.01] hover:bg-blue-700">
            <i class="fa-solid {{ $isEdit ? 'fa-floppy-disk' : 'fa-user-plus' }}"></i>
            {{ $isEdit ? 'Update Anggota' : 'Simpan Anggota' }}
        </button>
        <a href="{{ route('admin.members.index') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white/90 px-4 py-3 text-sm font-semibold text-slate-700 transition duration-200 hover:-translate-y-0.5 hover:bg-slate-50">
            <i class="fa-solid fa-xmark"></i>
            Batal
        </a>
    </div>
</form>
