<x-admin-layout>
    <x-slot name="header">
        Detail buku
    </x-slot>

    <section class="grid gap-6 xl:grid-cols-[1.15fr_1.85fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-blue-600">{{ $book->code }}</p>
                    <h3 class="mt-2 text-2xl font-bold text-slate-900">{{ $book->title }}</h3>
                    <p class="mt-2 text-sm text-slate-500">{{ $book->author }}</p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.books.edit', $book) }}" class="inline-flex items-center rounded-2xl bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-700 transition hover:bg-amber-200">
                        Edit
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="mt-6">
                @if ($book->hasImage())
                    <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}" class="h-72 w-full rounded-3xl object-cover ring-1 ring-slate-200">
                @else
                    <div class="flex h-72 items-center justify-center rounded-3xl bg-slate-100 text-sm font-semibold uppercase tracking-[0.3em] text-slate-400 ring-1 ring-slate-200">
                        No Image
                    </div>
                @endif
            </div>

            <div class="mt-6 rounded-2xl bg-slate-50 p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Deskripsi</p>
                <p class="mt-3 text-sm leading-7 text-slate-600">{{ $book->description ?: 'Deskripsi buku belum diisi.' }}</p>
            </div>
        </div>

        <div class="space-y-6">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Penulis</p>
                    <p class="mt-3 text-lg font-bold text-slate-900">{{ $book->author }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Penerbit</p>
                    <p class="mt-3 text-lg font-bold text-slate-900">{{ $book->publisher ?: '-' }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Tahun</p>
                    <p class="mt-3 text-lg font-bold text-slate-900">{{ $book->publish_year ?: '-' }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Stok</p>
                    <p class="mt-3 text-lg font-bold text-slate-900">{{ $book->stock }}</p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Sedang Dipinjam</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">{{ $book->borrowed_count }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Total Riwayat Pinjam</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">{{ $book->loans_count }}</p>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Riwayat Terbaru</h3>
                        <p class="mt-1 text-sm text-slate-500">Aktivitas peminjaman terbaru untuk buku ini.</p>
                    </div>
                </div>

                <div class="mt-5 space-y-4">
                    @forelse ($book->loans as $loan)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $loan->user->name }}</p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        Pinjam: {{ optional($loan->borrowed_at)->format('d M Y') ?: '-' }}
                                        | Kembali: {{ optional($loan->returned_at)->format('d M Y') ?: '-' }}
                                    </p>
                                </div>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $loan->status === 'dipinjam' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada riwayat peminjaman untuk buku ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
