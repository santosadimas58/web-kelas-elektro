@extends('layouts.public')

@section('content')
    <section class="hero-section overflow-hidden bg-slate-950 text-white">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-20 sm:px-6 lg:grid-cols-[1.15fr_0.85fr] lg:px-8 lg:py-24">
            <div class="relative z-10">
                <p class="inline-flex rounded-full border border-white/15 bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-yellow-300">
                    Dokumentasi Kelas
                </p>
                <h1 class="mt-6 max-w-3xl font-display text-4xl font-extrabold tracking-tight text-balance sm:text-5xl lg:text-6xl">
                    {{ $siteSetting->hero_title }}
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                    {{ $siteSetting->hero_description }}
                </p>

                <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                    <a href="{{ route('students') }}" class="inline-flex items-center justify-center rounded-full bg-yellow-400 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-yellow-300">
                        Lihat Profil Mahasiswa
                    </a>
                    <a href="{{ route('gallery') }}" class="inline-flex items-center justify-center rounded-full border border-white/15 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                        Jelajahi Galeri Kelas
                    </a>
                </div>

                <div class="mt-12 grid gap-4 sm:grid-cols-3">
                    <div class="hero-glass rounded-3xl border border-white/10 p-5">
                        <p class="text-sm text-slate-300">Total Mahasiswa</p>
                        <p class="mt-2 text-3xl font-bold text-white">{{ $students->count() }}</p>
                    </div>
                    <div class="hero-glass rounded-3xl border border-white/10 p-5">
                        <p class="text-sm text-slate-300">Halaman Publik</p>
                        <p class="mt-2 text-3xl font-bold text-white">5</p>
                    </div>
                    <div class="hero-glass rounded-3xl border border-white/10 p-5">
                        <p class="text-sm text-slate-300">Nuansa Website</p>
                        <p class="mt-2 text-xl font-bold text-white">Profesional & Hangat</p>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -left-8 top-0 h-40 w-40 rounded-full bg-yellow-400/20 blur-3xl"></div>
                <div class="absolute bottom-4 right-0 h-56 w-56 rounded-full bg-blue-400/15 blur-3xl"></div>

                <div class="hero-glass relative rounded-[2rem] border border-white/10 p-6 shadow-2xl shadow-slate-950/30">
                    <div class="rounded-[1.5rem] border border-white/10 bg-slate-900/80 p-6">
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-yellow-300">Kelas</p>
                        <h2 class="mt-3 font-display text-2xl font-bold text-white">{{ $siteSetting->site_name }}</h2>
                        <p class="mt-3 leading-7 text-slate-300">
                            {{ $siteSetting->tagline }}
                        </p>

                        <div class="mt-8 grid gap-4 sm:grid-cols-2">
                            @foreach ($students->take(4) as $student)
                                <div class="rounded-3xl bg-white px-4 py-4 text-slate-900 shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-950 text-sm font-bold text-yellow-300">
                                            {{ $student->initials }}
                                        </div>
                                        <div>
                                            <p class="font-semibold">{{ $student->name }}</p>
                                            <p class="text-sm text-slate-500">{{ $student->study_focus ?: 'Mahasiswa Kelas' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
            <div class="space-y-4">
                <p class="section-eyebrow">Tentang Kelas</p>
                <h2 class="section-title">Dokumentasi kelas yang terasa dekat, rapi, dan mudah dikembangkan.</h2>
                <p class="section-copy">
                    Fokus utama website ini adalah menjadi arsip visual dan naratif untuk {{ strtolower($siteSetting->site_name) }}.
                    Pengunjung bisa melihat ringkasan kelas, profil mahasiswa, serta galeri yang mudah diperbarui dari panel admin.
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="feature-card">
                    <h3 class="feature-title">Profil 10 Mahasiswa</h3>
                    <p class="feature-copy">
                        Struktur kartu mahasiswa sudah disiapkan agar foto, nama, dan bio bisa diganti dengan data asli.
                    </p>
                </div>
                <div class="feature-card">
                    <h3 class="feature-title">Galeri Kenangan</h3>
                    <p class="feature-copy">
                        Grid galeri menampilkan dokumentasi placeholder yang siap diisi foto kegiatan kelas.
                    </p>
                </div>
                <div class="feature-card">
                    <h3 class="feature-title">Tentang Program Studi</h3>
                    <p class="feature-copy">
                        Halaman khusus menjelaskan peran PTE secara singkat dan mudah dipahami pengunjung umum.
                    </p>
                </div>
                <div class="feature-card">
                    <h3 class="feature-title">Kontak Sederhana</h3>
                    <p class="feature-copy">
                        Form publik tersedia tanpa login sehingga cocok untuk tahap awal website dokumentasi kelas.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="section-eyebrow">Preview Mahasiswa</p>
                    <h2 class="section-title">Beberapa wajah dari angkatan yang membangun cerita kelas.</h2>
                </div>
                <a href="{{ route('students') }}" class="text-sm font-semibold text-slate-950 transition hover:text-blue-700 dark:text-slate-100 dark:hover:text-blue-300">
                    Lihat semua mahasiswa
                </a>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($students->take(4) as $student)
                    <article class="student-card">
                        <div class="student-avatar">{{ $student->initials }}</div>
                        <div class="mt-5">
                            <h3 class="text-lg font-semibold text-slate-950 dark:text-slate-100">{{ $student->name }}</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">{{ $student->bio }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="section-eyebrow">Preview Galeri</p>
                <h2 class="section-title">Cuplikan momen yang mewakili proses belajar dan kebersamaan kelas.</h2>
            </div>
            <a href="{{ route('gallery') }}" class="text-sm font-semibold text-slate-950 transition hover:text-blue-700 dark:text-slate-100 dark:hover:text-blue-300">
                Buka galeri lengkap
            </a>
        </div>

        <div class="mt-10 grid gap-6 lg:grid-cols-3">
            @foreach ($gallery->take(3) as $item)
                <article class="gallery-card">
                    @if ($item->image_url)
                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="h-56 w-full rounded-[1.5rem] object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                    @else
                        <div class="gallery-placeholder">
                            <span>{{ $item->title }}</span>
                        </div>
                    @endif
                    <div class="mt-5">
                        <h3 class="text-lg font-semibold text-slate-950 dark:text-slate-100">{{ $item->title }}</h3>
                        <p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-300">{{ $item->description }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="cta-panel">
                <div>
                    <p class="section-eyebrow text-yellow-300">Jelajahi Dokumentasi</p>
                    <h2 class="font-display text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        {{ $siteSetting->cta_title }}
                    </h2>
                    <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300 sm:text-base">
                        {{ $siteSetting->cta_description }}
                    </p>
                </div>
                <div class="flex flex-col gap-4 sm:flex-row">
                    <a href="{{ route('about') }}" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                        Baca Tentang Kelas
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-full border border-white/15 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                        Hubungi Kelas
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
