<x-admin-layout>
    <x-slot name="header">
        Tambah anggota
    </x-slot>

    <section class="grid gap-6 xl:grid-cols-[1fr_1.05fr]">
        <div class="admin-panel rounded-[30px] p-6">
            <h3 class="text-xl font-bold text-slate-900">Tambah Anggota Baru</h3>
            <p class="mt-1 text-sm text-slate-500">Buat akun peminjam baru langsung dari panel admin.</p>

            @include('admin.members._form')
        </div>

        <div class="space-y-6">
            <div class="admin-panel rounded-[30px] p-6">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="text-xl font-bold text-slate-900">Panduan Data Anggota</h3>
                    <p class="mt-1 text-sm text-slate-500">Lengkapi data anggota agar proses peminjaman dan pelacakan riwayat tetap rapi.</p>
                </div>

                <div class="mt-5 space-y-4 text-sm text-slate-600">
                    <div class="rounded-2xl bg-slate-50/90 p-4">
                        <p class="font-semibold text-slate-900"><i class="fa-solid fa-user mr-2 text-blue-600"></i>Identitas</p>
                        <p class="mt-1 leading-6">Gunakan nama lengkap dan email aktif agar akun anggota mudah dikenali di sistem.</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50/90 p-4">
                        <p class="font-semibold text-slate-900"><i class="fa-solid fa-phone mr-2 text-blue-600"></i>Kontak</p>
                        <p class="mt-1 leading-6">Nomor telepon dan alamat membantu admin saat perlu menghubungi anggota terkait peminjaman.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
