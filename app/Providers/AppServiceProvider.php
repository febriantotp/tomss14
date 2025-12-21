<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Filament\Facades\Filament;

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
        // Daftarkan panel dari bootstrap/providers.php
        Filament::registerPanels(require base_path('bootstrap/providers.php'));

        // Pastikan storage link otomatis di production
        if (app()->environment('production')) {
            $publicStorage = public_path('storage');
            if (!is_link($publicStorage)) {
                Artisan::call('storage:link');
            }
        }
    }
}
