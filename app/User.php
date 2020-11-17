<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Role;
use App\UserMeta;
use App\Ticket;
use App\Question;
use App\Answer;
use App\Business;
use App\Connect;

class User extends Authenticatable
{
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name','email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => UserCreated::class,
        'deleting' => UserDeleted::class
    ];

    /*

        Get connect

    */
    public function connect(){
        return $this->hasMany(Connect::class,'user_id','id');
    }

    /*

        Get answers

    */
    public function answers(){
        return $this->hasMany(Answer::class,'user_id','id');
    }

    /*

        Get user roles

    */
    public function role(){
        return $this->hasOne(Role::class,'id','role_id');
    }

    /*

        Get business

    */
    public function business(){
        return $this->hasOne(Business::class,'user_id','id');
    }

    /*

        Get tickets

    */
    public function tickets(){
        return $this->hasMany(Ticket::class,'user_id','id');
    }

    /*

        Route slug

    */
    public function getRouteKeyName(){
        return 'id';
    }
}
