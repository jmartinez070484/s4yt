<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;
use App\User;

class Ticket extends Model
{
    protected $table = 'tickets';

    /*

        Get Item

    */
    public function item(){
        return $this->belongsTo(Item::class,'item_id');
    }

    /*

        Get Winner

    */
    public function winner(){
        return $this->belongsTo(User::class,'user_id');
    }
}
