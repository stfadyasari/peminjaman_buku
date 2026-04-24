<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Perpustakaan Digital') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-800 antialiased" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <div class="relative overflow-hidden">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_15%_8%,rgba(14,165,233,0.09),transparent_30%),radial-gradient(circle_at_85%_85%,rgba(6,182,212,0.08),transparent_35%)]"></div>
            <div class="relative mx-auto flex min-h-screen max-w-[90rem] flex-col px-4 py-6 sm:px-6 lg:px-8">
            <header class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-5 py-3.5 shadow-sm">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 text-sm font-semibold text-slate-700">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-100 text-cyan-700">
                        <i class="fa-solid fa-book-open-reader"></i>
                    </span>
                    {{ config('', 'Perpustakaan Digital') }}
                </a>

                @if (Route::has('login'))
                    <div class="flex items-center gap-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-lg bg-cyan-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cyan-800">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-lg bg-cyan-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cyan-800">Daftar</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </header>

            <main class="my-auto py-14 lg:py-16">
                <section class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
                    <article class="rounded-3xl border border-slate-200 bg-gradient-to-b from-white to-cyan-50/40 p-9 shadow-sm sm:p-12">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cyan-700">Sistem Perpustakaan Sekolah</p>
                        <h1 class="mt-4 text-5xl font-bold leading-tight text-slate-900 sm:text-6xl">
                            Platform peminjaman buku yang rapi dan profesional.
                        </h1>
                        <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-600">
                            Kelola peminjaman, pengembalian, dan administrasi denda dalam satu aplikasi yang mudah digunakan oleh admin maupun peminjam.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-lg bg-cyan-700 px-6 py-3.5 text-base font-semibold text-white hover:bg-cyan-800">Masuk Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-lg bg-cyan-700 px-6 py-3.5 text-base font-semibold text-white hover:bg-cyan-800">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-lg border border-slate-300 px-6 py-3.5 text-base font-semibold text-slate-700 hover:bg-slate-50">Daftar Akun</a>
                                @endif
                            @endauth
                        </div>
                    </article>

                    <aside class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm sm:p-9">
                        <h2 class="text-xl font-bold text-slate-900">Keunggulan Utama</h2>
                        <div class="mt-5 space-y-4 text-base text-slate-600">
                            <div class="rounded-xl border border-cyan-100 bg-cyan-50/50 px-5 py-4">Alur peminjaman dan pengembalian lebih terstruktur.</div>
                            <div class="rounded-xl border border-cyan-100 bg-cyan-50/50 px-5 py-4">Monitoring status transaksi secara real-time.</div>
                            <div class="rounded-xl border border-cyan-100 bg-cyan-50/50 px-5 py-4">Pembayaran denda digital dengan catatan yang jelas.</div>
                        </div>
                    </aside>
                </section>
            </main>
            </div>
        </div>
    </body>
</html>
