<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Room;
use App\Models\Discount;
use App\Models\Schedule;
use App\Models\ClientPlan;
use App\Models\Professional;
use App\Models\ClassTypeStatus;
use Illuminate\Database\Eloquent\Model;

class ClassType extends Model
{
    //
    protected $fillable = [
      'name',
      'max_number_of_clients',
      'duration',
      'extra_class_price',
      'trial',
    ];

    /**
     * The roles that belong to the user.
     */
    public function professionals()
    {
        return $this->belongsToMany(Professional::class)
                    ->withPivot('value', 'value_type')
                    ->withTimestamps();
    }

    /**
     * Discounts associated with this Class.
     */
    public function discounts()
    {
        return $this->morphToMany(Discount::class, 'discountable');
    }

    /**
     * The rooms where this class can be given.
     */
    public function rooms()
    {
        return $this->belongsToMany(Room::class)
                    ->withTimestamps();
    }

    /**
     * The statuses of this class.
     */
    public function statuses()
    {
        return $this->hasMany(ClassTypeStatus::class);
    }

    /**
     * The plans of this class.
     */
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function clientPlans()
    {
        return $this->hasMany(ClientPlan::class);
    }

    public function scopeWithExtraClass($query)
    {
        return $query->where('extra_class', true)->orderBy('name');
    }

    public function scopeWithTrial($query)
    {
        return $query->where('trial', true)->orderBy('name');
    }
}
