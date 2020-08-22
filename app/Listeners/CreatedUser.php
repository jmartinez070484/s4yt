<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Password;
use App\Notifications\StudentRegistrationEmail;
use App\Notifications\BusinessRegistrationEmail;
use App\Ticket;

class CreatedUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = $event -> user;
        $role = $user ? $event -> user -> role : null;

        if($role -> id === 2){
            $defaultTickets = env('APP_DEFAULT_TICKETS');

            for($x=0;$x<$defaultTickets;$x++){
                $ticket = new Ticket();
                $ticket -> user_id = $user -> id;
                $ticket -> save();
            }
        }

        if($role -> id === 2){
            $user -> notify(new StudentRegistrationEmail());
        }

        if($role -> id === 3){
            $user -> notify(new BusinessRegistrationEmail());
        }
    }
}
