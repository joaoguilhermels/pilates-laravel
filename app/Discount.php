<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
	/**
     * Get all of the classes that are assigned this discount.
     */
    public function classTypes()
    {
        return $this->morphedByMany('App\ClassType', 'discountable');
    }

	/**
     * Get all of the plans that are assigned this discount.
     */
	public function plans()
    {
        return $this->morphedByMany('App\Plan', 'discountable');
    }
}
