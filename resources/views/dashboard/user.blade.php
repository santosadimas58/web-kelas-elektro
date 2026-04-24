<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">Role User</p>
            <h2 class="mt-1 text-2xl font-bold text-slate-950 dark:text-slate-100">Dashboard Pengguna</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8">
            <section class="feature-card">
                <p class="section-eyebrow">Selamat Datang</p>
                <div class="mt-4 flex flex-col gap-5 sm:flex-row sm:items-center">
                    @if ($user->profile_photo_url)
                        <div class="h-24 w-24 shrink-0 overflow-hidden rounded-[2rem] ring-1 ring-slate-200 dark:ring-slate-700">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                        </div>
                    @else
                        <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-[2rem] bg-slate-950 text-3xl font-bold text-yellow-300 dark:bg-slate-800">
                            {{ $user->initials }}
                        </div>
                    @endif

                    <div class="min-w-0">
                        <h3 class="font-display text-3xl font-bold text-slate-950 dark:text-slate-100">{{ $user->name }}</h3>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                    </div>
                </div>
                <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">
                    Anda masuk sebagai user biasa. Sekarang akun ini bisa dipakai untuk mengatur foto profil pribadi agar identitas akun terasa lebih lengkap.
                </p>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl bg-slate-100 p-5 dark:bg-slate-800">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Role</p>
                        <p class="mt-2 text-xl font-bold text-slate-950 dark:text-slate-100">{{ ucfirst($user->role) }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-100 p-5 dark:bg-slate-800">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Konten Publik</p>
                        <p class="mt-2 text-base font-semibold text-slate-950 dark:text-slate-100">{{ $studentsCount }} mahasiswa / {{ $galleryCount }} galeri</p>
                    </div>
                    <div class="rounded-3xl bg-slate-100 p-5 dark:bg-slate-800 sm:col-span-2">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Foto Profil</p>
                        <p class="mt-2 text-base font-semibold text-slate-950 dark:text-slate-100">{{ $user->profile_photo_url ? 'Sudah diunggah dan aktif di akun Anda.' : 'Belum ada foto. Tambahkan lewat Edit Profil.' }}</p>
                    </div>
                </div>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('home') }}" class="inline-flex rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-900">Kembali ke Website</a>
                    <a href="{{ route('profile.edit') }}" class="inline-flex rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-800 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-100 dark:hover:bg-slate-800">Edit Profil</a>
                </div>
            </section>

            <section class="feature-card">
                <p class="section-eyebrow">Konten Publik</p>
                <h3 class="mt-4 font-display text-2xl font-bold text-slate-950 dark:text-slate-100">Ringkasan website kelas</h3>
                <div class="mt-6 space-y-4 text-sm leading-7 text-slate-600 dark:text-slate-300">
                    <p>Website publik saat ini menampilkan {{ $studentsCount }} profil mahasiswa dan {{ $galleryCount }} item galeri.</p>
                    <p>User biasa dapat melihat website, mengelola profil akun sendiri, dan menggunakan akses login sesuai kebutuhan pengguna umum.</p>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
