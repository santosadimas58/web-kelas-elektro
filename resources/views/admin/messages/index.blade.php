<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">Admin</p>
            <h2 class="mt-1 text-2xl font-bold text-slate-950 dark:text-slate-100">Pesan Kontak</h2>
        </div>
    </x-slot>

    <div class="admin-shell">
        @include('admin.partials.flash')

        <div class="space-y-4">
            @forelse ($messages as $message)
                <article class="admin-panel">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <div class="flex items-center gap-3">
                                <h3 class="text-lg font-semibold text-slate-950 dark:text-slate-100">{{ $message->name }}</h3>
                                <span class="status-badge {{ $message->is_read ? 'status-badge-read' : 'status-badge-unread' }}">
                                    {{ $message->is_read ? 'read' : 'unread' }}
                                </span>
                            </div>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $message->email }}</p>
                            <p class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-600 dark:text-slate-300">{{ $message->message }}</p>
                        </div>

                        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}">
                            @csrf
                            @method('DELETE')
                            <button class="admin-danger" onclick="return confirm('Hapus pesan ini?')" type="submit">Hapus</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="admin-panel text-center text-slate-500 dark:text-slate-400">Belum ada pesan masuk.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
