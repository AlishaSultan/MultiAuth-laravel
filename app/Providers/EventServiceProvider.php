<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\UserLoggedIn;
use App\Listeners\StoreUserLoginHistory;
use App\Listeners\SendNotification;
use App\Listeners\SendAdminNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * @var array
     */

     protected $listen = [
        UserLoggedIn::class=>[
            StoreUserLoginHistory::class,
            SendNotification::class,
            SendAdminNotification::class
         ],
     ];
    

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
