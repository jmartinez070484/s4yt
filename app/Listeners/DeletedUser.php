<?php

namespace App\Listeners;

use App\Events\UserDeleted;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Ticket;

class DeletedUser
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
    public function handle(UserDeleted $event)
    {
        $user = $event -> user;
        $role = $user ? $event -> user -> role : null;

        if($role -> id === 3){
            $business = $user -> business;
            
            if($business){
                if($business -> logo && Storage::disk('public') -> exists($business -> logo)){
                    Storage::disk('public') -> delete($business -> logo);
                }

                if($business -> icon && Storage::disk('public') -> exists($business -> icon)){
                    Storage::disk('public') -> delete($business -> icon);
                }   
            }
        }
    }
}
