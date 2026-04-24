<x-admin-layout>
    <x-slot name="header">
        Log aktivitas sistem
    </x-slot>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-900">Laporan Log Aktivitas</h3>
                <p class="mt-1 text-sm text-slate-500">Daftar semua aktivitas peminjaman dan pengembalian dalam bentuk tabel.</p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ $activities->count() }} aktivitas</span>
                <a href="{{ route('admin.logs.print') }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">
                    <i class="fa-solid fa-print"></i>
                    Cetak Laporan
                </a>
                <a href="{{ route('admin.logs.pdf') }}" class="inline-flex items-center gap-2 rounded-xl bg-rose-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-rose-700">
                    <i class="fa-solid fa-file-pdf"></i>
                    Unduh PDF
                </a>
            </div>
        </div>

        <div class="mt-5 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead>
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="pb-3 pr-4">No</th>
                        <th class="pb-3 pr-4">Tanggal</th>
                        <th class="pb-3 pr-4">Aktivitas</th>
                        <th class="pb-3 pr-4">Deskripsi</th>
                        <th class="pb-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($activities as $activity)
                        <tr class="align-top transition hover:bg-slate-50/80">
                            <td class="py-3 pr-4 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                            <td class="py-3 pr-4 whitespace-nowrap">{{ \Illuminate\Support\Carbon::parse($activity->date)->translatedFormat('d M Y') }}</td>
                            <td class="py-3 pr-4 font-semibold text-slate-900">{{ $activity->action }}</td>
                            <td class="py-3 pr-4">{{ $activity->description }}</td>
                            <td class="py-3">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $activity->status === \App\Models\Loan::STATUS_RETURNED ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $activity->status === \App\Models\Loan::STATUS_REJECTED ? 'bg-rose-100 text-rose-700' : '' }}
                                    {{ $activity->status === \App\Models\Loan::STATUS_WAITING_RETURN_VERIFICATION ? 'bg-indigo-100 text-indigo-700' : '' }}
                                    {{ in_array($activity->status, [\App\Models\Loan::STATUS_PENDING_APPROVAL, \App\Models\Loan::STATUS_BORROWED], true) ? 'bg-amber-100 text-amber-700' : '' }}">
                                    {{ \App\Models\Loan::make(['status' => $activity->status])->statusLabel() }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-500">Belum ada log aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-admin-layout>
