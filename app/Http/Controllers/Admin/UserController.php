<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends AdminController
{
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
            'user' => new User(),
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateUser($request);
        $validated['password'] = Hash::make($validated['password']);

        User::query()->create($validated);

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

        if (
            $user->id === auth()->id()
            && $user->role === 'admin'
            && ($validated['role'] ?? $user->role) !== 'admin'
            && User::query()->where('role', 'admin')->count() === 1
        ) {
            return redirect()
                ->route('admin.users.edit', $user)
                ->withInput()
                ->with('error', 'Admin terakhir tidak dapat diubah menjadi user biasa.');
        }

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        unset($validated['password_confirmation']);

        $user->update($validated);

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
            ? ['nullable', 'string', 'min:8', 'confirmed']
            : ['required', 'string', 'min:8', 'confirmed'];

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
}
