<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Business;

class Visit extends Model
{
    protected $table = 'visits';

    /*

        Get user

    */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    /*

        Get business

    */
    public function business(){
        return $this->belongsTo(Business::class,'business_id');
    }
}
