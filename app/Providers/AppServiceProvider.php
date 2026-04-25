<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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

        View::composer(['layouts.public', 'layouts.app', 'layouts.guest', 'partials.navbar', 'partials.footer'], function ($view): void {
            if (! Schema::hasTable('site_settings')) {
                return;
            }

            $view->with('sharedSiteSetting', SiteSetting::current());
        });
    }
}
