<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Nama</label>
        <input name="name" value="{{ old('name', $student->name) }}" class="form-input" required>
        @error('name')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">NIM</label>
        <input name="nim" value="{{ old('nim', $student->nim) }}" class="form-input" required>
        @error('nim')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Program Studi</label>
        <input name="prodi" value="{{ old('prodi', $student->prodi) }}" class="form-input" required>
        @error('prodi')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Angkatan</label>
        <input name="angkatan" type="number" min="2000" max="2100" value="{{ old('angkatan', $student->angkatan) }}" class="form-input" required>
        @error('angkatan')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Email</label>
        <input name="email" type="email" value="{{ old('email', $student->email) }}" class="form-input" required>
        @error('email')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Urutan Tampil</label>
        <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $student->sort_order ?? 0) }}" class="form-input">
        @error('sort_order')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="lg:col-span-2">
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Foto</label>
        <input name="photo" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="form-input">
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Format JPG, PNG, atau WEBP. Maksimal 2MB.</p>
        @error('photo')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    @if ($student->photo_image_url)
        <div class="lg:col-span-2">
            <p class="mb-3 text-sm font-semibold text-slate-700 dark:text-slate-300">Foto Saat Ini</p>
            <img src="{{ $student->photo_image_url }}" alt="{{ $student->name }}" class="h-40 w-40 rounded-[1.75rem] object-cover ring-1 ring-slate-200 dark:ring-slate-700">
        </div>
    @endif
</div>
