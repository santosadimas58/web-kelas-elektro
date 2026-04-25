<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Judul</label>
        <input name="title" value="{{ old('title', $item->title) }}" class="form-input" required>
        @error('title')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Urutan Tampil</label>
        <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="form-input">
        @error('sort_order')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="lg:col-span-2">
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Deskripsi</label>
        <textarea name="description" rows="5" class="form-input" required>{{ old('description', $item->description) }}</textarea>
        @error('description')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="lg:col-span-2">
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">URL Gambar</label>
        <input name="image_url" type="url" value="{{ old('image_url', $item->image_url) }}" class="form-input" placeholder="https://...">
        @error('image_url')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>
</div>
