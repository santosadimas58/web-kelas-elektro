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
                    <input name="site_name" value="{{ old('site_name', $siteSetting->site_name) }}" class="form-input">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Program Studi</label>
                    <input name="department" value="{{ old('department', $siteSetting->department) }}" class="form-input">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Tagline</label>
                <input name="tagline" value="{{ old('tagline', $siteSetting->tagline) }}" class="form-input">
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Judul Hero</label>
                    <textarea name="hero_title" rows="3" class="form-input">{{ old('hero_title', $siteSetting->hero_title) }}</textarea>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Deskripsi Hero</label>
                    <textarea name="hero_description" rows="3" class="form-input">{{ old('hero_description', $siteSetting->hero_description) }}</textarea>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Judul Tentang</label>
                    <input name="about_title" value="{{ old('about_title', $siteSetting->about_title) }}" class="form-input">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Catatan Website</label>
                    <textarea name="note" rows="3" class="form-input">{{ old('note', $siteSetting->note) }}</textarea>
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Isi Halaman Tentang</label>
                <textarea name="about_text" rows="6" class="form-input">{{ old('about_text', $siteSetting->about_text) }}</textarea>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Email Kontak</label>
                    <input name="contact_email" value="{{ old('contact_email', $siteSetting->contact_email) }}" class="form-input">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Telepon</label>
                    <input name="contact_phone" value="{{ old('contact_phone', $siteSetting->contact_phone) }}" class="form-input">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Lokasi</label>
                    <input name="contact_location" value="{{ old('contact_location', $siteSetting->contact_location) }}" class="form-input">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Instagram</label>
                    <input name="contact_instagram" value="{{ old('contact_instagram', $siteSetting->contact_instagram) }}" class="form-input">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Deskripsi Kontak</label>
                <textarea name="contact_description" rows="4" class="form-input">{{ old('contact_description', $siteSetting->contact_description) }}</textarea>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Judul CTA</label>
                    <textarea name="cta_title" rows="3" class="form-input">{{ old('cta_title', $siteSetting->cta_title) }}</textarea>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Deskripsi CTA</label>
                    <textarea name="cta_description" rows="3" class="form-input">{{ old('cta_description', $siteSetting->cta_description) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end">
                <button class="admin-action-primary" type="submit">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</x-app-layout>
