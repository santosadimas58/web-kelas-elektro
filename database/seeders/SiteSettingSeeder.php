<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Seed the public website settings.
     */
    public function run(): void
    {
        $classroom = config('classroom');

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
    }
}
