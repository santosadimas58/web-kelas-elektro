<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\GalleryItem;
use App\Models\SiteSetting;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    /**
     * Show the homepage.
     */
    public function home(): View
    {
        return view('pages.home', [
            'title' => 'Beranda',
            'students' => Student::query()->orderBy('sort_order')->orderBy('name')->get(),
            'gallery' => GalleryItem::query()->orderBy('sort_order')->latest()->get(),
            'siteSetting' => SiteSetting::current(),
        ]);
    }

    /**
     * Show the about page.
     */
    public function about(): View
    {
        return view('pages.about', [
            'title' => 'Tentang',
            'siteSetting' => SiteSetting::current(),
        ]);
    }

    /**
     * Show the students page.
     */
    public function students(): View
    {
        return view('pages.students', [
            'title' => 'Mahasiswa',
            'students' => Student::query()->orderBy('sort_order')->orderBy('name')->get(),
            'siteSetting' => SiteSetting::current(),
        ]);
    }

    /**
     * Show the gallery page.
     */
    public function gallery(): View
    {
        return view('pages.gallery', [
            'title' => 'Galeri',
            'gallery' => GalleryItem::query()->orderBy('sort_order')->latest()->get(),
            'siteSetting' => SiteSetting::current(),
        ]);
    }

    /**
     * Show the contact page.
     */
    public function contact(): View
    {
        return view('pages.contact', [
            'title' => 'Kontak',
            'siteSetting' => SiteSetting::current(),
        ]);
    }

    /**
     * Store a public contact message.
     */
    public function submitContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:120'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        ContactMessage::query()->create($validated);

        return redirect()
            ->route('contact')
            ->with('status', 'Pesan berhasil dikirim. Admin dapat melihatnya dari dashboard.');
    }
}
