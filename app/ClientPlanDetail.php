<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPlanDetail extends Model
{
    protected $fillable = [
      'client_plan_id',
      'day_of_week',
      'hour',
      'professional_id',
      'room_id'
    ];

    public function clientPlan()
    {
        return $this->belongsTo('App\ClientPlan');
    }
}
