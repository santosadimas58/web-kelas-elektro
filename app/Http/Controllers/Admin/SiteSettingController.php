<?php

namespace App\Http\Controllers\Admin;

use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends AdminController
{
    /**
     * Show the website settings form.
     */
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'title' => 'Pengaturan Website',
            'siteSetting' => SiteSetting::current(),
        ]);
    }

    /**
     * Update website settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'tagline' => ['required', 'string', 'max:255'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_description' => ['required', 'string', 'max:1000'],
            'about_title' => ['required', 'string', 'max:255'],
            'about_text' => ['required', 'string', 'max:2000'],
            'note' => ['required', 'string', 'max:500'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:100'],
            'contact_location' => ['required', 'string', 'max:255'],
            'contact_instagram' => ['nullable', 'string', 'max:100'],
            'contact_description' => ['required', 'string', 'max:1000'],
            'cta_title' => ['required', 'string', 'max:255'],
            'cta_description' => ['required', 'string', 'max:1000'],
        ]);

        SiteSetting::current()->update($validated);

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Pengaturan website berhasil diperbarui.');
    }
}
