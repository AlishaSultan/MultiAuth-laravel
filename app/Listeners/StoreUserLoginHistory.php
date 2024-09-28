<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\UsersHistory;


class StoreUserLoginHistory implements ShouldQueue
{
  
    public $queue = 'history';


    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoggedIn $event): void
    {
        $user_info = $event->user;
        $historydata = UsersHistory::create([
            'name'=>$user_info->name,
            'email'=>$user_info->email,
            'role'=>$user_info->role,
            'status'=>'active',
            'login_time'=>now(),
       ]);
    }
}
