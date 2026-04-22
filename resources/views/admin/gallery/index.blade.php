<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">Admin</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-950 dark:text-slate-100">Kelola Galeri</h2>
            </div>
            <a href="{{ route('admin.gallery.create') }}" class="admin-action-primary">Tambah Item</a>
        </div>
    </x-slot>

    <div class="admin-shell">
        @include('admin.partials.flash')

        <div class="admin-panel overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Galeri</th>
                        <th>Gambar</th>
                        <th>Urutan</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>
                                <p class="font-semibold text-slate-950 dark:text-slate-100">{{ $item->title }}</p>
                                <p class="mt-1 max-w-xl text-sm">{{ $item->description }}</p>
                            </td>
                            <td>{{ $item->image_url ? 'Ada URL' : 'Placeholder' }}</td>
                            <td>{{ $item->sort_order }}</td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.gallery.edit', $item) }}" class="admin-action">Edit</a>
                                    <form method="POST" action="{{ route('admin.gallery.destroy', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-danger" onclick="return confirm('Hapus item galeri ini?')" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-500 dark:text-slate-400">Belum ada item galeri.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
