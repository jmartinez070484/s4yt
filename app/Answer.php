<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Question;
use App\Scholarship;

class Answer extends Model
{
    protected $table = 'answers';

    /*

        Get user

    */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    /*

        Get question

    */
    public function question(){
        return $this->belongsTo(Question::class,'question_id');
    }

    /*

        Get scholarship

    */
    public function scholarship(){
        return $this->hasOne('App\Scholarship','answer_id');
    }
}
