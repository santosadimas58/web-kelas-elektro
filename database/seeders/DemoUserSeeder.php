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

        $students = collect(array_slice(config('classroom.students'), 0, 10))
            ->map(fn (array $student): array => [
                'email' => Str::slug($student['name'], '.').'@kelas-elektro.test',
                'name' => $student['name'],
            ]);

        User::query()
            ->where('role', 'user')
            ->whereNotIn('email', $students->pluck('email')->all())
            ->get()
            ->each
            ->delete();

        foreach ($students as $student) {
            $user = User::query()->firstOrNew(['email' => $student['email']]);
            $user->name = $student['name'];
            $user->role = 'user';
            $user->password = Hash::make($password);
            $user->save();
        }
    }
}
