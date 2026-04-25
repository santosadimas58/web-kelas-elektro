<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">Admin</p>
            <h2 class="mt-1 text-2xl font-bold text-slate-950 dark:text-slate-100">Tambah Item Galeri</h2>
        </div>
    </x-slot>

    <div class="admin-shell">
        @include('admin.partials.flash')

        <form method="POST" action="{{ route('admin.gallery.store') }}" class="admin-panel space-y-6">
            @csrf
            @include('admin.gallery._form')
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.gallery.index') }}" class="admin-action">Batal</a>
                <button class="admin-action-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
