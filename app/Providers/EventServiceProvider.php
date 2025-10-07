<?php

namespace App\Providers;

use App\Listeners\UpdateIsVerifiedOnLogout;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //parent::booted();

        // Register the listener for the Logout event
        Event::listen(Logout::class, UpdateIsVerifiedOnLogout::class);
    }
}
