<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">Admin</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-950 dark:text-slate-100">Kelola Mahasiswa</h2>
            </div>
            <a href="{{ route('admin.students.create') }}" class="admin-action-primary">Tambah Mahasiswa</a>
        </div>
    </x-slot>

    <div class="admin-shell">
        @include('admin.partials.flash')

        <div class="admin-panel overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Fokus</th>
                        <th>Urutan</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>
                                <p class="font-semibold text-slate-950 dark:text-slate-100">{{ $student->name }}</p>
                                <p class="mt-1 max-w-xl text-sm">{{ $student->bio }}</p>
                            </td>
                            <td>{{ $student->study_focus ?: '-' }}</td>
                            <td>{{ $student->sort_order }}</td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
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
                            <td colspan="4" class="py-8 text-center text-slate-500 dark:text-slate-400">Belum ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
