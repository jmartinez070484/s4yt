<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Business;

class Connect extends Model
{
    protected $table = 'connects';

    /*

        Get business

    */
    public function business(){
        return $this->hasOne(Business::class,'business_id','id');
    }
}
