<x-admin-layout>
    <x-slot name="header">
        Data anggota perpustakaan
    </x-slot>

    <section class="space-y-6">
        <div class="admin-panel rounded-[28px] p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-blue-600">Kelola Anggota</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-900">Tambah, edit, dan hapus akun peminjam.</h3>
                    <p class="mt-2 text-sm leading-7 text-slate-600">Data anggota dikelola langsung dari panel admin agar daftar akun tetap rapi dan mudah dipantau.</p>
                </div>
                <a href="{{ route('admin.members.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-[0_18px_35px_-22px_rgba(37,99,235,0.9)] transition duration-200 hover:-translate-y-0.5 hover:bg-blue-700">
                    <i class="fa-solid fa-user-plus"></i>
                    Tambah Anggota
                </a>
            </div>
        </div>

        <div class="admin-panel rounded-[30px] p-6">
        <div class="flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-900">Anggota Terdaftar</h3>
                <p class="mt-1 text-sm text-slate-500">Data ini berasal dari akun peminjam yang melakukan registrasi.</p>
            </div>
            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">{{ $members->count() }} anggota</span>
        </div>

        <div class="mt-5 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead>
                    <tr class="text-left font-semibold text-slate-500">
                        <th class="pb-3 pr-4">Nama</th>
                        <th class="pb-3 pr-4">Email</th>
                        <th class="pb-3 pr-4">No. Telepon</th>
                        <th class="pb-3 pr-4">Pinjaman Aktif</th>
                        <th class="pb-3 pr-4">Riwayat Kembali</th>
                        <th class="pb-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($members as $member)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-slate-900">{{ $member->name }}</p>
                                <p class="text-xs text-slate-500">{{ $member->address ?: 'Alamat belum diisi' }}</p>
                            </td>
                            <td class="py-4 pr-4">{{ $member->email }}</td>
                            <td class="py-4 pr-4">{{ $member->phone ?: '-' }}</td>
                            <td class="py-4 pr-4">
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">{{ $member->active_loans_count }}</span>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $member->returned_loans_count }}</span>
                            </td>
                            <td class="py-4 text-right">
                                <div class="flex flex-wrap justify-end gap-2">
                                    <a href="{{ route('admin.members.edit', $member) }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition duration-200 hover:-translate-y-0.5 hover:bg-blue-100">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.members.destroy', $member) }}" onsubmit="return confirm('Hapus anggota ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-rose-100 px-3 py-2 text-xs font-semibold text-rose-700 transition duration-200 hover:-translate-y-0.5 hover:bg-rose-200">
                                            <i class="fa-regular fa-trash-can"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-500">Belum ada anggota yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>
    </section>
</x-admin-layout>
