<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Tambahkan event listener di sini jika perlu
    ];

    public function boot(): void
    {
        //
    }
}