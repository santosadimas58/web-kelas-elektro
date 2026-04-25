<?php

namespace App\Http\Controllers\Admin;

use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryItemController extends AdminController
{
    /**
     * Display a listing of gallery items.
     */
    public function index(): View
    {
        return view('admin.gallery.index', [
            'title' => 'Kelola Galeri',
            'items' => GalleryItem::query()->orderBy('sort_order')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a gallery item.
     */
    public function create(): View
    {
        return view('admin.gallery.create', [
            'title' => 'Tambah Galeri',
            'item' => new GalleryItem(),
        ]);
    }

    /**
     * Store a newly created gallery item.
     */
    public function store(Request $request): RedirectResponse
    {
        GalleryItem::query()->create($this->prepareItemPayload($this->validateItem($request)));

        return redirect()
            ->route('admin.gallery.index')
            ->with('status', 'Item galeri berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a gallery item.
     */
    public function edit(GalleryItem $gallery): View
    {
        return view('admin.gallery.edit', [
            'title' => 'Edit Galeri',
            'item' => $gallery,
        ]);
    }

    /**
     * Update the specified gallery item.
     */
    public function update(Request $request, GalleryItem $gallery): RedirectResponse
    {
        $gallery->update($this->prepareItemPayload($this->validateItem($request), $gallery));

        return redirect()
            ->route('admin.gallery.index')
            ->with('status', 'Item galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified gallery item.
     */
    public function destroy(GalleryItem $gallery): RedirectResponse
    {
        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('status', 'Item galeri berhasil dihapus.');
    }

    /**
     * Validate gallery item data.
     *
     * @return array<string, mixed>
     */
    protected function validateItem(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ]);
    }

    /**
     * Normalize gallery payload and clean stale uploaded files when switching to an external URL.
     *
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    protected function prepareItemPayload(array $validated, ?GalleryItem $gallery = null): array
    {
        if (! empty($validated['image_url'])) {
            if ($gallery?->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }

            $validated['image_path'] = null;
        }

        return $validated;
    }
}
