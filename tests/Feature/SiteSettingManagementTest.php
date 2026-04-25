<?php

use App\Models\SiteSetting;
use App\Models\User;

test('admins can update public site settings from the dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->put(route('admin.settings.update'), [
        'site_name' => 'Portal Kelas EI',
        'department' => 'Pendidikan Teknik Elektro',
        'tagline' => 'Dokumentasi kelas yang rapi',
        'hero_title' => 'Beranda yang diperbarui dari dashboard',
        'hero_description' => 'Konten hero kini berasal dari tabel site settings.',
        'about_title' => 'Tentang Program Studi',
        'about_text' => 'Halaman tentang mengambil isi dari database.',
        'note' => 'Catatan umum website kelas.',
        'contact_email' => 'kelas@example.com',
        'contact_phone' => '08123456789',
        'contact_location' => 'Makassar',
        'contact_instagram' => '@kelas.ei',
        'contact_description' => 'Kontak publik dapat diubah admin.',
        'cta_title' => 'Ayo jelajahi dokumentasi kelas',
        'cta_description' => 'CTA ini juga dikelola dari dashboard.',
    ]);

    $response->assertRedirect(route('admin.settings.edit', absolute: false));
    $response->assertSessionHas('status');

    $this->assertDatabaseHas('site_settings', [
        'site_name' => 'Portal Kelas EI',
        'hero_title' => 'Beranda yang diperbarui dari dashboard',
        'about_title' => 'Tentang Program Studi',
        'contact_email' => 'kelas@example.com',
    ]);
});

test('public pages render content from site settings', function () {
    SiteSetting::query()->create([
        'site_name' => 'Portal Kelas EI',
        'department' => 'Pendidikan Teknik Elektro',
        'tagline' => 'Dokumentasi kelas yang rapi',
        'hero_title' => 'Beranda yang diperbarui dari dashboard',
        'hero_description' => 'Konten hero kini berasal dari tabel site settings.',
        'about_title' => 'Tentang Program Studi',
        'about_text' => 'Halaman tentang mengambil isi dari database.',
        'note' => 'Catatan umum website kelas.',
        'contact_email' => 'kelas@example.com',
        'contact_phone' => '08123456789',
        'contact_location' => 'Makassar',
        'contact_instagram' => '@kelas.ei',
        'contact_description' => 'Kontak publik dapat diubah admin.',
        'cta_title' => 'Ayo jelajahi dokumentasi kelas',
        'cta_description' => 'CTA ini juga dikelola dari dashboard.',
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Beranda yang diperbarui dari dashboard')
        ->assertSee('Dokumentasi kelas yang rapi');

    $this->get(route('about'))
        ->assertOk()
        ->assertSee('Tentang Program Studi')
        ->assertSee('Halaman tentang mengambil isi dari database.');

    $this->get(route('contact'))
        ->assertOk()
        ->assertSee('kelas@example.com')
        ->assertSee('Kontak publik dapat diubah admin.');
});
