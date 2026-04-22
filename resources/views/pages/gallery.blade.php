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
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($gallery as $item)
                <article class="gallery-card">
                    @if ($item->image_url)
                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="h-72 w-full rounded-[1.5rem] object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                    @else
                        <div class="gallery-placeholder gallery-placeholder-lg">
                            <span>{{ $item->title }}</span>
                        </div>
                    @endif
                    <div class="mt-5">
                        <h2 class="text-xl font-semibold text-slate-950 dark:text-slate-100">{{ $item->title }}</h2>
                        <p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-300">{{ $item->description }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
