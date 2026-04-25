<?php

use App\Models\SiteSetting;
use App\Models\Student;

test('public students page displays paginated student cards from the database', function () {
    SiteSetting::query()->create([
        'site_name' => 'Kelas Elektronika Industri',
        'department' => 'Pendidikan Teknik Elektro',
        'tagline' => 'Demo kelas',
        'hero_title' => 'Hero',
        'hero_description' => 'Hero description',
        'about_title' => 'Tentang',
        'about_text' => 'Tentang kelas',
        'note' => 'Catatan',
        'contact_email' => 'kelas@example.com',
        'contact_phone' => '08123456789',
        'contact_location' => 'Indonesia',
        'contact_instagram' => '@kelas',
        'contact_description' => 'Kontak',
        'cta_title' => 'CTA',
        'cta_description' => 'CTA description',
    ]);

    Student::factory()->count(12)->create();

    $response = $this->get(route('students'));

    $response->assertOk();
    expect($response->viewData('students')->total())->toBe(12);
    expect($response->viewData('students')->count())->toBe(9);
});
