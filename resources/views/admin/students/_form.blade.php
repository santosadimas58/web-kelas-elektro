<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Nama</label>
        <input name="name" value="{{ old('name', $student->name) }}" class="form-input">
    </div>
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Fokus Studi / Label</label>
        <input name="study_focus" value="{{ old('study_focus', $student->study_focus) }}" class="form-input">
    </div>
    <div class="lg:col-span-2">
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Bio Singkat</label>
        <textarea name="bio" rows="5" class="form-input">{{ old('bio', $student->bio) }}</textarea>
    </div>
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">URL Foto</label>
        <input name="photo_url" value="{{ old('photo_url', $student->photo_url) }}" class="form-input" placeholder="https://...">
    </div>
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Urutan Tampil</label>
        <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $student->sort_order ?? 0) }}" class="form-input">
    </div>
</div>
