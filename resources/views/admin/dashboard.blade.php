<x-admin-layout>
    <x-slot name="header">
        Ringkasan aktivitas perpustakaan
    </x-slot>

    <style>
        .admin-dashboard-card {
            position: relative;
            overflow: hidden;
        }

        .admin-dashboard-card::after {
            content: "";
            position: absolute;
            right: -34px;
            bottom: -34px;
            height: 120px;
            width: 120px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.10);
        }

        .admin-dashboard-surface {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(12px);
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
        }
    </style>

    <section class="admin-dashboard-surface overflow-hidden rounded-[2rem] border border-white/70">
        <div class="border-b border-slate-200/80 px-5 py-6 sm:px-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-blue-600">Dashboard Admin</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Ringkasan aktivitas perpustakaan</h3>
                    <p class="mt-2 max-w-2xl text-sm text-slate-500">
                        Pantau data buku, anggota, dan transaksi peminjaman terbaru dalam satu halaman yang lebih rapi dan mudah dibaca.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:flex sm:flex-wrap">
                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm">
                        <p class="text-slate-500">Buku</p>
                        <p class="mt-1 text-xl font-bold text-slate-900">{{ $totalBuku ?? 0 }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm">
                        <p class="text-slate-500">Anggota</p>
                        <p class="mt-1 text-xl font-bold text-slate-900">{{ $totalAnggota ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-5 py-6 sm:px-8">
            <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="admin-dashboard-card rounded-3xl bg-gradient-to-br from-blue-600 to-blue-500 p-5 text-white shadow-lg shadow-blue-500/20">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-blue-100">Total Buku</p>
                            <h3 class="mt-3 text-4xl font-bold">{{ $totalBuku ?? 0 }}</h3>
                        </div>
                        <div class="rounded-2xl bg-white/15 p-3 text-lg">
                            <i class="fa-solid fa-book"></i>
                        </div>
                    </div>
                </div>

                <div class="admin-dashboard-card rounded-3xl bg-gradient-to-br from-emerald-600 to-emerald-500 p-5 text-white shadow-lg shadow-emerald-500/20">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-emerald-100">Total Anggota</p>
                            <h3 class="mt-3 text-4xl font-bold">{{ $totalAnggota ?? 0 }}</h3>
                        </div>
                        <div class="rounded-2xl bg-white/15 p-3 text-lg">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="admin-dashboard-card rounded-3xl bg-gradient-to-br from-amber-500 to-orange-500 p-5 text-white shadow-lg shadow-orange-500/20">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-amber-50">Menunggu Persetujuan</p>
                            <h3 class="mt-3 text-4xl font-bold">{{ $totalPengajuan ?? 0 }}</h3>
                        </div>
                        <div class="rounded-2xl bg-white/15 p-3 text-lg">
                            <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        </div>
                    </div>
                </div>

                <div class="admin-dashboard-card rounded-3xl bg-gradient-to-br from-rose-500 to-pink-500 p-5 text-white shadow-lg shadow-rose-500/20">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-rose-50">Menunggu Verifikasi Kembali</p>
                            <h3 class="mt-3 text-4xl font-bold">{{ $totalVerifikasiKembali ?? 0 }}</h3>
                        </div>
                        <div class="rounded-2xl bg-white/15 p-3 text-lg">
                            <i class="fa-solid fa-rotate-left"></i>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mt-8 grid gap-6 xl:grid-cols-[1.7fr_1fr]">
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Peminjaman Terbaru</h3>
                            <p class="mt-1 text-sm text-slate-500">Daftar transaksi yang baru masuk ke sistem.</p>
                        </div>
                        <span class="inline-flex w-fit rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">
                            {{ count($peminjaman ?? []) }} data
                        </span>
                    </div>

                    <div class="mt-5 overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead>
                                <tr class="text-left text-sm font-semibold text-slate-500">
                                    <th class="pb-3 pr-4">No</th>
                                    <th class="pb-3 pr-4">Nama Anggota</th>
                                    <th class="pb-3 pr-4">Buku</th>
                                    <th class="pb-3 pr-4">Tanggal Pinjam</th>
                                    <th class="pb-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                                @forelse ($peminjaman ?? [] as $item)
                                    <tr class="transition hover:bg-slate-50/80">
                                        <td class="py-4 pr-4 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                        <td class="py-4 pr-4">{{ optional($item->user)->name ?? '-' }}</td>
                                        <td class="py-4 pr-4 font-medium text-slate-900">{{ optional($item->book)->title ?? '-' }}</td>
                                        <td class="py-4 pr-4">{{ optional($item->borrowed_at)->format('d M Y') ?? '-' }}</td>
                                        <td class="py-4">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ ($item->status ?? '') === \App\Models\Loan::STATUS_BORROWED ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
                                                {{ $item->statusLabel() }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-10 text-center text-sm text-slate-500">
                                            Belum ada data peminjaman terbaru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-3xl bg-slate-950 p-6 text-white shadow-lg shadow-slate-900/10">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-blue-300">Status Sistem</p>
                        <h3 class="mt-4 text-2xl font-bold leading-tight">Pengelolaan perpustakaan lebih rapi</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-300">
                            Gunakan dashboard ini untuk melihat gambaran cepat kondisi koleksi, anggota, dan transaksi aktif.
                        </p>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-900">Ringkasan Cepat</h3>
                        <div class="mt-4 space-y-4 text-sm text-slate-600">
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                <span>Buku tersedia</span>
                                <span class="font-bold text-slate-900">{{ $stokBuku ?? 0 }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                <span>Anggota terdaftar</span>
                                <span class="font-bold text-slate-900">{{ $totalAnggota ?? 0 }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                <span>Sedang dipinjam</span>
                                <span class="font-bold text-slate-900">{{ $totalPeminjaman ?? 0 }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                <span>Sudah kembali</span>
                                <span class="font-bold text-slate-900">{{ $totalPengembalian ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
</x-admin-layout>
