<x-borrower-layout>
    <x-slot name="header">
        Ajukan peminjaman buku
    </x-slot>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <article class="borrower-stat-card p-5">
            <p class="text-sm font-medium text-slate-500">Katalog Tersedia</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $availableBooks }}</p>
        </article>
        <article class="borrower-stat-card p-5">
            <p class="text-sm font-medium text-slate-500">Menunggu Persetujuan</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $pendingApprovalCount }}</p>
        </article>
        <article class="borrower-stat-card p-5">
            <p class="text-sm font-medium text-slate-500">Aksi Cepat</p>
            <a href="{{ route('borrower.loans') }}" class="borrower-btn-primary mt-3 inline-flex items-center gap-2 px-4 py-2 text-sm">
                <i class="fa-solid fa-right-left"></i>
                Lihat Peminjaman
            </a>
        </article>
    </section>

    <section class="borrower-panel mt-5 rounded-[1.5rem] p-5">
        <div class="border-b border-slate-100 pb-4">
            <h3 class="borrower-section-title">Katalog Buku Tersedia</h3>
            <p class="borrower-section-subtitle">Pilih buku yang ingin dipinjam. Buku yang tampil hanya yang stoknya masih tersedia.</p>
        </div>

        <form method="GET" action="{{ route('borrower.submission') }}" class="mt-4 flex flex-col gap-3 sm:flex-row">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari judul, penulis, kode, penerbit"
                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100"
            >
            <button type="submit" class="borrower-btn-primary px-5 py-3 text-sm">Cari</button>
        </form>

        <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($books as $book)
                <article class="borrower-soft-card p-4">
                    <div class="flex gap-3">
                        <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}" class="h-24 w-16 rounded-xl object-cover ring-1 ring-slate-200">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600">{{ $book->code }}</p>
                            <h4 class="mt-1 line-clamp-2 font-bold text-slate-900">{{ $book->title }}</h4>
                            <p class="text-sm text-slate-500">{{ $book->author }}</p>
                            <p class="mt-2 text-xs text-slate-500">Stok: {{ $book->stock }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('borrower.loans.store') }}" class="mt-4">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="borrower-btn-primary w-full px-4 py-2.5 text-sm">
                            Ajukan Peminjaman
                        </button>
                    </form>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white/80 px-5 py-10 text-center text-sm text-slate-500 md:col-span-2 xl:col-span-3">
                    Buku yang tersedia tidak ditemukan.
                </div>
            @endforelse
        </div>
    </section>
</x-borrower-layout>
