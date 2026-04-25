<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">Admin</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-950 dark:text-slate-100">Detail Mahasiswa</h2>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.students.index') }}" class="admin-action">Kembali</a>
                <a href="{{ route('admin.students.edit', $student) }}" class="admin-action-primary">Edit Data</a>
            </div>
        </div>
    </x-slot>

    <div class="admin-shell">
        @include('admin.partials.flash')

        <section class="admin-panel">
            <div class="grid gap-8 lg:grid-cols-[320px_1fr] lg:items-start">
                <div>
                    @if ($student->photo_image_url)
                        <img src="{{ $student->photo_image_url }}" alt="{{ $student->name }}" class="h-80 w-full rounded-[2rem] object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                    @else
                        <div class="flex h-80 w-full items-center justify-center rounded-[2rem] bg-slate-950 text-6xl font-bold text-yellow-300 dark:bg-slate-800">
                            {{ $student->initials }}
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">Profil Mahasiswa</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-950 dark:text-slate-100">{{ $student->name }}</h3>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <article class="rounded-[1.5rem] border border-slate-200 bg-white/90 p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800/80">
                            <p class="text-sm text-slate-500 dark:text-slate-400">NIM</p>
                            <p class="mt-2 text-lg font-semibold text-slate-950 dark:text-slate-100">{{ $student->nim ?: '-' }}</p>
                        </article>
                        <article class="rounded-[1.5rem] border border-slate-200 bg-white/90 p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800/80">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Program Studi</p>
                            <p class="mt-2 text-lg font-semibold text-slate-950 dark:text-slate-100">{{ $student->prodi ?: '-' }}</p>
                        </article>
                        <article class="rounded-[1.5rem] border border-slate-200 bg-white/90 p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800/80">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Angkatan</p>
                            <p class="mt-2 text-lg font-semibold text-slate-950 dark:text-slate-100">{{ $student->angkatan ?: '-' }}</p>
                        </article>
                        <article class="rounded-[1.5rem] border border-slate-200 bg-white/90 p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800/80">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Email</p>
                            <p class="mt-2 text-lg font-semibold text-slate-950 dark:text-slate-100">{{ $student->email ?: '-' }}</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
