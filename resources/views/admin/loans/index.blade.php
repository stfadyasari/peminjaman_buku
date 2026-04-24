<x-admin-layout>
    <x-slot name="header">
        Data peminjaman aktif
    </x-slot>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-900">Peminjaman Berjalan</h3>
                <p class="mt-1 text-sm text-slate-500">Daftar ini berubah otomatis saat peminjam melakukan pinjam atau pengembalian.</p>
            </div>
            <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-600">{{ $loans->count() }} transaksi aktif</span>
        </div>

        <div class="mt-5 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead>
                    <tr class="text-left font-semibold text-slate-500">
                        <th class="pb-3 pr-4">Anggota</th>
                        <th class="pb-3 pr-4">Buku</th>
                        <th class="pb-3 pr-4">Tanggal Pinjam</th>
                        <th class="pb-3 pr-4">Batas Kembali</th>
                        <th class="pb-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($loans as $loan)
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-slate-900">{{ $loan->user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $loan->user->email }}</p>
                            </td>
                            <td class="py-4 pr-4">{{ $loan->book->title }}</td>
                            <td class="py-4 pr-4">{{ optional($loan->borrowed_at)->format('d M Y') }}</td>
                            <td class="py-4 pr-4">{{ optional($loan->due_at)->format('d M Y') }}</td>
                            <td class="py-4">
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">{{ ucfirst($loan->status) }}</span>
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
</x-admin-layout>
