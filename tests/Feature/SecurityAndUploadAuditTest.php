<?php

use App\Models\GalleryItem;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function fakeAuditImage(string $name = 'audit.png'): UploadedFile
{
    return UploadedFile::fake()->createWithContent(
        $name,
        base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAukB9VE1K5sAAAAASUVORK5CYII=')
    );
}

test('gitignore excludes environment files', function () {
    $gitignore = file_get_contents(base_path('.gitignore'));

    expect($gitignore)->toContain('.env');
    expect($gitignore)->toContain('.env.production');
});

test('application debug config is sourced from env with a false default', function () {
    $configFile = file_get_contents(config_path('app.php'));

    expect($configFile)->toContain("'debug' => (bool) env('APP_DEBUG', false)");
});

test('user gallery upload rejects non-image files', function () {
    Storage::fake('public');

    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this->actingAs($user)->post(route('gallery.upload'), [
        'title' => 'Dokumen Salah',
        'description' => 'Bukan gambar',
        'image' => UploadedFile::fake()->create('payload.pdf', 100, 'application/pdf'),
    ]);

    $response->assertSessionHasErrors('image');
    $this->assertDatabaseCount('gallery_items', 0);
});

test('profile photo replacement deletes the old file', function () {
    Storage::fake('public');

    $user = User::factory()->create([
        'profile_photo_path' => fakeAuditImage('old.png')->store('profile-photos', 'public'),
    ]);

    $oldPath = $user->profile_photo_path;

    $response = $this->actingAs($user)->patch(route('profile.update'), [
        'name' => $user->name,
        'email' => $user->email,
        'profile_photo' => fakeAuditImage('new.png'),
    ]);

    $response->assertRedirect(route('profile.edit', absolute: false));

    $user->refresh();

    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($user->profile_photo_path);
});

test('student photo accessor falls back to null when the local file is missing', function () {
    Storage::fake('public');

    $student = Student::factory()->create([
        'photo_path' => 'student-photos/missing.png',
    ]);

    expect($student->photo_image_url)->toBeNull();
});

test('gallery display image falls back to url when uploaded file is missing', function () {
    Storage::fake('public');

    $gallery = GalleryItem::query()->create([
        'title' => 'Galeri Demo',
        'description' => 'Deskripsi demo',
        'image_path' => 'gallery-images/missing.png',
        'image_url' => 'https://example.com/fallback-image.jpg',
        'sort_order' => 1,
    ]);

    expect($gallery->display_image_url)->toBe('https://example.com/fallback-image.jpg');
});

test('admin gallery update removes stale uploaded files when switching to an external image url', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $imagePath = fakeAuditImage('gallery.png')->store('gallery-images', 'public');

    $gallery = GalleryItem::query()->create([
        'title' => 'Galeri Internal',
        'description' => 'Deskripsi lama',
        'image_path' => $imagePath,
        'sort_order' => 1,
    ]);

    $response = $this->actingAs($admin)->put(route('admin.gallery.update', $gallery), [
        'title' => 'Galeri Eksternal',
        'description' => 'Deskripsi baru',
        'image_url' => 'https://example.com/gallery.jpg',
        'sort_order' => 2,
    ]);

    $response->assertRedirect(route('admin.gallery.index', absolute: false));

    $gallery->refresh();

    expect($gallery->image_path)->toBeNull();
    expect($gallery->display_image_url)->toBe('https://example.com/gallery.jpg');
    Storage::disk('public')->assertMissing($imagePath);
});
