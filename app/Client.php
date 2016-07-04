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

    public function scopeFilter($query, $params)
    {
        if ( isset($params['name']) && trim($params['name']) !== '' )
        {
            $query->where('name', 'LIKE', trim($params['name'] . '%'));
        }

        if ( isset($params['email']) && trim($params['email']) !== '' )
        {
            $query->where('email', '=', trim($params['email']));
        }

        if ( isset($params['phone']) && trim($params['phone']) !== '' )
        {
            $query->where('phone', '=', trim($params['phone']));
        }

        return $query;
    }
}
