@php
    $navigation = [
        ['label' => 'Beranda', 'route' => 'home'],
        ['label' => 'Tentang', 'route' => 'about'],
        ['label' => 'Mahasiswa', 'route' => 'students'],
        ['label' => 'Galeri', 'route' => 'gallery'],
        ['label' => 'Kontak', 'route' => 'contact'],
    ];
    $dashboardLabel = auth()->check() && auth()->user()->isAdmin() ? 'Admin Panel' : 'Dashboard';
@endphp

<header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur-xl dark:border-slate-200 dark:bg-white/95">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img
                src="{{ asset('images/logo-elektro.svg') }}"
                alt="Logo Kelas Elektronika Industri"
                class="h-11 w-11 object-contain"
            >
            <span>
                <span class="block font-display text-base font-bold tracking-wide text-slate-950">{{ $sharedSiteSetting->site_name ?? 'Kelas Elektronika Industri' }}</span>
                <span class="block text-xs text-slate-500">{{ $sharedSiteSetting->department ?? 'Pendidikan Teknik Elektro' }}</span>
            </span>
        </a>

        <div class="hidden items-center gap-3 md:flex">
            <nav class="flex items-center gap-2">
            @foreach ($navigation as $item)
                <a
                    href="{{ route($item['route']) }}"
                    @class([
                        'rounded-full px-4 py-2 text-sm font-medium transition',
                        'bg-yellow-400 text-slate-950 shadow-sm shadow-yellow-400/20' => request()->routeIs($item['route']),
                        'text-slate-500 hover:bg-slate-100 hover:text-slate-950' => ! request()->routeIs($item['route']),
                    ])
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
            </nav>

            <button type="button" onclick="window.toggleTheme()" class="theme-toggle">
                <span class="dark:hidden">Dark</span>
                <span class="hidden dark:inline">Light</span>
            </button>

            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-800 transition hover:bg-slate-100">
                    {{ $dashboardLabel }}
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-800 transition hover:bg-slate-100">
                    Login
                </a>
                <a href="{{ route('register') }}" class="inline-flex rounded-full bg-yellow-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-yellow-300">
                    Register
                </a>
            @endauth
        </div>

        <details class="group relative md:hidden">
            <summary class="flex cursor-pointer list-none items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-800 marker:hidden">
                Menu
                <span class="text-yellow-500 transition group-open:rotate-45">+</span>
            </summary>

            <div class="absolute right-0 mt-3 w-56 rounded-3xl border border-slate-200 bg-white p-3 shadow-2xl shadow-slate-900/15">
                <div class="flex flex-col gap-1">
                    <button type="button" onclick="window.toggleTheme()" class="theme-toggle justify-center">
                        <span class="dark:hidden">Dark Mode</span>
                        <span class="hidden dark:inline">Light Mode</span>
                    </button>

                    @foreach ($navigation as $item)
                        <a
                            href="{{ route($item['route']) }}"
                            @class([
                                'rounded-2xl px-4 py-3 text-sm font-medium transition',
                                'bg-yellow-400 text-slate-950' => request()->routeIs($item['route']),
                                'text-slate-700 hover:bg-slate-100' => ! request()->routeIs($item['route']),
                            ])
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach

                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                            {{ $dashboardLabel }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="rounded-2xl bg-yellow-400 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-yellow-300">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </details>
    </div>
</header>
