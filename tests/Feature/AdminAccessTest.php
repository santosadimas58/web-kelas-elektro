<?php

use App\Models\ContactMessage;
use App\Models\GalleryItem;
use App\Models\SiteSetting;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('dashboard redirects admins to the admin dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->get('/dashboard');

    $response->assertRedirect(route('admin.dashboard', absolute: false));
});

test('dashboard redirects users to the user dashboard', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertRedirect(route('user.dashboard', absolute: false));
});

test('admins can access the admin root path', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->get('/admin');

    $response->assertRedirect(route('admin.dashboard', absolute: false));
});

test('users cannot access the admin root path', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this->actingAs($user)->get('/admin');

    $response->assertForbidden();
});

test('users cannot access admin management routes', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $student = Student::factory()->create();
    $gallery = GalleryItem::query()->create([
        'title' => 'Gallery Test',
        'description' => 'Gallery description',
        'sort_order' => 1,
    ]);
    $managedUser = User::factory()->create([
        'role' => 'user',
    ]);
    $message = ContactMessage::query()->create([
        'name' => 'Pengirim',
        'email' => 'pengirim@example.com',
        'message' => 'Halo admin',
    ]);

    SiteSetting::query()->create([
        'site_name' => 'Kelas Elektronika Industri',
        'department' => 'Pendidikan Teknik Elektro',
        'tagline' => 'Demo',
        'hero_title' => 'Hero',
        'hero_description' => 'Description',
        'about_title' => 'Tentang',
        'about_text' => 'Tentang',
        'note' => 'Catatan',
        'contact_email' => 'kelas@example.com',
        'contact_phone' => '08123456789',
        'contact_location' => 'Indonesia',
        'contact_instagram' => '@kelas',
        'contact_description' => 'Kontak',
        'cta_title' => 'CTA',
        'cta_description' => 'CTA description',
    ]);

    $routes = [
        route('admin.dashboard'),
        route('admin.settings.edit'),
        route('admin.students.index'),
        route('admin.students.create'),
        route('admin.students.edit', $student),
        route('admin.students.show', $student),
        route('admin.gallery.index'),
        route('admin.gallery.create'),
        route('admin.gallery.edit', $gallery),
        route('admin.users.index'),
        route('admin.users.create'),
        route('admin.users.edit', $managedUser),
        route('admin.messages.index'),
    ];

    foreach ($routes as $route) {
        $this->actingAs($user)->get($route)->assertForbidden();
    }

    $this->actingAs($user)->put(route('admin.settings.update'), SiteSetting::current()->toArray())->assertForbidden();
    $this->actingAs($user)->post(route('admin.students.store'), [])->assertForbidden();
    $this->actingAs($user)->put(route('admin.students.update', $student), [])->assertForbidden();
    $this->actingAs($user)->delete(route('admin.students.destroy', $student))->assertForbidden();
    $this->actingAs($user)->post(route('admin.gallery.store'), [])->assertForbidden();
    $this->actingAs($user)->put(route('admin.gallery.update', $gallery), [])->assertForbidden();
    $this->actingAs($user)->delete(route('admin.gallery.destroy', $gallery))->assertForbidden();
    $this->actingAs($user)->post(route('admin.users.store'), [])->assertForbidden();
    $this->actingAs($user)->put(route('admin.users.update', $managedUser), [])->assertForbidden();
    $this->actingAs($user)->delete(route('admin.users.destroy', $managedUser))->assertForbidden();
    $this->actingAs($user)->delete(route('admin.messages.destroy', $message))->assertForbidden();
});

test('admins and guests cannot use the user gallery upload endpoint', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $payload = [
        'title' => 'Tes Upload',
        'description' => 'Deskripsi upload',
        'image' => UploadedFile::fake()->createWithContent(
            'gallery.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAukB9VE1K5sAAAAASUVORK5CYII=')
        ),
    ];

    $this->actingAs($admin)
        ->post(route('gallery.upload'), $payload)
        ->assertForbidden();

    $this->post(route('gallery.upload'), $payload)
        ->assertForbidden();
});

test('deleted users are logged out on their next request and their uploaded assets are removed', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $deletedUser = User::factory()->create([
        'role' => 'user',
        'profile_photo_path' => UploadedFile::fake()->createWithContent(
            'profile.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAukB9VE1K5sAAAAASUVORK5CYII=')
        )->store('profile-photos', 'public'),
    ]);

    $galleryPath = UploadedFile::fake()->createWithContent(
        'gallery.png',
        base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAukB9VE1K5sAAAAASUVORK5CYII=')
    )->store('gallery-images', 'public');

    GalleryItem::query()->create([
        'user_id' => $deletedUser->id,
        'title' => 'Upload User',
        'description' => 'Dokumentasi user',
        'image_path' => $galleryPath,
        'sort_order' => 1,
    ]);

    $this->actingAs($admin)->delete(route('admin.users.destroy', $deletedUser))
        ->assertRedirect(route('admin.users.index'));

    $this->assertDatabaseMissing('users', ['id' => $deletedUser->id]);
    $this->assertDatabaseMissing('gallery_items', ['user_id' => $deletedUser->id]);
    Storage::disk('public')->assertMissing($galleryPath);
    Storage::disk('public')->assertMissing($deletedUser->profile_photo_path);

    $staleUser = User::factory()->make([
        'id' => $deletedUser->id,
        'role' => 'user',
    ]);

    $response = $this->actingAs($staleUser)->get('/user/dashboard');

    $response->assertRedirect(route('login', absolute: false));
    $response->assertSessionHas('status');
    $this->assertGuest();
});
