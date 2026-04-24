<x-admin-layout>
    <x-slot name="header">
        Edit anggota
    </x-slot>

    <section class="grid gap-6 xl:grid-cols-[1fr_1.05fr]">
        <div class="admin-panel rounded-[30px] p-6">
            <h3 class="text-xl font-bold text-slate-900">Edit Data Anggota</h3>
            <p class="mt-1 text-sm text-slate-500">Perbarui data anggota agar tetap sinkron dengan aktivitas peminjaman.</p>

            @include('admin.members._form', ['member' => $member])
        </div>

        <div class="admin-panel rounded-[30px] p-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-xl font-bold text-slate-900">Ringkasan Anggota</h3>
                <p class="mt-1 text-sm text-slate-500">Cek data anggota sebelum perubahan disimpan.</p>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl bg-slate-50/90 p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Nama</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $member->name }}</p>
                </div>
                <div class="rounded-2xl bg-slate-50/90 p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Email</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $member->email }}</p>
                </div>
                <div class="rounded-2xl bg-slate-50/90 p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">No. Telepon</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $member->phone ?: '-' }}</p>
                </div>
                <div class="rounded-2xl bg-slate-50/90 p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Alamat</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $member->address ?: '-' }}</p>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
