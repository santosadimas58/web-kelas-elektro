<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Nama</label>
        <input name="name" value="{{ old('name', $user->name) }}" class="form-input">
    </div>
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Email</label>
        <input name="email" value="{{ old('email', $user->email) }}" class="form-input">
    </div>
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Role</label>
        <select name="role" class="form-input">
            <option value="user" @selected(old('role', $user->role) === 'user')>User</option>
            <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
        </select>
    </div>
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Password {{ $user->exists ? '(opsional)' : '' }}</label>
        <input name="password" type="password" class="form-input">
    </div>
    <div class="lg:col-span-2">
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Konfirmasi Password</label>
        <input name="password_confirmation" type="password" class="form-input">
    </div>
</div>
