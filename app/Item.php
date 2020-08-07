<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Ticket;
use App\User;

class Item extends Model
{
    protected $table = 'items';

    /*

        Get winner details

    */
    public function ticket_winner(){
        return $this -> status === 2 ? $this->belongsTo(User::class,'user_id') : [];
    }

    /*

        Get tickets

    */
    public function user_tickets(){
        return Auth::check() ? $this->hasMany(Ticket::class,'item_id','id')->where('user_id',Auth::id()) : [];
    }
}
