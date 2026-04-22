<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Auth | {{ config('classroom.site_name') }}</title>

        @include('layouts.partials.theme-head')

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
        <div class="min-h-screen flex flex-col items-center justify-center bg-slate-100 px-4 py-10 dark:bg-slate-950">
            <div class="mb-6 flex w-full max-w-md justify-end">
                <button type="button" onclick="window.toggleTheme()" class="theme-toggle">
                    <span class="dark:hidden">Dark</span>
                    <span class="hidden dark:inline">Light</span>
                </button>
            </div>
            <div>
                <a href="/">
                    <div class="flex items-center gap-3">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-yellow-400 text-sm font-bold text-slate-950 shadow-lg shadow-yellow-500/20">
                            EI
                        </span>
                        <div>
                            <p class="font-display text-lg font-bold text-slate-950 dark:text-slate-100">Kelas Elektronika Industri</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Pendidikan Teknik Elektro</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="mt-6 w-full max-w-md overflow-hidden rounded-[2rem] border border-slate-200 bg-white px-6 py-6 shadow-xl shadow-slate-900/5 dark:border-slate-800 dark:bg-slate-900 sm:px-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
