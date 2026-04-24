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

class DashboardController extends Controller
{
    /**
     * Redirect users to the dashboard that matches their role.
     */
    public function index(Request $request): RedirectResponse
    {
        return $request->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }

    /**
     * Render the admin dashboard.
     */
    public function admin(): View
    {
        return view('dashboard.admin', [
            'title' => 'Dashboard Admin',
            'studentsCount' => Student::query()->count(),
            'galleryCount' => GalleryItem::query()->count(),
            'usersCount' => User::query()->count(),
            'messagesCount' => ContactMessage::query()->count(),
            'unreadMessagesCount' => ContactMessage::query()->where('is_read', false)->count(),
            'siteSetting' => SiteSetting::current(),
        ]);
    }

    /**
     * Render the user dashboard.
     */
    public function user(Request $request): View
    {
        return view('dashboard.user', [
            'title' => 'Dashboard User',
            'user' => $request->user(),
            'studentsCount' => User::query()->where('role', 'user')->count(),
            'galleryCount' => GalleryItem::query()->count(),
        ]);
    }
}
