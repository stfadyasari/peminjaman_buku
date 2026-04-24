<x-borrower-layout>
    <x-slot name="header">
        Riwayat peminjaman
    </x-slot>

    <section class="space-y-5">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="borrower-stat-card p-5">
                <p class="text-sm font-medium text-slate-500">Sudah Dikembalikan</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $returnedCount }}</p>
            </article>
            <article class="borrower-stat-card p-5">
                <p class="text-sm font-medium text-slate-500">Ditolak</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $rejectedCount }}</p>
            </article>
            <article class="borrower-stat-card p-5">
                <p class="text-sm font-medium text-slate-500">Tagihan Lunas</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $paidCount }}</p>
            </article>
            <article class="borrower-stat-card p-5">
                <p class="text-sm font-medium text-slate-500">Tagihan Belum Lunas</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $unpaidCount }}</p>
            </article>
        </div>

        <section class="borrower-panel rounded-[1.5rem] p-5">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="borrower-section-title">Daftar Riwayat Peminjaman</h3>
                <p class="borrower-section-subtitle">Menampilkan transaksi yang sudah selesai (dikembalikan atau ditolak).</p>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="borrower-table min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="text-left font-semibold">
                            <th class="pb-3 pr-4">Buku</th>
                            <th class="pb-3 pr-4">Tanggal</th>
                            <th class="pb-3 pr-4">Status</th>
                            <th class="pb-3 pr-4">Total Denda</th>
                            <th class="pb-3 pr-4">Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($historyEntries as $entry)
                            <tr class="transition-colors">
                                <td class="py-4 pr-4">
                                    <p class="font-semibold text-slate-900">{{ $entry->loan->book->title }}</p>
                                    <p class="text-xs text-slate-500">{{ $entry->loan->book->code }}</p>
                                </td>
                                <td class="py-4 pr-4">
                                    <p>Pinjam: {{ optional($entry->loan->borrowed_at)->format('d M Y') ?: '-' }}</p>
                                    <p class="text-xs text-slate-500">Kembali: {{ optional($entry->loan->returned_at)->format('d M Y') ?: '-' }}</p>
                                </td>
                                <td class="py-4 pr-4">
                                    <span class="borrower-pill {{ $entry->loan->status === \App\Models\Loan::STATUS_RETURNED ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                        {{ $entry->loan->statusLabel() }}
                                    </span>
                                </td>
                                <td class="py-4 pr-4 font-semibold {{ $entry->fine_amount > 0 ? 'text-rose-600' : 'text-slate-700' }}">
                                    {{ $entry->fine_amount > 0 ? 'Rp ' . number_format($entry->fine_amount, 0, ',', '.') : '-' }}
                                </td>
                                <td class="py-4 pr-4">
                                    <span class="borrower-pill {{ $entry->payment_status === 'Belum Dibayar' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-700' }}">
                                        {{ $entry->payment_status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500">Belum ada riwayat peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</x-borrower-layout>
