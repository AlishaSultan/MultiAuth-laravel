<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Notifications\NotifyAdminForNewUser;

class SendAdminNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public $queue = 'notify';

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoggedIn $event): void
    {
        // Fetch the admin email from the User table where the role is 'admin'
        $admin = User::where('role','admin')->first(); // Get the admin email

        // Notify admin if email is found
        if ($admin) {
            $this->routeNotificationForMail($admin) // Use the fetched admin email
                 ->notify(new NotifyAdminForNewUser($event->user)); // Send notification
        }
    }

    /**
     * Override the method to specify the email to send notifications to.
     */
    public function routeNotificationForMail($admin)
    {
        return $admin; // Return the correct variable name
    }
}
?>