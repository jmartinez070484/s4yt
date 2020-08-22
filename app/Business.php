<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Events\BusinessCreated;
use App\Events\BusinessDeleted;
use App\User;
use App\Question;
use App\Schedule;
use App\Visit;
use App\Scholarship;

class Business extends Model
{
    protected $table = 'businesses';

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => BusinessCreated::class,
        'deleting' => BusinessDeleted::class
    ];

    /*

        Get user

    */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    /*

        Get user Visit

    */
    public function visit(){
        return $this->hasMany(Visit::class,'business_id','id');
    }

    /*

        Get question

    */
    public function question(){
        return $this->hasOne(Question::class,'business_id','id');
    }

    /*

        Get scholarships

    */
    public function scholarships(){
        return $this->hasMany(Scholarship::class,'business_id','id') -> orderBy('created_at','ASC');
    }

    /*

        Get schedule

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
