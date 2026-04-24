<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Peminjam</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --borrower-primary: #1d4ed8;
                --borrower-primary-strong: #1e40af;
                --borrower-secondary: #0f172a;
                --borrower-surface: rgba(255, 255, 255, 0.86);
                --borrower-border: rgba(148, 163, 184, 0.2);
            }

            .borrower-app-shell {
                background:
                    radial-gradient(circle at 10% 8%, rgba(37, 99, 235, 0.11), transparent 24%),
                    radial-gradient(circle at 90% 92%, rgba(14, 116, 144, 0.09), transparent 28%),
                    linear-gradient(145deg, #f6f9ff 0%, #eef3ff 48%, #f9fbff 100%);
            }

            .borrower-panel {
                background: var(--borrower-surface);
                border: 1px solid var(--borrower-border);
                box-shadow: 0 20px 44px -32px rgba(15, 23, 42, 0.24);
                backdrop-filter: blur(10px);
            }

            .borrower-sidebar-link {
                position: relative;
                overflow: hidden;
                transition: transform 0.2s ease, background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
            }

            .borrower-sidebar-link::before {
                content: "";
                position: absolute;
                inset: 0;
                border-radius: 1rem;
                background: linear-gradient(135deg, rgba(37, 99, 235, 0.18), rgba(59, 130, 246, 0.06));
                opacity: 0;
                transition: opacity 0.2s ease;
            }

            .borrower-sidebar-link:hover {
                color: #fff;
                transform: translateX(4px) scale(1.01);
                box-shadow: 0 14px 35px -22px rgba(37, 99, 235, 0.8);
            }

            .borrower-sidebar-link:hover::before,
            .borrower-sidebar-link.active::before {
                opacity: 1;
            }

            .borrower-sidebar-link.active {
                color: #fff;
                transform: translateX(4px);
                box-shadow: 0 18px 40px -24px rgba(37, 99, 235, 0.95);
            }

            .borrower-sidebar-link > * {
                position: relative;
                z-index: 1;
            }

            .borrower-main-shell {
                border: 1px solid rgba(148, 163, 184, 0.22);
                border-radius: 1.75rem;
                background: rgba(255, 255, 255, 0.66);
                box-shadow: 0 18px 46px -36px rgba(15, 23, 42, 0.38);
                backdrop-filter: blur(8px);
                padding: 1.1rem;
            }

            .borrower-user-avatar {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 9999px;
                font-weight: 700;
                letter-spacing: 0.02em;
                color: #eff6ff;
                background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
                box-shadow: 0 12px 28px -18px rgba(37, 99, 235, 0.85);
            }

            .borrower-user-avatar-lg {
                height: 3rem;
                width: 3rem;
                font-size: 1.05rem;
            }

            .borrower-user-avatar-sm {
                height: 2.25rem;
                width: 2.25rem;
                font-size: 0.82rem;
            }

            .borrower-section-title {
                font-size: 1.08rem;
                font-weight: 700;
                color: #0f172a;
            }

            .borrower-section-subtitle {
                margin-top: 0.2rem;
                font-size: 0.92rem;
                color: #64748b;
            }

            .borrower-stat-card {
                border-radius: 1.25rem;
                border: 1px solid rgba(148, 163, 184, 0.2);
                background: linear-gradient(180deg, rgba(255, 255, 255, 0.92) 0%, rgba(248, 250, 252, 0.86) 100%);
                box-shadow: 0 14px 28px -26px rgba(15, 23, 42, 0.55);
            }

            .borrower-soft-card {
                border-radius: 1rem;
                border: 1px solid rgba(148, 163, 184, 0.2);
                background: #fff;
            }

            .borrower-pill {
                display: inline-flex;
                align-items: center;
                border-radius: 9999px;
                padding: 0.3rem 0.7rem;
                font-size: 0.72rem;
                font-weight: 700;
            }

            .borrower-btn-primary {
                border-radius: 0.8rem;
                background: linear-gradient(135deg, var(--borrower-primary) 0%, var(--borrower-primary-strong) 100%);
                color: #fff;
                font-weight: 600;
                transition: filter 0.2s ease, transform 0.15s ease;
            }

            .borrower-btn-primary:hover {
                filter: brightness(1.03);
                transform: translateY(-1px);
            }

            .borrower-table thead tr {
                color: #475569;
                font-size: 0.82rem;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .borrower-table tbody tr:hover {
                background: rgba(239, 246, 255, 0.68);
            }

            @media (min-width: 1024px) {
                .borrower-main-shell {
                    padding: 1.4rem;
                }
            }
        </style>
    </head>
    @php
        $activeUser = Auth::user();
        $userName = $activeUser->name ?? 'Peminjam';
        $userEmail = $activeUser->email ?? 'peminjam@perpustakaan.test';
        $userInitials = \Illuminate\Support\Str::of($userName)
            ->trim()
            ->explode(' ')
            ->filter()
            ->take(2)
            ->map(fn ($part) => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($part, 0, 1)))
            ->implode('');
        $userInitials = $userInitials !== '' ? $userInitials : 'P';
    @endphp
    <body class="borrower-app-shell h-screen overflow-hidden font-sans text-slate-800 antialiased">
        <div x-data="{ sidebarOpen: false }" class="flex h-full overflow-hidden lg:flex">
            <div
                x-show="sidebarOpen"
                x-transition.opacity
                class="fixed inset-0 z-30 bg-slate-950/50 lg:hidden"
                @click="sidebarOpen = false"
            ></div>

            <aside
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-40 flex h-screen w-64 flex-col overflow-y-auto bg-slate-950 px-5 py-6 text-white transition duration-300 lg:static lg:translate-x-0"
                style="background-image: linear-gradient(180deg, #020617 0%, #0f172a 55%, #111827 100%);"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl border border-blue-400/20 bg-blue-500/15 text-lg text-blue-300 shadow-[0_20px_40px_-25px_rgba(59,130,246,0.9)]">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <h1 class="mt-4 text-[1.55rem] font-bold tracking-tight text-white">PERPUSTAKAAN</h1>
                        <p class="mt-1.5 max-w-[13rem] text-[0.82rem] leading-5 text-slate-400">Portal peminjam untuk pinjam, riwayat, dan pantau denda dalam satu dashboard.</p>
                    </div>

                    <button
                        type="button"
                        class="rounded-xl border border-white/10 p-2 text-slate-300 lg:hidden"
                        @click="sidebarOpen = false"
                    >
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <nav class="mt-8 space-y-2">
                    <a href="{{ route('borrower.dashboard') }}" class="borrower-sidebar-link {{ request()->routeIs('borrower.dashboard') ? 'active' : '' }} flex items-center gap-2.5 rounded-2xl px-3.5 py-3 text-[0.9rem] font-medium text-slate-200">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/5 text-blue-300">
                            <i class="fa-solid fa-house w-4"></i>
                        </span>
                        Dashboard
                    </a>
                    <a href="{{ route('borrower.submission') }}" class="borrower-sidebar-link {{ request()->routeIs('borrower.submission') ? 'active' : '' }} flex items-center gap-2.5 rounded-2xl px-3.5 py-3 text-[0.9rem] font-medium text-slate-300">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/5 text-slate-300">
                            <i class="fa-solid fa-book-medical w-4"></i>
                        </span>
                        Ajukan Peminjaman
                    </a>
                    <a href="{{ route('borrower.loans') }}" class="borrower-sidebar-link {{ request()->routeIs('borrower.loans') ? 'active' : '' }} flex items-center gap-2.5 rounded-2xl px-3.5 py-3 text-[0.9rem] font-medium text-slate-300">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/5 text-slate-300">
                            <i class="fa-solid fa-right-left w-4"></i>
                        </span>
                        Peminjaman
                    </a>
                    <a href="{{ route('borrower.loan-history') }}" class="borrower-sidebar-link {{ request()->routeIs('borrower.loan-history') ? 'active' : '' }} flex items-center gap-2.5 rounded-2xl px-3.5 py-3 text-[0.9rem] font-medium text-slate-300">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/5 text-slate-300">
                            <i class="fa-solid fa-clock-rotate-left w-4"></i>
                        </span>
                        Riwayat Peminjaman
                    </a>
                </nav>

                <div class="mt-auto space-y-4 pt-6">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4 shadow-[0_24px_45px_-30px_rgba(15,23,42,0.85)]">
                        <p class="text-[0.68rem] uppercase tracking-[0.28em] text-slate-500">Login Sebagai</p>
                        <div class="mt-2.5 flex items-center gap-2.5">
                            <span class="borrower-user-avatar borrower-user-avatar-lg">{{ $userInitials }}</span>
                            <div class="min-w-0">
                                <p class="truncate text-base font-semibold text-white">{{ $userName }}</p>
                                <p class="truncate text-[0.82rem] text-slate-400">{{ $userEmail }}</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-2xl bg-rose-500 px-4 py-2.5 text-[0.9rem] font-semibold text-white transition hover:bg-rose-600">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

            <div class="min-w-0 flex h-screen flex-1 flex-col lg:ml-0">
                <header class="shrink-0 border-b border-slate-200/70 bg-white/65 backdrop-blur-xl">
                    <div class="mx-auto flex max-w-[100rem] items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-7">
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm lg:hidden"
                                @click="sidebarOpen = true"
                            >
                                <i class="fa-solid fa-bars"></i>
                            </button>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-blue-600">Dashboard Peminjam</p>
                                <h2 class="mt-1 text-xl font-bold leading-tight text-slate-900 sm:text-2xl">
                                    {{ $header ?? 'Layanan perpustakaan digital' }}
                                </h2>
                            </div>
                        </div>

                        <div class="borrower-panel hidden rounded-3xl px-4 py-3 sm:flex sm:items-center sm:gap-3">
                            <a href="{{ route('profile.edit') }}" class="borrower-user-avatar borrower-user-avatar-sm transition hover:brightness-105">{{ $userInitials }}</a>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-900">{{ $userName }}</p>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto px-4 py-5 sm:px-6 lg:px-7">
                    <div class="mx-auto max-w-[100rem]">
                        @if (session('success'))
                            <div class="mb-6 rounded-2xl border border-emerald-200/80 bg-emerald-50/90 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm backdrop-blur">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-6 rounded-2xl border border-rose-200/80 bg-rose-50/90 px-4 py-3 text-sm font-medium text-rose-700 shadow-sm backdrop-blur">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="borrower-main-shell">
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
