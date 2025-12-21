<?php

namespace App\Providers;

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
        Filament::registerPanels(require base_path('bootstrap/providers.php'));

        if (app()->environment('production')) {
        $publicStorage = public_path('storage');
        if (!is_link($publicStorage)) {
            Artisan::call('storage:link');
        }
    }

    }
}
