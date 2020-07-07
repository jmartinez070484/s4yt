<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Ticket;

class Item extends Model
{
    protected $table = 'items';

    /*

        Get tickets

    */
    public function user_tickets(){
        return Auth::check() ? $this->hasMany(Ticket::class,'item_id','id')->where('user_id',Auth::id()) : [];
    }
}
