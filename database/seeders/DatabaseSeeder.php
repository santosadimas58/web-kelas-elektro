<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use App\Models\SiteSetting;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $classroom = config('classroom');

        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Kelas',
                'role' => 'admin',
                'password' => 'password',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User Kelas',
                'role' => 'user',
                'password' => 'password',
            ]
        );

        SiteSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'site_name' => $classroom['site_name'],
                'department' => $classroom['department'],
                'tagline' => $classroom['tagline'],
                'hero_title' => 'Ruang hangat untuk merangkum perjalanan Kelas Elektronika Industri.',
                'hero_description' => 'Website ini menampilkan profil mahasiswa, gambaran singkat program studi, dan galeri kenangan kelas dalam tampilan modern yang mudah dijelajahi.',
                'about_title' => 'Pendidikan Teknik Elektro (PTE)',
                'about_text' => $classroom['about'],
                'note' => $classroom['note'],
                'contact_email' => $classroom['contact']['email'],
                'contact_phone' => $classroom['contact']['phone'],
                'contact_location' => $classroom['contact']['location'],
                'contact_instagram' => $classroom['contact']['instagram'],
                'contact_description' => 'Dokumentasi publik untuk menyimpan cerita, profil mahasiswa, dan kenangan kelas secara terstruktur.',
                'cta_title' => 'Simpan cerita kelas dalam tampilan yang bersih dan mudah dikenang.',
                'cta_description' => 'Website ini dirancang untuk mengabadikan identitas angkatan tanpa kesan kaku seperti portal resmi.',
            ]
        );

        foreach ($classroom['students'] as $index => $student) {
            Student::query()->updateOrCreate(
                ['name' => $student['name']],
                [
                    'study_focus' => 'Mahasiswa Kelas',
                    'bio' => $student['bio'],
                    'sort_order' => $index + 1,
                ]
            );
        }

        foreach ($classroom['gallery'] as $index => $item) {
            GalleryItem::query()->updateOrCreate(
                ['title' => $item['title']],
                [
                    'description' => $item['description'],
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
