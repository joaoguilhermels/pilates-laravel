<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // Permitted mass assingment fields
    protected $fillable = [
      'name',
      'phone',
      'email'
    ];
    
    public function clientPlans()
    {
        return $this->hasMany('App\ClientPlan');
    }

    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }
}
