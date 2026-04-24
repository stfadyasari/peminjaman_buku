<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --admin-bg: #f3f6fb;
                --admin-surface: #ffffff;
                --admin-line: #e2e8f0;
                --admin-text: #0f172a;
                --admin-subtle: #64748b;
                --admin-accent: #0f766e;
                --admin-accent-soft: #ccfbf1;
            }

            .admin-app-shell {
                background:
                    radial-gradient(circle at 100% 0%, rgba(15, 118, 110, 0.08), transparent 22%),
                    radial-gradient(circle at 0% 100%, rgba(14, 116, 144, 0.08), transparent 26%),
                    var(--admin-bg);
            }

            .admin-panel {
                background: var(--admin-surface);
                border: 1px solid var(--admin-line);
                box-shadow: 0 14px 30px -24px rgba(15, 23, 42, 0.45);
            }

            .admin-sidebar-link {
                position: relative;
                overflow: hidden;
                transition: transform 0.2s ease, background-color 0.2s ease, color 0.2s ease;
            }

            .admin-sidebar-link::before {
                content: "";
                position: absolute;
                inset: 0;
                border-radius: 1rem;
                background: linear-gradient(135deg, rgba(15, 118, 110, 0.2), rgba(15, 118, 110, 0.06));
                opacity: 0;
                transition: opacity 0.2s ease;
            }

            .admin-sidebar-link:hover {
                color: #fff;
                transform: translateX(3px);
            }

            .admin-sidebar-link:hover::before,
            .admin-sidebar-link.active::before {
                opacity: 1;
            }

            .admin-sidebar-link.active {
                color: #fff;
                transform: translateX(3px);
            }

            .admin-sidebar-link > * {
                position: relative;
                z-index: 1;
            }

            .admin-grid-row {
                transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease, background-color 0.18s ease;
            }

            .admin-grid-row:nth-child(odd) {
                background: rgba(248, 250, 252, 0.72);
            }

            .admin-grid-row:hover {
                transform: translateY(-2px);
                background: rgba(239, 246, 255, 0.9);
                border-color: rgba(96, 165, 250, 0.4);
                box-shadow: 0 20px 40px -28px rgba(37, 99, 235, 0.5);
            }

            .admin-content-area {
                position: relative;
                background:
                    linear-gradient(180deg, rgba(255, 255, 255, 0.86) 0%, rgba(248, 250, 252, 0.88) 100%),
                    radial-gradient(circle at 12% 18%, rgba(20, 184, 166, 0.08), transparent 32%),
                    radial-gradient(circle at 88% 86%, rgba(14, 165, 233, 0.08), transparent 30%);
                overflow: hidden;
            }

            .admin-content-area::before {
                content: "";
                position: absolute;
                inset: 0;
                pointer-events: none;
                background-image:
                    linear-gradient(to right, rgba(148, 163, 184, 0.11) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(148, 163, 184, 0.11) 1px, transparent 1px);
                background-size: 26px 26px;
                mask-image: linear-gradient(180deg, rgba(15, 23, 42, 0.22), transparent 70%);
            }

            .admin-main-shell {
                border: 1px solid rgba(226, 232, 240, 0.85);
                border-radius: 2rem;
                background: rgba(255, 255, 255, 0.58);
                box-shadow: 0 20px 55px -42px rgba(15, 23, 42, 0.45);
                backdrop-filter: blur(8px);
                padding: 1.2rem;
            }

            .admin-user-avatar {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 9999px;
                font-weight: 700;
                letter-spacing: 0.02em;
                color: #f8fafc;
                background: linear-gradient(135deg, #0f766e 0%, #0284c7 100%);
                box-shadow: 0 14px 30px -18px rgba(14, 116, 144, 0.75);
            }

            .admin-user-avatar-lg {
                height: 3rem;
                width: 3rem;
                font-size: 1.05rem;
            }

            .admin-user-avatar-sm {
                height: 2.25rem;
                width: 2.25rem;
                font-size: 0.82rem;
            }

            @media (min-width: 1024px) {
                .admin-main-shell {
                    padding: 1.6rem;
                }
            }

            /* Perbesar keterbacaan area konten admin (di luar sidebar). */
            .admin-content-area .text-xs { font-size: 0.84rem; }
            .admin-content-area .text-sm { font-size: 1rem; }
            .admin-content-area .text-base { font-size: 1.08rem; }
            .admin-content-area .text-lg { font-size: 1.2rem; }
            .admin-content-area .text-xl { font-size: 1.34rem; }
            .admin-content-area .text-2xl { font-size: 1.62rem; }
            .admin-content-area .text-3xl { font-size: 1.95rem; }
            .admin-content-area .text-4xl { font-size: 2.35rem; }
        </style>
    </head>
    @php
        $activeUser = Auth::user();
        $userName = $activeUser->name ?? 'Admin';
        $userEmail = $activeUser->email ?? 'admin@perpustakaan.test';
        $userInitials = \Illuminate\Support\Str::of($userName)
            ->trim()
            ->explode(' ')
            ->filter()
            ->take(2)
            ->map(fn ($part) => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($part, 0, 1)))
            ->implode('');
        $userInitials = $userInitials !== '' ? $userInitials : 'A';
    @endphp
    <body class="admin-app-shell h-screen overflow-hidden text-slate-800 antialiased" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <div x-data="{ sidebarOpen: false }" class="flex h-full overflow-hidden lg:flex">
            <div
                x-show="sidebarOpen"
                x-transition.opacity
                class="fixed inset-0 z-30 bg-slate-950/50 lg:hidden"
                @click="sidebarOpen = false"
            ></div>

            <aside
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-40 flex h-screen w-80 flex-col overflow-y-auto bg-slate-950 px-6 py-6 text-white transition duration-300 lg:static lg:translate-x-0 xl:w-[21rem]"
                style="background-image: linear-gradient(180deg, #042f2e 0%, #0f172a 55%, #111827 100%);"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <div class="inline-flex h-14 w-14 items-center justify-center rounded-3xl border border-teal-300/20 bg-teal-400/15 text-xl text-teal-200 shadow-[0_20px_40px_-25px_rgba(20,184,166,0.8)]">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <h1 class="mt-5 text-[1.7rem] font-bold tracking-tight text-white">Perpustakaan</h1>
                        <p class="mt-2 max-w-[14rem] text-sm leading-6 text-slate-300">Panel admin sederhana, modern, dan fokus pada operasional harian.</p>
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
                    <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-medium text-slate-200">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/5 text-teal-200">
                            <i class="fa-solid fa-house w-5"></i>
                        </span>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }} flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-medium text-slate-300">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/5 text-slate-300">
                            <i class="fa-solid fa-book w-5"></i>
                        </span>
                        Kelola Buku
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.members.*') ? 'active' : '' }} flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-medium text-slate-300">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/5 text-slate-300">
                            <i class="fa-solid fa-users w-5"></i>
                        </span>
                        Anggota
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.transactions.*') || request()->routeIs('admin.loans.*') || request()->routeIs('admin.returns.*') || request()->routeIs('admin.fines.*') ? 'active' : '' }} flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-medium text-slate-300">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/5 text-slate-300">
                            <i class="fa-solid fa-right-left w-5"></i>
                        </span>
                        Transaksi
                    </a>
                    <a href="{{ route('admin.logs.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }} flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-medium text-slate-300">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/5 text-slate-300">
                            <i class="fa-solid fa-clipboard-list w-5"></i>
                        </span>
                        Log Aktivitas
                    </a>
                </nav>

                <div class="mt-auto space-y-4 pt-6">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 shadow-[0_24px_45px_-30px_rgba(15,23,42,0.85)]">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Login Sebagai</p>
                        <div class="mt-3 flex items-center gap-3">
                            <span class="admin-user-avatar admin-user-avatar-lg">{{ $userInitials }}</span>
                            <div class="min-w-0">
                                <p class="truncate text-lg font-semibold text-white">{{ $userName }}</p>
                                <p class="truncate text-sm text-slate-400">{{ $userEmail }}</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-2xl bg-rose-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-rose-600">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

            <div class="admin-content-area min-w-0 flex h-screen flex-1 flex-col lg:ml-0">
                <header class="shrink-0 border-b border-slate-200 bg-white/85 backdrop-blur">
                    <div class="mx-auto flex max-w-[116rem] items-center justify-between gap-4 px-4 py-5 sm:px-6 lg:px-7">
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm lg:hidden"
                                @click="sidebarOpen = true"
                            >
                                <i class="fa-solid fa-bars"></i>
                            </button>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-teal-700">Admin Panel</p>
                                <h2 class="mt-1 text-xl font-bold leading-tight text-slate-900 sm:text-2xl">
                                    {{ $header ?? 'Ringkasan aktivitas perpustakaan' }}
                                </h2>
                            </div>
                        </div>

                        <div class="admin-panel hidden rounded-3xl px-4 py-3 sm:flex sm:items-center sm:gap-3">
                            <a href="{{ route('profile.edit') }}" class="admin-user-avatar admin-user-avatar-sm transition hover:brightness-105">{{ $userInitials }}</a>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-900">{{ $userName }}</p>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto px-4 py-6 sm:px-6 lg:px-7">
                    <div class="mx-auto max-w-[116rem]">
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

                        <div class="admin-main-shell">
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
