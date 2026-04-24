<x-admin-layout>
    <x-slot name="header">
        Data buku perpustakaan
    </x-slot>

    <section class="space-y-6">
        <div class="grid gap-4 xl:grid-cols-[0.85fr_2.15fr]">
            <div class="admin-panel rounded-[28px] p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-blue-600">Kelola Koleksi</p>
                <h3 class="mt-3 text-3xl font-bold leading-tight text-slate-900">Tambah buku lewat halaman khusus.</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">Pisahkan proses input dari daftar buku supaya admin lebih nyaman saat melihat data, edit, dan hapus koleksi.</p>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row xl:flex-col">
                    <a href="{{ route('admin.books.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-[0_18px_35px_-22px_rgba(37,99,235,0.9)] transition duration-200 hover:-translate-y-0.5 hover:scale-[1.01] hover:bg-blue-700">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Buku
                    </a>
                    <p class="text-xs text-slate-500">Form tambah buku sekarang dibuka di halaman baru.</p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div class="admin-panel group rounded-[28px] p-5 transition duration-200 hover:-translate-y-1 hover:shadow-[0_24px_45px_-26px_rgba(37,99,235,0.32)]">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm text-slate-500">Total Buku</p>
                            <p class="mt-3 text-3xl font-bold text-slate-900">{{ $books->count() }}</p>
                        </div>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition duration-200 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white">
                            <i class="fa-solid fa-book"></i>
                        </span>
                    </div>
                    <p class="mt-4 text-xs text-slate-500">Jumlah judul aktif di katalog perpustakaan.</p>
                </div>
                <div class="admin-panel group rounded-[28px] p-5 transition duration-200 hover:-translate-y-1 hover:shadow-[0_24px_45px_-26px_rgba(14,165,233,0.28)]">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm text-slate-500">Total Stok</p>
                            <p class="mt-3 text-3xl font-bold text-slate-900">{{ $books->sum('stock') }}</p>
                        </div>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-50 text-sky-600 transition duration-200 group-hover:scale-110 group-hover:bg-sky-500 group-hover:text-white">
                            <i class="fa-solid fa-layer-group"></i>
                        </span>
                    </div>
                    <p class="mt-4 text-xs text-slate-500">Akumulasi stok fisik yang masih tercatat.</p>
                </div>
                <div class="admin-panel group rounded-[28px] p-5 transition duration-200 hover:-translate-y-1 hover:shadow-[0_24px_45px_-26px_rgba(245,158,11,0.28)]">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm text-slate-500">Sedang Dipinjam</p>
                            <p class="mt-3 text-3xl font-bold text-slate-900">{{ $books->sum('borrowed_count') }}</p>
                        </div>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 transition duration-200 group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white">
                            <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        </span>
                    </div>
                    <p class="mt-4 text-xs text-slate-500">Buku yang saat ini masih berada di tangan peminjam.</p>
                </div>
            </div>
        </div>

        <div class="admin-panel rounded-[30px] p-6">
            <div class="flex items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Daftar Buku</h3>
                    <p class="mt-1 text-sm text-slate-500">Semua data buku yang tampil di dashboard peminjam.</p>
                </div>
                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">{{ $books->count() }} judul</span>
            </div>

            <div class="mt-5 space-y-4">
                <div class="hidden rounded-2xl bg-slate-50/90 px-6 py-4 text-xs font-semibold uppercase tracking-[0.24em] text-slate-500 lg:grid lg:grid-cols-[96px_96px_minmax(220px,1.8fr)_minmax(160px,1.1fr)_84px_100px_228px] lg:items-center lg:gap-4">
                    <div>Image</div>
                    <div>Kode</div>
                    <div>Judul</div>
                    <div>Penulis</div>
                    <div>Stok</div>
                    <div>Dipinjam</div>
                    <div class="text-right">Aksi</div>
                </div>

                @forelse ($books as $book)
                    <article class="admin-grid-row rounded-[26px] border border-slate-200/80 p-4 sm:p-5">
                        <div class="flex flex-col gap-4 lg:grid lg:grid-cols-[96px_96px_minmax(220px,1.8fr)_minmax(160px,1.1fr)_84px_100px_228px] lg:items-center lg:gap-4">
                            <div class="flex items-center gap-4 lg:gap-0">
                                @if ($book->hasImage())
                                    <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}" class="h-20 w-16 rounded-2xl object-cover shadow-sm ring-1 ring-slate-200">
                                @else
                                    <div class="flex h-20 w-16 items-center justify-center rounded-2xl bg-slate-100 text-[10px] font-semibold uppercase text-slate-400 ring-1 ring-slate-200">
                                        No Img
                                    </div>
                                @endif

                                <div class="lg:hidden">
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ $book->code }}</p>
                                    <p class="mt-1 font-semibold text-slate-900">{{ $book->title }}</p>
                                    <p class="text-sm text-slate-500">{{ $book->author }}</p>
                                </div>
                            </div>

                            <div class="hidden text-sm font-semibold text-slate-500 lg:block">{{ $book->code }}</div>

                            <div class="hidden lg:block">
                                <p class="font-semibold leading-6 text-slate-900">{{ $book->title }}</p>
                                <p class="text-xs text-slate-500">{{ $book->publisher ?: 'Penerbit belum diisi' }}</p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 lg:hidden">Penulis</p>
                                <p class="text-sm text-slate-700">{{ $book->author }}</p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 lg:hidden">Stok</p>
                                <p class="inline-flex min-w-[3rem] items-center justify-center rounded-full bg-blue-50 px-3 py-1 text-sm font-semibold text-blue-700">{{ $book->stock }}</p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 lg:hidden">Dipinjam</p>
                                <p class="inline-flex min-w-[3rem] items-center justify-center rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">{{ $book->borrowed_count }}</p>
                            </div>

                            <div class="flex flex-wrap items-center gap-2 lg:justify-end">
                                <a href="{{ route('admin.books.show', $book) }}" class="inline-flex min-w-[74px] items-center justify-center gap-2 rounded-xl bg-slate-100 px-3 py-2.5 text-xs font-semibold text-slate-700 transition duration-200 hover:-translate-y-0.5 hover:bg-slate-200">
                                    <i class="fa-regular fa-eye"></i>
                                    Detail
                                </a>
                                <a href="{{ route('admin.books.edit', $book) }}" class="inline-flex min-w-[74px] items-center justify-center gap-2 rounded-xl bg-blue-50 px-3 py-2.5 text-xs font-semibold text-blue-700 transition duration-200 hover:-translate-y-0.5 hover:bg-blue-100">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.books.destroy', $book) }}" onsubmit="return confirm('Hapus buku ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex min-w-[74px] items-center justify-center gap-2 rounded-xl bg-rose-100 px-3 py-2.5 text-xs font-semibold text-rose-700 transition duration-200 hover:-translate-y-0.5 hover:bg-rose-200">
                                        <i class="fa-regular fa-trash-can"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50/90 px-6 py-12 text-center text-slate-500">
                        Belum ada buku yang tersimpan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-admin-layout>
