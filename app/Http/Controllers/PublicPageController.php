<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\GalleryItem;
use App\Models\SiteSetting;
use App\Models\Student;
use App\Models\User;
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
            'students' => User::query()
                ->where('role', 'user')
                ->orderBy('name')
                ->get(),
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
            'gallery' => GalleryItem::query()
                ->with('user:id,name')
                ->orderBy('sort_order')
                ->latest()
                ->get(),
            'siteSetting' => SiteSetting::current(),
        ]);
    }

    /**
     * Store a gallery upload from a regular user.
     */
    public function uploadGallery(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'image' => ['required', 'image', 'max:4096'],
        ]);

        $imagePath = $request->file('image')->store('gallery-images', 'public');

        GalleryItem::query()->create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_path' => $imagePath,
            'sort_order' => 0,
        ]);

        return redirect()
            ->route('gallery')
            ->with('status', 'Foto galeri berhasil diunggah.');
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
