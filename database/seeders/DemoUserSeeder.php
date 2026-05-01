<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class DemoUserSeeder extends Seeder
{
    /**
     * Seed regular student accounts for the class.
     */
    public function run(): void
    {
        $isProduction = app()->environment('production');
        $password = config('classroom.student_default_password') ?: ($isProduction ? null : 'password');

        if (! $password) {
            throw new RuntimeException('Set STUDENT_DEFAULT_PASSWORD before seeding production student accounts.');
        }

        User::query()->where('email', 'user@example.com')->delete();

        foreach (array_slice(config('classroom.students'), 0, 10) as $student) {
            User::query()->updateOrCreate(
                ['email' => Str::slug($student['name'], '.').'@kelas-elektro.test'],
                [
                    'name' => $student['name'],
                    'role' => 'user',
                    'password' => Hash::make($password),
                ]
            );
        }
    }
}
