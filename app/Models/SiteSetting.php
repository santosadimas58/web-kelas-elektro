<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'site_name',
        'department',
        'tagline',
        'hero_title',
        'hero_description',
        'about_title',
        'about_text',
        'note',
        'contact_email',
        'contact_phone',
        'contact_location',
        'contact_instagram',
        'contact_description',
        'cta_title',
        'cta_description',
    ];

    /**
     * Get or create the singleton settings row.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'site_name' => 'Kelas Elektronika Industri',
            'department' => 'Pendidikan Teknik Elektro',
            'tagline' => 'Ruang dokumentasi kelas yang merekam profil mahasiswa, cerita pembelajaran, dan kenangan bersama.',
            'hero_title' => 'Ruang hangat untuk merangkum perjalanan Kelas Elektronika Industri.',
            'hero_description' => 'Website ini menampilkan profil mahasiswa, gambaran singkat program studi, dan galeri kenangan kelas dalam tampilan modern yang mudah dijelajahi.',
            'about_title' => 'Pendidikan Teknik Elektro (PTE)',
            'about_text' => 'Program Studi Pendidikan Teknik Elektro (PTE) adalah bidang studi di perguruan tinggi yang memadukan ilmu teknik elektro (arus kuat/lemah) dengan ilmu kependidikan. Tujuannya adalah menghasilkan lulusan yang kompeten di bidang teknik elektro sekaligus memiliki kemampuan pedagogis (mengajar) untuk menjadi pendidik (guru SMK/instruktur) maupun praktisi teknik.',
            'note' => 'Website ini bukan portal akademik resmi. Fokusnya adalah dokumentasi kelas, profil mahasiswa, dan kenangan bersama.',
            'contact_email' => 'kelas.elektronika@example.com',
            'contact_phone' => '+62 812-3456-7890',
            'contact_location' => 'Pendidikan Teknik Elektro, Indonesia',
            'contact_instagram' => '@kelas.elektro.industri',
            'contact_description' => 'Dokumentasi publik untuk menyimpan cerita, profil mahasiswa, dan kenangan kelas secara terstruktur.',
            'cta_title' => 'Simpan cerita kelas dalam tampilan yang bersih dan mudah dikenang.',
            'cta_description' => 'Website ini dirancang untuk mengabadikan identitas angkatan tanpa kesan kaku seperti portal resmi.',
        ]);
    }
}
