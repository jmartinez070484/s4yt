<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Answer;
use App\Business;

class Scholarship extends Model
{
    /*

        Get user

    */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    /*

        Get user

    */
    public function answer(){
        return $this->belongsTo(Answer::class,'answer_id','id');
    }

    /*

        Get user

    */
    public function business(){
        return $this->belongsTo(Business::class,'business_id','id');
    }
}
