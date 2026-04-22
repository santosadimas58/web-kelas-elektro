<?php

namespace App\Providers;

use App\Models\SiteSetting;
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
        View::composer(['layouts.public', 'partials.navbar', 'partials.footer'], function ($view): void {
            if (! Schema::hasTable('site_settings')) {
                return;
            }

            $view->with('sharedSiteSetting', SiteSetting::current());
        });
    }
}
