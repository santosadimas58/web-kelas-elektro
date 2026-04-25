<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">Admin</p>
            <h2 class="mt-1 text-2xl font-bold text-slate-950 dark:text-slate-100">Pengaturan Website</h2>
        </div>
    </x-slot>

    <div class="admin-shell">
        @include('admin.partials.flash')

        <form method="POST" action="{{ route('admin.settings.update') }}" class="admin-panel space-y-8">
            @csrf
            @method('PUT')

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Website</label>
                    <input name="site_name" value="{{ old('site_name', $siteSetting->site_name) }}" class="form-input" required>
                    @error('site_name')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Program Studi</label>
                    <input name="department" value="{{ old('department', $siteSetting->department) }}" class="form-input" required>
                    @error('department')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Tagline</label>
                <input name="tagline" value="{{ old('tagline', $siteSetting->tagline) }}" class="form-input" required>
                @error('tagline')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Judul Hero</label>
                    <textarea name="hero_title" rows="3" class="form-input" required>{{ old('hero_title', $siteSetting->hero_title) }}</textarea>
                    @error('hero_title')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Deskripsi Hero</label>
                    <textarea name="hero_description" rows="3" class="form-input" required>{{ old('hero_description', $siteSetting->hero_description) }}</textarea>
                    @error('hero_description')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Judul Tentang</label>
                    <input name="about_title" value="{{ old('about_title', $siteSetting->about_title) }}" class="form-input" required>
                    @error('about_title')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Catatan Website</label>
                    <textarea name="note" rows="3" class="form-input" required>{{ old('note', $siteSetting->note) }}</textarea>
                    @error('note')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Isi Halaman Tentang</label>
                <textarea name="about_text" rows="6" class="form-input" required>{{ old('about_text', $siteSetting->about_text) }}</textarea>
                @error('about_text')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Email Kontak</label>
                    <input name="contact_email" type="email" value="{{ old('contact_email', $siteSetting->contact_email) }}" class="form-input" required>
                    @error('contact_email')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Telepon</label>
                    <input name="contact_phone" value="{{ old('contact_phone', $siteSetting->contact_phone) }}" class="form-input" required>
                    @error('contact_phone')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Lokasi</label>
                    <input name="contact_location" value="{{ old('contact_location', $siteSetting->contact_location) }}" class="form-input" required>
                    @error('contact_location')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Instagram</label>
                    <input name="contact_instagram" value="{{ old('contact_instagram', $siteSetting->contact_instagram) }}" class="form-input">
                    @error('contact_instagram')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Deskripsi Kontak</label>
                <textarea name="contact_description" rows="4" class="form-input" required>{{ old('contact_description', $siteSetting->contact_description) }}</textarea>
                @error('contact_description')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Judul CTA</label>
                    <textarea name="cta_title" rows="3" class="form-input" required>{{ old('cta_title', $siteSetting->cta_title) }}</textarea>
                    @error('cta_title')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Deskripsi CTA</label>
                    <textarea name="cta_description" rows="3" class="form-input" required>{{ old('cta_description', $siteSetting->cta_description) }}</textarea>
                    @error('cta_description')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end">
                <button class="admin-action-primary" type="submit">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</x-app-layout>
