<?php

use App\Models\GalleryItem;
use App\Models\SiteSetting;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

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
