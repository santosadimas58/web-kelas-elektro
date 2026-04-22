<?php

use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicPageController::class, 'home'])->name('home');
Route::get('/tentang', [PublicPageController::class, 'about'])->name('about');
Route::get('/mahasiswa', [PublicPageController::class, 'students'])->name('students');
Route::get('/galeri', [PublicPageController::class, 'gallery'])->name('gallery');
Route::get('/kontak', [PublicPageController::class, 'contact'])->name('contact');
Route::post('/kontak', [PublicPageController::class, 'submitContact'])->name('contact.submit');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/user/dashboard', [DashboardController::class, 'user'])
        ->middleware('role:admin,user')
        ->name('user.dashboard');

    Route::middleware('role:admin,user')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');
        Route::resource('/students', StudentController::class)->except(['show']);
        Route::resource('/gallery', GalleryItemController::class)->except(['show']);
        Route::resource('/users', UserController::class)->except(['show']);
        Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::delete('/messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
    });
});

require __DIR__.'/auth.php';
