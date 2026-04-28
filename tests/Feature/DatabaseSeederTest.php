<?php

use App\Models\GalleryItem;
use App\Models\SiteSetting;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DemoUserSeeder;
use Illuminate\Support\Facades\Hash;

test('database seeder creates demo accounts, public content, and gallery data', function () {
    $this->seed(DatabaseSeeder::class);

    $admin = User::query()->where('email', 'admin@example.com')->first();
    $user = User::query()->where('email', 'user@example.com')->first();

    expect($admin)->not->toBeNull();
    expect($admin->role)->toBe('admin');
    expect($user)->not->toBeNull();
    expect($user->role)->toBe('user');
    expect(SiteSetting::query()->count())->toBe(1);
    expect(Student::query()->count())->toBeGreaterThanOrEqual(15);
    expect(GalleryItem::query()->count())->toBeGreaterThanOrEqual(6);
});

test('production seeding creates configured admin without demo user', function () {
    app()->detectEnvironment(fn () => 'production');

    config([
        'classroom.admin.name' => 'Admin Production',
        'classroom.admin.email' => 'admin@kelas-elektro.test',
        'classroom.admin.password' => 'strong-production-password',
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
});
