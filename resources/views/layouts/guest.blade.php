<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-800 antialiased" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <div class="relative overflow-hidden">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_16%_10%,rgba(14,165,233,0.08),transparent_34%),radial-gradient(circle_at_85%_90%,rgba(6,182,212,0.07),transparent_36%)]"></div>
            <div class="relative mx-auto flex min-h-screen max-w-6xl items-center px-4 py-10 sm:px-6 lg:px-8">
                <div class="grid w-full overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-300/35 lg:grid-cols-[0.95fr_1.05fr]">
                <section class="hidden border-r border-slate-200 bg-gradient-to-b from-cyan-50 to-slate-50 p-10 lg:flex lg:flex-col">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 text-sm font-semibold text-slate-700">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-cyan-100 text-cyan-700">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </span>
                        Perpustakaan Digital
                    </a>

                    <div class="mt-10">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-cyan-700">Portal Sekolah</p>
                        <h1 class="mt-4 text-3xl font-bold leading-tight text-slate-900">Akses layanan perpustakaan secara cepat dan terstruktur.</h1>
                        <p class="mt-4 text-sm leading-7 text-slate-600">
                            Platform ini mendukung proses peminjaman, pengembalian, dan monitoring transaksi agar lebih tertib.
                        </p>
                    </div>

                    <div class="mt-8 space-y-3 text-sm text-slate-600">
                        <div class="rounded-xl border border-cyan-100 bg-white px-4 py-3">Manajemen transaksi peminjaman yang lebih rapi.</div>
                        <div class="rounded-xl border border-cyan-100 bg-white px-4 py-3">Status pengembalian dan denda tersaji jelas.</div>
                        <div class="rounded-xl border border-cyan-100 bg-white px-4 py-3">Akses akun aman untuk admin dan peminjam.</div>
                    </div>

                    <p class="mt-auto pt-8 text-xs text-slate-500">© {{ now()->year }} {{ config('app.name', 'Perpustakaan') }}</p>
                </section>

                <section class="bg-white p-6 sm:p-8 lg:p-10">
                    <div class="mb-6 flex items-center justify-between lg:hidden">
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-cyan-100 text-cyan-700">
                                <i class="fa-solid fa-book-open-reader"></i>
                            </span>
                            Perpustakaan
                        </a>
                    </div>

                    {{ $slot }}
                </section>
                </div>
            </div>
        </div>
    </body>
</html>
