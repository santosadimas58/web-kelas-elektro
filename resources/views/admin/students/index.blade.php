<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">Admin</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-950 dark:text-slate-100">Kelola Mahasiswa</h2>
                <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-300">
                    Seluruh profil mahasiswa yang tampil di website publik dikelola dari halaman ini.
                </p>
            </div>
            <a href="{{ route('admin.students.create') }}" class="admin-action-primary">Tambah Mahasiswa</a>
        </div>
    </x-slot>

    <div class="admin-shell">
        @include('admin.partials.flash')

        <div class="grid gap-4 md:grid-cols-3">
            <article class="admin-panel">
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Mahasiswa</p>
                <p class="mt-2 text-3xl font-bold text-slate-950 dark:text-slate-100">{{ $students->total() }}</p>
            </article>
            <article class="admin-panel">
                <p class="text-sm text-slate-500 dark:text-slate-400">Halaman Aktif</p>
                <p class="mt-2 text-3xl font-bold text-slate-950 dark:text-slate-100">{{ $students->currentPage() }}</p>
            </article>
            <article class="admin-panel">
                <p class="text-sm text-slate-500 dark:text-slate-400">Per Halaman</p>
                <p class="mt-2 text-3xl font-bold text-slate-950 dark:text-slate-100">{{ $students->perPage() }}</p>
            </article>
        </div>

        <div class="admin-panel overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Angkatan</th>
                        <th>Email</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>
                                <div class="flex min-w-[240px] items-center gap-4">
                                    @if ($student->photo_image_url)
                                        <img src="{{ $student->photo_image_url }}" alt="{{ $student->name }}" class="h-14 w-14 rounded-2xl object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                                    @else
                                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-950 text-sm font-bold text-yellow-300 dark:bg-slate-800">
                                            {{ $student->initials }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-slate-950 dark:text-slate-100">{{ $student->name }}</p>
                                        <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400">Urutan {{ $student->sort_order }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $student->nim }}</td>
                            <td>{{ $student->prodi }}</td>
                            <td>{{ $student->angkatan }}</td>
                            <td>{{ $student->email }}</td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.students.show', $student) }}" class="admin-action">Detail</a>
                                    <a href="{{ route('admin.students.edit', $student) }}" class="admin-action">Edit</a>
                                    <form method="POST" action="{{ route('admin.students.destroy', $student) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-danger" onclick="return confirm('Hapus mahasiswa ini?')" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500 dark:text-slate-400">Belum ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-2">
            {{ $students->links() }}
        </div>
    </div>
</x-app-layout>
