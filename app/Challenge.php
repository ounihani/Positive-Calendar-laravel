<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Challenge extends Model
{
    public function score(){
        return $this->hasMany('App\Score');
    }

    public function scopeCurrentChallenge($query)
    {
        $today = Carbon::now()->toDateString();
        return $query->where('start_date', '<=' , $today)->where('deadline', '>=' , $today);
    }
}
