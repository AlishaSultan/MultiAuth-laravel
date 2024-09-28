<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Users;
use App\Notifications\WelcomeUserNotification;

class SendNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     */

    public $queue = 'notification';
    
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoggedIn $event): void
    {
        $email = $event->user;
        $email->notify(new WelcomeUserNotification($email));
    }
}
