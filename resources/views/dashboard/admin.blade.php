<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">Role Admin</p>
            <h2 class="mt-1 text-2xl font-bold text-slate-950 dark:text-slate-100">Panel Kelola Website Kelas</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-5 md:grid-cols-4">
                <div class="feature-card">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Mahasiswa</p>
                    <p class="mt-2 text-3xl font-bold text-slate-950 dark:text-slate-100">{{ $studentsCount }}</p>
                    <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">Jumlah profil mahasiswa yang tampil pada website publik.</p>
                </div>
                <div class="feature-card">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Galeri</p>
                    <p class="mt-2 text-3xl font-bold text-slate-950 dark:text-slate-100">{{ $galleryCount }}</p>
                    <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">Jumlah item galeri placeholder yang saat ini dipublikasikan.</p>
                </div>
                <div class="feature-card">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Akun</p>
                    <p class="mt-2 text-3xl font-bold text-slate-950 dark:text-slate-100">{{ $usersCount }}</p>
                    <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">Total akun admin dan user yang terdaftar pada sistem.</p>
                </div>
                <div class="feature-card">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Pesan Kontak</p>
                    <p class="mt-2 text-3xl font-bold text-slate-950 dark:text-slate-100">{{ $messagesCount }}</p>
                    <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">{{ $unreadMessagesCount }} pesan belum dibaca dari halaman kontak publik.</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <section class="feature-card">
                    <p class="section-eyebrow">Kelola Website</p>
                    <h3 class="mt-4 font-display text-2xl font-bold text-slate-950 dark:text-slate-100">Pengaturan Umum</h3>
                    <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300">Ubah nama website, deskripsi hero, isi halaman tentang, CTA, dan kontak publik.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('admin.settings.edit') }}" class="admin-action-primary">Buka Pengaturan</a>
                    </div>
                </section>

                <section class="feature-card">
                    <p class="section-eyebrow">Konten</p>
                    <h3 class="mt-4 font-display text-2xl font-bold text-slate-950 dark:text-slate-100">Mahasiswa & Galeri</h3>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('admin.students.index') }}" class="admin-action-primary">Kelola Mahasiswa</a>
                        <a href="{{ route('admin.gallery.index') }}" class="admin-action">Kelola Galeri</a>
                    </div>
                    <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300">Semua data publik sekarang diambil dari database dan dapat diubah dari panel ini.</p>
                </section>

                <section class="feature-card">
                    <p class="section-eyebrow">Akun & Pesan</p>
                    <h3 class="mt-4 font-display text-2xl font-bold text-slate-950 dark:text-slate-100">Manajemen akses</h3>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('admin.users.index') }}" class="admin-action-primary">Kelola Akun</a>
                        <a href="{{ route('admin.messages.index') }}" class="admin-action">Pesan Kontak</a>
                    </div>
                    <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300">
                        Admin demo saat ini menggunakan email <strong class="text-slate-950 dark:text-slate-100">admin@example.com</strong> dan password <strong class="text-slate-950 dark:text-slate-100">password</strong>.
                    </p>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
