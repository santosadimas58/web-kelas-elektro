<footer class="border-t border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-950">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[1.4fr_1fr_1fr] lg:px-8">
        <div class="space-y-4">
            <p class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                Dokumentasi Kelas
            </p>
            <div>
                <h2 class="font-display text-2xl font-bold text-slate-950 dark:text-slate-100">{{ $sharedSiteSetting->site_name ?? 'Kelas Elektronika Industri' }}</h2>
                <p class="mt-2 max-w-xl text-sm leading-7 text-slate-600 dark:text-slate-300">
                    {{ $sharedSiteSetting->tagline ?? 'Website ini menjadi ruang sederhana untuk menyimpan cerita kelas, menampilkan profil mahasiswa, dan merawat kenangan selama proses belajar bersama.' }}
                </p>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Navigasi</h3>
            <div class="mt-4 flex flex-col gap-3 text-sm text-slate-600 dark:text-slate-300">
                <a href="{{ route('home') }}" class="transition hover:text-slate-950 dark:hover:text-white">Beranda</a>
                <a href="{{ route('about') }}" class="transition hover:text-slate-950 dark:hover:text-white">Tentang</a>
                <a href="{{ route('students') }}" class="transition hover:text-slate-950 dark:hover:text-white">Mahasiswa</a>
                <a href="{{ route('gallery') }}" class="transition hover:text-slate-950 dark:hover:text-white">Galeri</a>
                <a href="{{ route('contact') }}" class="transition hover:text-slate-950 dark:hover:text-white">Kontak</a>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Kontak Kelas</h3>
            <div class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                <p>{{ $sharedSiteSetting->contact_email ?? '-' }}</p>
                <p>{{ $sharedSiteSetting->contact_phone ?? '-' }}</p>
                <p>{{ $sharedSiteSetting->contact_instagram ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="border-t border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-900">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-5 text-sm text-slate-500 dark:text-slate-400 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
            <p>&copy; {{ now()->year }} {{ $sharedSiteSetting->site_name ?? 'Kelas Elektronika Industri' }} - {{ $sharedSiteSetting->department ?? 'Pendidikan Teknik Elektro' }}.</p>
            <p>{{ $sharedSiteSetting->note ?? '' }}</p>
        </div>
    </div>
</footer>
