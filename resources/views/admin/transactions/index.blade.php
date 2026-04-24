<x-admin-layout>
    <x-slot name="header">
        Transaksi terpadu peminjaman, pengembalian, dan denda
    </x-slot>

    <section class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="admin-panel rounded-3xl p-5">
                <p class="text-sm text-slate-500">Menunggu Persetujuan</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $pendingLoans->count() }}</p>
            </article>
            <article class="admin-panel rounded-3xl p-5">
                <p class="text-sm text-slate-500">Sedang Dipinjam</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $activeLoans->count() }}</p>
            </article>
            <article class="admin-panel rounded-3xl p-5">
                <p class="text-sm text-slate-500">Menunggu Verifikasi Kembali</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $returnRequests->count() }}</p>
            </article>
            <article class="admin-panel rounded-3xl p-5">
                <p class="text-sm text-slate-500">Tarif Denda Harian</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">Rp {{ number_format($dailyFine, 0, ',', '.') }}</p>
            </article>
        </div>

        <section class="admin-panel overflow-hidden rounded-3xl">
            <div class="border-b border-slate-200 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">1) Persetujuan Peminjaman</h3>
                <p class="mt-1 text-sm text-slate-500">Admin menyetujui atau menolak pengajuan pinjam dari siswa.</p>
            </div>
            <div class="overflow-x-auto px-6 py-4">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="text-left font-semibold text-slate-500">
                            <th class="pb-3 pr-4">Siswa</th>
                            <th class="pb-3 pr-4">Buku</th>
                            <th class="pb-3 pr-4">Tanggal Request</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pendingLoans as $loan)
                            <tr>
                                <td class="py-4 pr-4">
                                    <p class="font-semibold text-slate-900">{{ $loan->user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $loan->user->email }}</p>
                                </td>
                                <td class="py-4 pr-4">{{ $loan->book->title }}</td>
                                <td class="py-4 pr-4">{{ optional($loan->requested_at)->format('d M Y') ?: optional($loan->created_at)->format('d M Y') }}</td>
                                <td class="py-4">
                                    <div class="flex justify-end gap-2">
                                        <form method="POST" action="{{ route('admin.transactions.approve', $loan) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-700">
                                                Setujui
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.transactions.reject', $loan) }}" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="text" name="approval_note" placeholder="Catatan (opsional)" class="w-44 rounded-xl border border-slate-200 px-3 py-2 text-xs">
                                            <button type="submit" class="rounded-xl bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-700">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500">Tidak ada pengajuan peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="admin-panel overflow-hidden rounded-3xl">
            <div class="border-b border-slate-200 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">2) Verifikasi Pengembalian + Denda Kerusakan</h3>
                <p class="mt-1 text-sm text-slate-500">Pilih kondisi barang: baik, rusak ringan, rusak berat, atau hilang. Denda keterlambatan dihitung otomatis.</p>
            </div>
            <div class="space-y-4 px-6 py-4">
                @forelse ($returnRequests as $loan)
                    <article class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="grid gap-3 md:grid-cols-4">
                            <div>
                                <p class="text-xs text-slate-500">Siswa</p>
                                <p class="font-semibold text-slate-900">{{ $loan->user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $loan->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Buku</p>
                                <p class="font-semibold text-slate-900">{{ $loan->book->title }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Jatuh Tempo</p>
                                <p class="font-semibold text-slate-900">{{ optional($loan->due_at)->format('d M Y') ?: '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Potensi Denda Telat</p>
                                <p class="font-semibold text-rose-600">Rp {{ number_format($loan->fineAmount(), 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.transactions.verify-return', $loan) }}" class="mt-4 grid gap-3 md:grid-cols-[1fr_1fr_2fr_auto]">
                            @csrf
                            @method('PATCH')
                            <select name="condition_status" required class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                <option value="">Pilih kondisi</option>
                                <option value="baik">Baik</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                                <option value="hilang">Hilang</option>
                            </select>
                            <input type="number" name="damage_fine" min="0" value="0" class="rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="Denda kerusakan">
                            <input type="text" name="condition_note" class="rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="Catatan verifikasi">
                            <button type="submit" class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">
                                Verifikasi
                            </button>
                        </form>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 px-4 py-8 text-center text-sm text-slate-500">
                        Tidak ada permintaan pengembalian yang menunggu verifikasi.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="admin-panel overflow-hidden rounded-3xl">
            <div class="border-b border-slate-200 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">3) Ringkasan Status Peminjaman, Pengembalian, dan Denda</h3>
            </div>
            <div class="overflow-x-auto px-6 py-4">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="text-left font-semibold text-slate-500">
                            <th class="pb-3 pr-4">Siswa</th>
                            <th class="pb-3 pr-4">Buku</th>
                            <th class="pb-3 pr-4">Status</th>
                            <th class="pb-3 pr-4">Kondisi</th>
                            <th class="pb-3 pr-4">Denda Total</th>
                            <th class="pb-3">Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($completedTransactions as $loan)
                            <tr>
                                <td class="py-4 pr-4">
                                    <p class="font-semibold text-slate-900">{{ $loan->user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $loan->user->email }}</p>
                                </td>
                                <td class="py-4 pr-4">{{ $loan->book->title }}</td>
                                <td class="py-4 pr-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $loan->status === \App\Models\Loan::STATUS_RETURNED ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                        {{ $loan->statusLabel() }}
                                    </span>
                                </td>
                                <td class="py-4 pr-4">{{ $loan->conditionLabel() }}</td>
                                <td class="py-4 pr-4 font-semibold {{ $loan->total_fine > 0 ? 'text-rose-600' : 'text-slate-700' }}">
                                    {{ $loan->total_fine > 0 ? 'Rp ' . number_format($loan->total_fine, 0, ',', '.') : '-' }}
                                </td>
                                <td class="py-4">
                                    @if ($loan->total_fine < 1)
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Tidak ada tagihan</span>
                                    @elseif ($loan->fine_payment_status === \App\Models\Loan::PAYMENT_PAID)
                                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Lunas (QRIS)</span>
                                    @else
                                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Belum dibayar</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-500">Belum ada transaksi selesai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</x-admin-layout>
