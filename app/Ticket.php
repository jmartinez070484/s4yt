<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class Ticket extends Model
{
    protected $table = 'tickets';

    /*

        Get Item

    */
    public function item(){
        return $this->belongsTo(Item::class,'item_id');
    }
}
