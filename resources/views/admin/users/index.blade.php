<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">Admin</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-950 dark:text-slate-100">Kelola Akun</h2>
            </div>
            <a href="{{ route('admin.users.create') }}" class="admin-action-primary">Tambah Akun</a>
        </div>
    </x-slot>

    <div class="admin-shell">
        @include('admin.partials.flash')

        <div class="admin-panel overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="font-semibold text-slate-950 dark:text-slate-100">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="status-badge {{ $user->role === 'admin' ? 'status-badge-admin' : 'status-badge-user' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="admin-action">Edit</a>
                                    @if (auth()->id() !== $user->id)
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="admin-danger" onclick="return confirm('Hapus akun ini?')" type="submit">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-500 dark:text-slate-400">Belum ada akun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
