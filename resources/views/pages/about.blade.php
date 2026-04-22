@extends('layouts.public')

@section('content')
    <section class="page-banner">
        <div class="mx-auto max-w-5xl px-4 py-16 text-center sm:px-6 lg:px-8 lg:py-20">
            <p class="section-eyebrow mx-auto">Tentang</p>
            <h1 class="mt-4 font-display text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                Gambaran singkat {{ $siteSetting->about_title }}
            </h1>
            <p class="mt-6 text-lg leading-8 text-slate-300">
                Halaman ini menjelaskan konteks akademik kelas tanpa mengubah karakter website sebagai dokumentasi
                angkatan yang hangat dan informal.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="space-y-8 rounded-[2rem] bg-white p-8 shadow-soft ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800 sm:p-10">
            <div>
                <p class="section-eyebrow">Program Studi</p>
                <h2 class="mt-4 font-display text-3xl font-bold tracking-tight text-slate-950 dark:text-slate-100">
                    {{ $siteSetting->about_title }}
                </h2>
            </div>

            <p class="text-lg leading-9 text-slate-700 dark:text-slate-300">
                {{ $siteSetting->about_text }}
            </p>

            <div class="grid gap-5 md:grid-cols-3">
                <div class="feature-card">
                    <h3 class="feature-title">Teknik Elektro</h3>
                    <p class="feature-copy">
                        Memadukan pemahaman arus kuat dan arus lemah dalam konteks pembelajaran vokasional.
                    </p>
                </div>
                <div class="feature-card">
                    <h3 class="feature-title">Ilmu Kependidikan</h3>
                    <p class="feature-copy">
                        Membekali mahasiswa dengan kemampuan pedagogis untuk mengajar secara efektif.
                    </p>
                </div>
                <div class="feature-card">
                    <h3 class="feature-title">Arah Lulusan</h3>
                    <p class="feature-copy">
                        Siap menjadi guru SMK, instruktur, atau praktisi teknik yang memahami dunia pendidikan.
                    </p>
                </div>
            </div>

            <div class="rounded-[1.75rem] bg-slate-950 px-6 py-6 text-sm leading-7 text-slate-300">
                <strong class="font-semibold text-white">Catatan:</strong> {{ $siteSetting->note }}
            </div>
        </div>
    </section>
@endsection
