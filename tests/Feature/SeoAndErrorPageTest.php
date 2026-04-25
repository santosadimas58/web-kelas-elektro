<?php

use App\Models\SiteSetting;
use App\Models\User;

test('public layout renders dynamic title and meta description', function () {
    SiteSetting::query()->create([
        'site_name' => 'Portal Kelas EI',
        'department' => 'Pendidikan Teknik Elektro',
        'tagline' => 'Website dokumentasi kelas yang rapi dan modern.',
        'hero_title' => 'Hero',
        'hero_description' => 'Hero description',
        'about_title' => 'Tentang',
        'about_text' => 'Tentang kelas',
        'note' => 'Catatan website',
        'contact_email' => 'kelas@example.com',
        'contact_phone' => '08123456789',
        'contact_location' => 'Makassar',
        'contact_instagram' => '@kelas.ei',
        'contact_description' => 'Kontak publik',
        'cta_title' => 'CTA',
        'cta_description' => 'CTA description',
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('<title>Beranda | Pendidikan Teknik Elektro</title>', false);
    $response->assertSee('name="description"', false);
    $response->assertSee('Website dokumentasi kelas yang rapi dan modern.', false);
    $response->assertSee('favicon.ico', false);
});

test('custom 404 page is rendered', function () {
    $response = $this->get('/halaman-yang-tidak-ada');

    $response->assertNotFound();
    $response->assertSee('Halaman Tidak Ditemukan');
});

test('custom 403 page is rendered for forbidden admin access', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this->actingAs($user)->get(route('admin.dashboard'));

    $response->assertForbidden();
    $response->assertSee('Akses Ditolak');
});
