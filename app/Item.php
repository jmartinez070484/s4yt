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
    public function winner(){
        return $this->belongsTo(User::class,'user_id');
    }

    /*

        Get total tickets

    */
    public function tickets(){
        return Auth::check() ? $this->hasMany(Ticket::class,'item_id','id')->where('user_id','!=',Auth::id()) : [];
    }

    /*

        Get tickets

    */
    public function user_tickets(){
        return Auth::check() ? $this->hasMany(Ticket::class,'item_id','id')->where('user_id',Auth::id()) : [];
    }
}
