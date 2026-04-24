<x-admin-layout>
    <x-slot name="header">
        Tambah buku
    </x-slot>

    <section class="grid gap-6 xl:grid-cols-[1fr_1.05fr]">
        <div class="admin-panel rounded-[30px] p-6">
            <h3 class="text-xl font-bold text-slate-900">Tambah Buku Baru</h3>
            <p class="mt-1 text-sm text-slate-500">Tambahkan koleksi baru agar langsung muncul di katalog peminjam.</p>

            @include('admin.books._form')
        </div>

        <div class="space-y-6">
            <div class="admin-panel rounded-[30px] p-6">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="text-xl font-bold text-slate-900">Panduan Input</h3>
                    <p class="mt-1 text-sm text-slate-500">Isi data buku secara lengkap supaya katalog admin dan peminjam tetap sinkron.</p>
                </div>

                <div class="mt-5 space-y-4 text-sm text-slate-600">
                    <div class="rounded-2xl bg-slate-50/90 p-4">
                        <p class="font-semibold text-slate-900"><i class="fa-solid fa-barcode mr-2 text-blue-600"></i>Kode Buku</p>
                        <p class="mt-1 leading-6">Gunakan kode unik seperti <span class="font-semibold text-slate-900">BK031</span> agar mudah dicari di halaman admin maupun peminjam.</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50/90 p-4">
                        <p class="font-semibold text-slate-900"><i class="fa-regular fa-image mr-2 text-blue-600"></i>Image Buku</p>
                        <p class="mt-1 leading-6">Upload cover buku bila tersedia. Jika belum ada, sistem tetap bisa menyimpan data buku tanpa gambar.</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50/90 p-4">
                        <p class="font-semibold text-slate-900"><i class="fa-solid fa-boxes-stacked mr-2 text-blue-600"></i>Stok dan Deskripsi</p>
                        <p class="mt-1 leading-6">Pastikan stok awal sesuai jumlah fisik buku, lalu isi deskripsi singkat agar peminjam lebih mudah mengenali isi buku.</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[30px] border border-blue-100 bg-gradient-to-br from-blue-50 to-sky-50 p-6 shadow-[0_20px_45px_-30px_rgba(37,99,235,0.45)]">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-blue-600">Navigasi Cepat</p>
                <h3 class="mt-3 text-xl font-bold text-slate-900">Kembali ke Kelola Buku</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">Setelah selesai menambah data, Anda akan diarahkan kembali ke daftar buku admin.</p>
                <a href="{{ route('admin.books.index') }}" class="mt-5 inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-blue-700">
                    <i class="fa-solid fa-arrow-left"></i>
                    Lihat Daftar Buku
                </a>
            </div>
        </div>
    </section>
</x-admin-layout>
