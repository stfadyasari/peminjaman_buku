<x-admin-layout>
    <x-slot name="header">
        Data pengembalian buku
    </x-slot>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-900">Riwayat Pengembalian</h3>
                <p class="mt-1 text-sm text-slate-500">Admin bisa melihat semua buku yang sudah dikembalikan peminjam.</p>
            </div>
            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">{{ $returns->count() }} pengembalian</span>
        </div>

        <div class="mt-5 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead>
                    <tr class="text-left font-semibold text-slate-500">
                        <th class="pb-3 pr-4">Anggota</th>
                        <th class="pb-3 pr-4">Buku</th>
                        <th class="pb-3 pr-4">Dipinjam</th>
                        <th class="pb-3 pr-4">Dikembalikan</th>
                        <th class="pb-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($returns as $return)
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-slate-900">{{ $return->user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $return->user->email }}</p>
                            </td>
                            <td class="py-4 pr-4">{{ $return->book->title }}</td>
                            <td class="py-4 pr-4">{{ optional($return->borrowed_at)->format('d M Y') }}</td>
                            <td class="py-4 pr-4">{{ optional($return->returned_at)->format('d M Y') }}</td>
                            <td class="py-4">
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ ucfirst($return->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-500">Belum ada data pengembalian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-admin-layout>
