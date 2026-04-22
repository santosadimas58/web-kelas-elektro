@extends('layouts.public')

@section('content')
    <section class="page-banner">
        <div class="mx-auto max-w-5xl px-4 py-16 text-center sm:px-6 lg:px-8 lg:py-20">
            <p class="section-eyebrow mx-auto">Kontak</p>
            <h1 class="mt-4 font-display text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                Hubungi dan kenali identitas kelas
            </h1>
            <p class="mt-6 text-lg leading-8 text-slate-300">
                Form kontak ini masih sederhana dan belum terhubung ke sistem admin, sesuai fokus tahap awal website publik.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="rounded-[2rem] bg-white p-8 shadow-soft ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800 sm:p-10">
                <div class="max-w-2xl">
                    <p class="section-eyebrow">Form Kontak</p>
                    <h2 class="mt-4 font-display text-3xl font-bold tracking-tight text-slate-950 dark:text-slate-100">
                        Kirim pesan singkat untuk kelas
                    </h2>
                </div>

                @if (session('status'))
                    <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="mt-8 space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Nama</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            class="form-input"
                            placeholder="Nama lengkap"
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            class="form-input"
                            placeholder="nama@email.com"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Pesan</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            class="form-input min-h-36"
                            placeholder="Tulis pesan singkat..."
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-900">
                        Kirim Pesan
                    </button>
                </form>
            </div>

            <aside class="space-y-6">
                <div class="rounded-[2rem] bg-slate-950 p-8 text-white shadow-soft sm:p-10">
                    <p class="section-eyebrow text-yellow-300">Identitas Kelas</p>
                    <h2 class="mt-4 font-display text-3xl font-bold tracking-tight">{{ $siteSetting->site_name }}</h2>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        {{ $siteSetting->contact_description }}
                    </p>
                </div>

                <div class="rounded-[2rem] bg-white p-8 shadow-soft ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800 sm:p-10">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">Kontak Sederhana</h3>
                    <div class="mt-6 space-y-5 text-sm leading-7 text-slate-600 dark:text-slate-300">
                        <p><strong class="text-slate-950 dark:text-slate-100">Email:</strong> {{ $siteSetting->contact_email }}</p>
                        <p><strong class="text-slate-950 dark:text-slate-100">Telepon:</strong> {{ $siteSetting->contact_phone }}</p>
                        <p><strong class="text-slate-950 dark:text-slate-100">Instagram:</strong> {{ $siteSetting->contact_instagram }}</p>
                        <p><strong class="text-slate-950 dark:text-slate-100">Lokasi:</strong> {{ $siteSetting->contact_location }}</p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
