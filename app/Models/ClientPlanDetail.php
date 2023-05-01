<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Schedule;
use App\Models\ClientPlan;
use App\Models\Professional;
use Illuminate\Database\Eloquent\Model;

class ClientPlanDetail extends Model
{
    protected $fillable = [
      'client_plan_id',
      'day_of_week',
      'hour',
      'professional_id',
      'room_id',
    ];

    public function clientPlan()
    {
        return $this->belongsTo(ClientPlan::class);
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function schedules()
    {
        return $this->morphMany(Schedule::class, 'scheduable');
    }

    public function getDayOfWeekAttribute($value)
    {
        return date('l', strtotime("Sunday +{$value} days"));
    }

    public function getHourAttribute($value)
    {
        return date('H:i', strtotime($value));
    }
}
