<x-borrower-layout>
    <x-slot name="header">
        Dashboard peminjaman buku
    </x-slot>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article class="borrower-stat-card p-5">
            <p class="text-sm font-medium text-slate-500">Buku Tersedia</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $availableBooks }}</p>
        </article>
        <article class="borrower-stat-card p-5">
            <p class="text-sm font-medium text-slate-500">Menunggu Persetujuan</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $pendingApprovalCount }}</p>
        </article>
        <article class="borrower-stat-card p-5">
            <p class="text-sm font-medium text-slate-500">Sedang Dipinjam</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $borrowedCount }}</p>
        </article>
        <article class="borrower-stat-card p-5">
            <p class="text-sm font-medium text-slate-500">Total Denda Belum Lunas</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">Rp {{ number_format($outstandingFineAmount, 0, ',', '.') }}</p>
            <p class="mt-2 text-xs text-slate-500">{{ $outstandingFineCount }} tagihan aktif</p>
        </article>
    </section>

    <section class="borrower-panel mt-5 rounded-[1.5rem] p-5">
        <div class="flex flex-col gap-3 border-b border-slate-100 pb-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h3 class="borrower-section-title">Status Peminjaman Aktif</h3>
                <p class="borrower-section-subtitle">Menampilkan pinjaman yang sedang diproses, dipinjam, atau menunggu verifikasi pengembalian.</p>
            </div>
            <a href="{{ route('borrower.submission') }}" class="borrower-btn-primary inline-flex w-fit items-center gap-2 px-4 py-2 text-sm">
                <i class="fa-solid fa-plus"></i>
                Ajukan Peminjaman
            </a>
        </div>

        <div class="mt-4 overflow-x-auto">
            <table class="borrower-table min-w-full divide-y divide-slate-200 text-sm">
                <thead>
                    <tr class="text-left font-semibold">
                        <th class="pb-3 pr-4">Buku</th>
                        <th class="pb-3 pr-4">Tgl Pinjam</th>
                        <th class="pb-3 pr-4">Batas Kembali</th>
                        <th class="pb-3 pr-4">Status</th>
                        <th class="pb-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($activeLoans as $loan)
                        <tr class="transition-colors">
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-slate-900">{{ $loan->book->title }}</p>
                                <p class="text-xs text-slate-500">{{ $loan->book->code }}</p>
                            </td>
                            <td class="py-4 pr-4">{{ optional($loan->borrowed_at)->format('d M Y') ?: '-' }}</td>
                            <td class="py-4 pr-4">{{ optional($loan->due_at)->format('d M Y') ?: '-' }}</td>
                            <td class="py-4 pr-4">
                                <span class="borrower-pill
                                    {{ $loan->status === \App\Models\Loan::STATUS_PENDING_APPROVAL ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $loan->status === \App\Models\Loan::STATUS_BORROWED ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $loan->status === \App\Models\Loan::STATUS_WAITING_RETURN_VERIFICATION ? 'bg-indigo-100 text-indigo-700' : '' }}">
                                    {{ $loan->statusLabel() }}
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                @if ($loan->status === \App\Models\Loan::STATUS_BORROWED)
                                    <form method="POST" action="{{ route('borrower.loans.return', $loan) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">
                                            Ajukan Pengembalian
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-500">Belum ada peminjaman aktif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-borrower-layout>
