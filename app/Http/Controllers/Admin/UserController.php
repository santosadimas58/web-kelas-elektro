<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends AdminController
{
    private const MAX_ADMIN_ACCOUNTS = 1;

    private const MAX_STUDENT_ACCOUNTS = 10;

    /**
     * Display all users.
     */
    public function index(): View
    {
        return view('admin.users.index', [
            'title' => 'Kelola Akun',
            'users' => User::query()->orderBy('role')->orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a user.
     */
    public function create(): View
    {
        return view('admin.users.create', [
            'title' => 'Tambah Akun',
            'user' => new User,
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateUser($request);

        if ($limitResponse = $this->accountLimitResponse($validated['role'], route('admin.users.create'))) {
            return $limitResponse;
        }

        $user = new User;
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Akun berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'title' => 'Edit Akun',
            'user' => $user,
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $this->validateUser($request, $user);
        $targetRole = $validated['role'] ?? $user->role;

        if (
            $user->id === auth()->id()
            && $user->role === 'admin'
            && $targetRole !== 'admin'
            && User::query()->where('role', 'admin')->count() === 1
        ) {
            return redirect()
                ->route('admin.users.edit', $user)
                ->withInput()
                ->with('error', 'Admin terakhir tidak dapat diubah menjadi user biasa.');
        }

        if ($limitResponse = $this->accountLimitResponse($targetRole, route('admin.users.edit', $user), $user)) {
            return $limitResponse;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $targetRole;

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Akun berhasil diperbarui.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Akun yang sedang dipakai tidak dapat dihapus.');
        }

        if ($user->role === 'admin' && User::query()->where('role', 'admin')->count() === 1) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Admin terakhir tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Akun berhasil dihapus.');
    }

    /**
     * Validate user form data.
     *
     * @return array<string, mixed>
     */
    protected function validateUser(Request $request, ?User $user = null): array
    {
        $passwordRules = $user
            ? ['nullable', 'string', Password::min(12)->mixedCase()->numbers(), 'confirmed']
            : ['required', 'string', Password::min(12)->mixedCase()->numbers(), 'confirmed'];

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user),
            ],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'password' => $passwordRules,
            'password_confirmation' => ['nullable', 'string', 'min:8'],
        ]);
    }

    /**
     * Keep account counts limited to one admin and ten class members.
     */
    protected function accountLimitResponse(string $role, string $redirectTo, ?User $currentUser = null): ?RedirectResponse
    {
        $query = User::query()->where('role', $role);

        if ($currentUser) {
            $query->whereKeyNot($currentUser->id);
        }

        $count = $query->count();

        if ($role === 'admin' && $count >= self::MAX_ADMIN_ACCOUNTS) {
            return redirect($redirectTo)
                ->withInput()
                ->with('error', 'Akun admin/super admin hanya boleh satu.');
        }

        if ($role === 'user' && $count >= self::MAX_STUDENT_ACCOUNTS) {
            return redirect($redirectTo)
                ->withInput()
                ->with('error', 'Akun mahasiswa kelas dibatasi maksimal 10 akun.');
        }

        return null;
    }
}
