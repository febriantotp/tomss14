<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Log;

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
        Log::info('Entering Supertomss14PanelProvider::panel');
        // Daftarkan panel dari bootstrap/providers.php
        Log::info('AppServiceProvider boot start');

        Filament::registerPanels(require base_path('bootstrap/providers.php'));
        Log::info('AppServiceProvider boot end');

        


        // Pastikan storage link otomatis di production
        if (app()->environment('production')) {
            $publicStorage = public_path('storage');
            if (!is_link($publicStorage)) {
                Artisan::call('storage:link');
            }
        }
    }
}
