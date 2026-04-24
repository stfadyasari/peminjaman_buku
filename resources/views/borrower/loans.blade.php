<x-borrower-layout>
    <x-slot name="header">
        Peminjaman buku
    </x-slot>

    <section x-data="{ modalOpen: false, selected: null }" class="space-y-5">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="borrower-stat-card p-5">
                <p class="text-sm font-medium text-slate-500">Menunggu Persetujuan</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $pendingCount }}</p>
            </article>
            <article class="borrower-stat-card p-5">
                <p class="text-sm font-medium text-slate-500">Sedang Dipinjam</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $activeCount }}</p>
            </article>
            <article class="borrower-stat-card p-5">
                <p class="text-sm font-medium text-slate-500">Sudah Dikembalikan</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $returnedCount }}</p>
            </article>
            <article class="borrower-stat-card p-5">
                <p class="text-sm font-medium text-slate-500">Denda Belum Lunas</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">Rp {{ number_format($outstandingFineAmount, 0, ',', '.') }}</p>
                <p class="mt-2 text-xs text-slate-500">{{ $unpaidCount }} tagihan aktif</p>
            </article>
        </div>

        <section class="borrower-panel rounded-[1.5rem] p-5">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="borrower-section-title">Daftar Peminjaman</h3>
                <p class="borrower-section-subtitle">Kelola pengembalian buku dan pembayaran denda dari satu halaman.</p>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="borrower-table min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="text-left font-semibold">
                            <th class="pb-3 pr-4">Buku</th>
                            <th class="pb-3 pr-4">Tanggal</th>
                            <th class="pb-3 pr-4">Status</th>
                            <th class="pb-3 pr-4">Denda</th>
                            <th class="pb-3 pr-4">Pembayaran</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($loanEntries as $entry)
                            <tr class="transition-colors">
                                <td class="py-4 pr-4">
                                    <p class="font-semibold text-slate-900">{{ $entry->loan->book->title }}</p>
                                    <p class="text-xs text-slate-500">{{ $entry->loan->book->code }}</p>
                                </td>
                                <td class="py-4 pr-4">
                                    <p>Pinjam: {{ optional($entry->loan->borrowed_at)->format('d M Y') ?: '-' }}</p>
                                    <p class="text-xs text-slate-500">Batas: {{ optional($entry->loan->due_at)->format('d M Y') ?: '-' }}</p>
                                </td>
                                <td class="py-4 pr-4">
                                    <span class="borrower-pill
                                        {{ $entry->loan->status === \App\Models\Loan::STATUS_PENDING_APPROVAL ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $entry->loan->status === \App\Models\Loan::STATUS_BORROWED ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $entry->loan->status === \App\Models\Loan::STATUS_WAITING_RETURN_VERIFICATION ? 'bg-indigo-100 text-indigo-700' : '' }}
                                        {{ $entry->loan->status === \App\Models\Loan::STATUS_RETURNED ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        {{ $entry->loan->status === \App\Models\Loan::STATUS_REJECTED ? 'bg-rose-100 text-rose-700' : '' }}">
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
                                <td class="py-4 text-right">
                                    @if ($entry->loan->status === \App\Models\Loan::STATUS_BORROWED)
                                        <form method="POST" action="{{ route('borrower.loans.return', $entry->loan) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">
                                                Ajukan Pengembalian
                                            </button>
                                        </form>
                                    @elseif ($entry->fine_amount > 0 && $entry->loan->fine_payment_status !== \App\Models\Loan::PAYMENT_PAID)
                                        <button
                                            type="button"
                                            class="borrower-btn-primary px-3 py-2 text-xs"
                                            @click="selected = {
                                                title: @js($entry->loan->book->title),
                                                lateFine: @js(number_format($entry->late_fine, 0, ',', '.')),
                                                damageFine: @js(number_format($entry->damage_fine, 0, ',', '.')),
                                                totalFine: @js(number_format($entry->fine_amount, 0, ',', '.')),
                                                action: @js(route('borrower.loans.pay-qris', $entry->loan))
                                            }; modalOpen = true"
                                        >
                                            Bayar QRIS
                                        </button>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-500">Belum ada data peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div
            x-show="modalOpen"
            x-transition.opacity
            class="fixed inset-0 z-40 bg-slate-950/55"
            @click="modalOpen = false"
            x-cloak
        ></div>

        <div
            x-show="modalOpen"
            x-transition
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            x-cloak
        >
            <section class="w-full max-w-md rounded-3xl border border-slate-200 bg-white p-6 shadow-2xl" @click.stop>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600">Pembayaran QRIS</p>
                        <h3 class="mt-2 text-lg font-bold text-slate-900" x-text="selected?.title"></h3>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-slate-600" @click="modalOpen = false">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <div class="mt-4 rounded-2xl border border-blue-100 bg-blue-50/70 p-4 text-center">
                    <div class="mx-auto inline-flex h-36 w-36 items-center justify-center rounded-2xl border border-blue-100 bg-white text-blue-600">
                        <i class="fa-solid fa-qrcode text-6xl"></i>
                    </div>
                    <p class="mt-3 text-sm text-slate-600">Scan QRIS lalu konfirmasi pembayaran.</p>
                </div>

                <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Denda Telat</span>
                        <span class="font-semibold text-slate-900">Rp <span x-text="selected?.lateFine"></span></span>
                    </div>
                    <div class="mt-2 flex justify-between">
                        <span class="text-slate-500">Denda Kerusakan</span>
                        <span class="font-semibold text-slate-900">Rp <span x-text="selected?.damageFine"></span></span>
                    </div>
                    <div class="mt-3 border-t border-slate-200 pt-3">
                        <div class="flex justify-between">
                            <span class="font-semibold text-slate-700">Total Tagihan</span>
                            <span class="text-lg font-bold text-rose-700">Rp <span x-text="selected?.totalFine"></span></span>
                        </div>
                    </div>
                </div>

                <form method="POST" :action="selected?.action" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="borrower-btn-primary w-full px-4 py-3 text-sm">
                        Konfirmasi Bayar QRIS
                    </button>
                </form>
            </section>
        </div>
    </section>
</x-borrower-layout>
