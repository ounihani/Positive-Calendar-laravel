<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Post extends Model
{
    protected $appends = array('creation_time');
    public function getCreationTimeAttribute()
    {
        Carbon::setLocale('fr');
        if($this->created_at){
            return $this->created_at->diffForHumans();
        }else{
            return "no time";
        }
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function votes(){
        return $this->HasMany('App\Vote');
    }
}
