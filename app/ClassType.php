<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassType extends Model
{
    //
    protected $fillable = [
      'name',
      'max_number_of_clients',
      'duration',
      'extra_class_price',
      'trial'
    ];

    /**
     * The roles that belong to the user.
     */
    public function professionals()
    {
        return $this->belongsToMany('App\Professional')
                    ->withPivot('value', 'value_type')
                    ->withTimestamps();
    }

    /**
     * Discounts associated with this Class.
     */
    public function discounts()
    {
        return $this->morphToMany('App\Discount', 'discountable');
    }

    /**
     * The rooms where this class can be given.
     */
    public function rooms()
    {
        return $this->belongsToMany('App\Room')
                    ->withTimestamps();
    }

    /**
     * The statuses of this class.
     */
    public function statuses()
    {
        return $this->hasMany('App\ClassTypeStatus');
    }

    /**
     * The plans of this class.
     */
    public function plans()
    {
        return $this->hasMany('App\Plan');
    }

    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }

    public function clientPlans()
    {
        return $this->hasMany('App\ClientPlan');
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
