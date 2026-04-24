<x-admin-layout>
    <x-slot name="header">
        Kelola denda keterlambatan
    </x-slot>

    <section class="grid gap-6 lg:grid-cols-[0.9fr_2.1fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-rose-500">Ringkasan Denda</p>
            <h3 class="mt-3 text-3xl font-bold text-slate-900">Rp {{ number_format($totalFineAmount, 0, ',', '.') }}</h3>
            <p class="mt-3 text-sm leading-6 text-slate-500">
                Tarif denda saat ini Rp {{ number_format($dailyFine, 0, ',', '.') }} per hari keterlambatan.
            </p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Daftar Denda</h3>
                    <p class="mt-1 text-sm text-slate-500">Denda dihitung otomatis dari selisih tanggal jatuh tempo dan tanggal kembali.</p>
                </div>
                <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-600">{{ $fines->count() }} denda</span>
            </div>

            <div class="mt-5 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="text-left font-semibold text-slate-500">
                            <th class="pb-3 pr-4">Anggota</th>
                            <th class="pb-3 pr-4">Buku</th>
                            <th class="pb-3 pr-4">Terlambat</th>
                            <th class="pb-3">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($fines as $fine)
                            <tr>
                                <td class="py-4 pr-4">
                                    <p class="font-semibold text-slate-900">{{ $fine->loan->user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $fine->loan->user->email }}</p>
                                </td>
                                <td class="py-4 pr-4">{{ $fine->loan->book->title }}</td>
                                <td class="py-4 pr-4">{{ $fine->late_days }} hari</td>
                                <td class="py-4 font-semibold text-rose-600">Rp {{ number_format($fine->fine_amount, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-slate-500">Belum ada denda keterlambatan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-admin-layout>
