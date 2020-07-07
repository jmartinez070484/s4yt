<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Business;

class Question extends Model
{
    protected $table = 'questions';

    /*

        Get business

    */
    public function business(){
        return $this->belongsTo(Business::class,'business_id');
    }

    /*

        Get useranswers

    */
    public function user_answer(){
        return Auth::check() ? $this->hasOne(Answer::class,'question_id','id') -> where('user_id',Auth::id()) : [];
    }

    /*

        Get answers

    */
    public function answers(){
        return $this->hasMany(Answer::class,'question_id','id');
    }
}
