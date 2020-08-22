<?php

namespace App\Listeners;

use App\Events\BusinessCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Ticket;
use App\Scholarship;

class CreatedBusiness
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
    public function handle(BusinessCreated $event)
    {
        $business = $event -> business;

        if($business){
            for($x=0;$x<5;$x++){
                $scholarship = new Scholarship();
                $scholarship -> business_id = $business -> id;
                $scholarship -> name = 'Scholarship '.($x + 1);
                $scholarship -> amount = ($x + 1) * 100;
                $scholarship -> save();
            }
        }
    }
}
