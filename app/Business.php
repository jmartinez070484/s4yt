<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Question;
use App\Schedule;

class Business extends Model
{
    protected $table = 'businesses';

    /*

        Get user

    */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    /*

        Get user roles

    */
    public function question(){
        return $this->hasOne(Question::class,'business_id','id');
    }

    /*

        Get user roles

    */
    public function schedule(){
        return $this->hasMany(Schedule::class,'business_id','id') -> orderBy('created_at','ASC');
    }

    /*

        Route slug

    */
    public function getRouteKeyName(){
	    return 'slug';
	}
}
