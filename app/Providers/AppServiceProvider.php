<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-admin-panel', fn (User $user): bool => $user->hasRole('admin'));
        Gate::define('upload-gallery', fn (User $user): bool => $user->hasRole('user'));

        RateLimiter::for('contact-form', fn (Request $request) => Limit::perMinute(3)->by($request->ip()));
        RateLimiter::for('gallery-upload', fn (Request $request) => Limit::perMinute(6)->by($request->user()?->id ?: $request->ip()));
        RateLimiter::for('password-reset', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));
        RateLimiter::for('auth-sensitive', fn (Request $request) => Limit::perMinute(5)->by($request->user()?->id ?: $request->ip()));

        View::composer(['layouts.public', 'layouts.app', 'layouts.guest', 'partials.navbar', 'partials.footer'], function ($view): void {
            if (! Schema::hasTable('site_settings')) {
                return;
            }

            $view->with('sharedSiteSetting', SiteSetting::current());
        });
    }
}
