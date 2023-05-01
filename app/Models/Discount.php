<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\ClassType;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    /**
     * Get all of the classes that are assigned this discount.
     */
    public function classTypes()
    {
        return $this->morphedByMany(ClassType::class, 'discountable');
    }

    /**
     * Get all of the plans that are assigned this discount.
     */
    public function plans()
    {
        return $this->morphedByMany(Plan::class, 'discountable');
    }
}
