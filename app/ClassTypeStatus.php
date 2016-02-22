<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassTypeStatus extends Model
{
    protected $fillable = [
      'id',
      'name',
      'charge_client',
      'pay_professional',
      'color'
    ];
  
    /**
     * The rooms where this class can be given.
     */
    public function classType()
    {
        return $this->belongsTo('App\ClassType');
    }
    
    public function getChargeClientAttribute($value)
    {
        return $value == 1 ? true : false;
    }

    public function getPayProfessionalAttribute($value)
    {
        return $value == 1 ? true : false;
    }
}
