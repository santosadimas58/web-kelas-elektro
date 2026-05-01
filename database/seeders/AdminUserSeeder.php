<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the default admin account.
     */
    public function run(): void
    {
        $isProduction = app()->environment('production');
        $email = config('classroom.admin.email') ?: ($isProduction ? null : 'admin@example.com');
        $password = config('classroom.admin.password') ?: ($isProduction ? null : 'password');
        $name = config('classroom.admin.name') ?: 'Admin Kelas';

        if (! $email || ! $password) {
            throw new RuntimeException('Set ADMIN_EMAIL and ADMIN_PASSWORD before seeding the production admin account.');
        }

        if ($isProduction) {
            $this->assertStrongProductionPassword($password);
        }

        User::query()
            ->where('role', 'admin')
            ->where('email', '!=', $email)
            ->get()
            ->each
            ->delete();

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'role' => 'admin',
                'password' => Hash::make($password),
            ]
        );
    }

    /**
     * Production admin passwords must be generated, not guessed.
     */
    private function assertStrongProductionPassword(string $password): void
    {
        $hasMinimumLength = strlen($password) >= 16;
        $hasLowercase = preg_match('/[a-z]/', $password) === 1;
        $hasUppercase = preg_match('/[A-Z]/', $password) === 1;
        $hasNumber = preg_match('/[0-9]/', $password) === 1;
        $hasSymbol = preg_match('/[^A-Za-z0-9]/', $password) === 1;

        if (! ($hasMinimumLength && $hasLowercase && $hasUppercase && $hasNumber && $hasSymbol)) {
            throw new RuntimeException(
                'ADMIN_PASSWORD for production must be at least 16 characters and include uppercase, lowercase, number, and symbol characters.'
            );
        }
    }
}
