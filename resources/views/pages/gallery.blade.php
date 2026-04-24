@extends('layouts.public')

@section('content')
    <section class="page-banner">
        <div class="mx-auto max-w-5xl px-4 py-16 text-center sm:px-6 lg:px-8 lg:py-20">
            <p class="section-eyebrow mx-auto">Galeri</p>
            <h1 class="mt-4 font-display text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                Galeri kenangan dan dokumentasi kelas
            </h1>
            <p class="mt-6 text-lg leading-8 text-slate-300">
                Grid berikut menampilkan placeholder foto dengan judul dan deskripsi singkat untuk memudahkan penggantian
                aset dokumentasi di tahap berikutnya.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-8 rounded-[1.5rem] border border-emerald-200 bg-emerald-50 px-6 py-4 text-sm font-medium text-emerald-700 dark:border-emerald-900/50 dark:bg-emerald-950/30 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        @auth
            @if (auth()->user()->role === 'user')
                <div class="mb-10 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-soft dark:border-slate-800 dark:bg-slate-900/95">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                        <div class="max-w-2xl">
                            <p class="section-eyebrow">Upload User</p>
                            <h2 class="mt-4 font-display text-2xl font-bold text-slate-950 dark:text-slate-100">Tambah foto ke galeri kelas</h2>
                            <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">
                                User biasa sekarang bisa menambahkan dokumentasi sendiri ke galeri publik. Isi judul, deskripsi singkat, lalu unggah gambar.
                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('gallery.upload') }}" enctype="multipart/form-data" class="mt-6 grid gap-6 lg:grid-cols-2">
                        @csrf

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Judul</label>
                            <input name="title" value="{{ old('title') }}" class="form-input" placeholder="Contoh: Praktikum Motor Listrik">
                            @error('title')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Gambar</label>
                            <input name="image" type="file" accept="image/png,image/jpeg,image/jpg,image/webp" class="form-input">
                            @error('image')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="lg:col-span-2">
                            <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Deskripsi</label>
                            <textarea name="description" rows="4" class="form-input" placeholder="Ceritakan singkat momen atau aktivitas pada foto ini.">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="lg:col-span-2">
                            <button type="submit" class="admin-action-primary">Upload ke Galeri</button>
                        </div>
                    </form>
                </div>
            @endif
        @endauth

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($gallery as $item)
                <article class="gallery-card">
                    @if ($item->display_image_url)
                        <img src="{{ $item->display_image_url }}" alt="{{ $item->title }}" class="h-72 w-full rounded-[1.5rem] object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                    @else
                        <div class="gallery-placeholder gallery-placeholder-lg">
                            <span>{{ $item->title }}</span>
                        </div>
                    @endif
                    <div class="mt-5">
                        <h2 class="text-xl font-semibold text-slate-950 dark:text-slate-100">{{ $item->title }}</h2>
                        @if ($item->user)
                            <p class="mt-2 text-sm font-medium text-blue-700 dark:text-blue-300">Diunggah oleh {{ $item->user->name }}</p>
                        @endif
                        <p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-300">{{ $item->description }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
