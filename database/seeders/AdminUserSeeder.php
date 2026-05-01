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
}
