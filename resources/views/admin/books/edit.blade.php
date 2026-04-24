<x-admin-layout>
    <x-slot name="header">
        Edit data buku
    </x-slot>

    <section class="grid gap-6 xl:grid-cols-[1fr_1.1fr]">
        <div class="admin-panel rounded-[30px] p-6">
            <h3 class="text-xl font-bold text-slate-900">Edit Buku</h3>
            <p class="mt-1 text-sm text-slate-500">Perbarui informasi buku agar sinkron dengan katalog peminjam.</p>

            @include('admin.books._form', ['book' => $book])
        </div>

        <div class="admin-panel rounded-[30px] p-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-xl font-bold text-slate-900">Ringkasan Buku</h3>
                <p class="mt-1 text-sm text-slate-500">Pastikan data ini sesuai sebelum disimpan.</p>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl bg-slate-50/90 p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Kode</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $book->code }}</p>
                </div>
                <div class="rounded-2xl bg-slate-50/90 p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Stok</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $book->stock }}</p>
                </div>
                <div class="rounded-2xl bg-slate-50/90 p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm sm:col-span-2">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Judul</p>
                    <p class="mt-2 text-base font-bold text-slate-900">{{ $book->title }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $book->author }}</p>
                </div>
                <div class="rounded-2xl bg-slate-50/90 p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm sm:col-span-2">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Deskripsi</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $book->description ?: 'Deskripsi buku belum diisi.' }}</p>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
