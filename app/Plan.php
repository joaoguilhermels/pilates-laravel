<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    // Permitted mass assingment fields
    protected $fillable = [
        'name',
        'class_type_id',
        'times',
        'times_type',
        'duration',
        'duration_type',
        'price',
        'price_type'
    ];
    
    /**
     * The roles that belong to the user.
     */
    public function classType()
    {
        return $this->belongsTo(\App\ClassType::class);
    }

    /**
     * Discounts associated with this Plan.
     */
    public function plans()
    {
        return $this->morphToMany(\App\Plan::class, 'discountable');
    }

    public function getNameWithClassAttribute()
    {
        return $this->classType->name . ' - ' . $this->name . ' - ' . $this->times . ' per ' . $this->times_type;
    }
}
