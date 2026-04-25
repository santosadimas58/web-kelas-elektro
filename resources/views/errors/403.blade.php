<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <title>403 | Akses Ditolak</title>
        <meta name="description" content="Halaman ini tidak dapat diakses karena izin tidak mencukupi.">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
        <main class="flex min-h-screen items-center justify-center px-4 py-12">
            <section class="w-full max-w-2xl rounded-[2rem] border border-slate-200 bg-white p-8 text-center shadow-soft dark:border-slate-800 dark:bg-slate-900 sm:p-12">
                <p class="section-eyebrow">403</p>
                <h1 class="mt-4 font-display text-4xl font-bold tracking-tight text-slate-950 dark:text-slate-100">Akses Ditolak</h1>
                <p class="mt-4 text-base leading-8 text-slate-600 dark:text-slate-300">
                    Anda tidak memiliki izin untuk membuka halaman ini. Kembali ke dashboard atau kembali ke website publik.
                </p>
                <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                    <a href="{{ route('home') }}" class="admin-action-primary">Ke Beranda</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="admin-action">Ke Dashboard</a>
                    @endauth
                </div>
            </section>
        </main>
    </body>
</html>
