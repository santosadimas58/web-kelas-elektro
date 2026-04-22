<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-950 dark:text-slate-100">Edit Akun</h2>
    </x-slot>

    <div class="admin-shell">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="admin-panel space-y-6">
            @csrf
            @method('PUT')
            @include('admin.users._form')
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="admin-action">Batal</a>
                <button class="admin-action-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
