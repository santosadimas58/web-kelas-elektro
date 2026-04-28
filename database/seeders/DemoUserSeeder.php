<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DemoUserSeeder extends Seeder
{
    /**
     * Seed a regular demo user account.
     */
    public function run(): void
    {
        if (app()->environment('production')) {
            return;
        }

        User::query()->updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User Kelas',
                'role' => 'user',
                'password' => 'password',
            ]
        );
    }
}
