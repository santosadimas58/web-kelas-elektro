<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Nama</label>
        <input name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
        @error('name')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Email</label>
        <input name="email" type="email" value="{{ old('email', $user->email) }}" class="form-input" required>
        @error('email')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Role</label>
        <select name="role" class="form-input" required>
            <option value="user" @selected(old('role', $user->role) === 'user')>User</option>
            <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
        </select>
        @error('role')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Password {{ $user->exists ? '(opsional)' : '' }}</label>
        <input name="password" type="password" class="form-input" @if (! $user->exists) required @endif>
        @error('password')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="lg:col-span-2">
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Konfirmasi Password</label>
        <input name="password_confirmation" type="password" class="form-input" @if (! $user->exists) required @endif>
        @error('password_confirmation')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>
</div>
