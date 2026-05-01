<?php

use App\Models\GalleryItem;
use App\Models\SiteSetting;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DemoUserSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

test('database seeder creates admin and ten student accounts, public content, and gallery data', function () {
    $this->seed(DatabaseSeeder::class);

    $admin = User::query()->where('email', 'admin@example.com')->first();
    $firstStudent = config('classroom.students.0');
    $firstStudentUser = User::query()
        ->where('email', Str::slug($firstStudent['name'], '.').'@kelas-elektro.test')
        ->first();

    expect($admin)->not->toBeNull();
    expect($admin->role)->toBe('admin');
    expect($firstStudentUser)->not->toBeNull();
    expect($firstStudentUser->role)->toBe('user');
    expect(User::query()->where('role', 'admin')->count())->toBe(1);
    expect(User::query()->where('role', 'user')->count())->toBe(10);
    expect(User::query()->where('email', 'user@example.com')->exists())->toBeFalse();
    expect(SiteSetting::query()->count())->toBe(1);
    expect(Student::query()->count())->toBeGreaterThanOrEqual(15);
    expect(GalleryItem::query()->count())->toBeGreaterThanOrEqual(6);
});

test('production seeding creates configured admin without demo user', function () {
    app()->detectEnvironment(fn () => 'production');

    User::factory()->create([
        'name' => 'Old Admin',
        'email' => 'old-admin@kelas-elektro.test',
        'role' => 'admin',
    ]);

    User::factory()->create([
        'name' => 'Old User',
        'email' => 'old-user@kelas-elektro.test',
        'role' => 'user',
    ]);

    config([
        'classroom.admin.name' => 'Admin Production',
        'classroom.admin.email' => 'admin@kelas-elektro.test',
        'classroom.admin.password' => 'strong-production-password',
        'classroom.student_default_password' => 'strong-student-password',
    ]);

    app(AdminUserSeeder::class)->run();
    app(DemoUserSeeder::class)->run();

    $admin = User::query()->where('email', 'admin@kelas-elektro.test')->first();

    expect($admin)->not->toBeNull();
    expect($admin->name)->toBe('Admin Production');
    expect($admin->role)->toBe('admin');
    expect(Hash::check('strong-production-password', $admin->password))->toBeTrue();
    expect(User::query()->where('email', 'admin@example.com')->exists())->toBeFalse();
    expect(User::query()->where('email', 'user@example.com')->exists())->toBeFalse();
    expect(User::query()->where('email', 'old-admin@kelas-elektro.test')->exists())->toBeFalse();
    expect(User::query()->where('email', 'old-user@kelas-elektro.test')->exists())->toBeFalse();
    expect(User::query()->where('role', 'admin')->count())->toBe(1);
    expect(User::query()->where('role', 'user')->count())->toBe(10);
});
