@extends('layouts.public')

@section('content')
    <section class="page-banner">
        <div class="mx-auto max-w-5xl px-4 py-16 text-center sm:px-6 lg:px-8 lg:py-20">
                <p class="section-eyebrow mx-auto">Mahasiswa</p>
                <h1 class="mt-4 font-display text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                Profil mahasiswa {{ $siteSetting->site_name }}
            </h1>
            <p class="mt-6 text-lg leading-8 text-slate-300">
                Seluruh kartu mahasiswa di bawah kini dapat dikelola penuh dari panel admin.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between gap-4 rounded-[1.75rem] border border-slate-200 bg-white px-6 py-5 shadow-soft dark:border-slate-800 dark:bg-slate-900">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">Total Mahasiswa</p>
                <h2 class="mt-2 font-display text-2xl font-bold text-slate-950 dark:text-slate-100">{{ $students->count() }} Orang</h2>
            </div>
            <p class="max-w-xl text-sm leading-7 text-slate-600 dark:text-slate-300">
                Halaman ini sekarang otomatis menampilkan akun user yang terdaftar, sehingga jumlah kartu selalu mengikuti total akun user aktif.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($students as $student)
                <article class="student-card">
                    @if ($student->profile_photo_url)
                        <img src="{{ $student->profile_photo_url }}" alt="{{ $student->name }}" class="h-52 w-full rounded-[1.75rem] object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                    @else
                        <div class="student-photo">
                            <span class="student-avatar-large">{{ $student->initials }}</span>
                        </div>
                    @endif
                    <div class="mt-6">
                        <h2 class="text-xl font-semibold text-slate-950 dark:text-slate-100">{{ $student->name }}</h2>
                        <p class="mt-2 text-sm font-medium text-blue-700 dark:text-blue-300">User Kelas</p>
                        <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">
                            Akun ini terdaftar pada sistem website kelas dan dapat mengelola profilnya sendiri melalui dashboard pengguna.
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
