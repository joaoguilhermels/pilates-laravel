<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPlan extends Model
{
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function plan()
    {
        return $this->hasOne('App\Plan');
    }
    
    public function professionals()
    {
        return $this->hasMany('App\Professional');
    }

    public function rooms()
    {
        return $this->hasMany('App\Room');
    }
}
