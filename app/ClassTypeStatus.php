<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassTypeStatus extends Model
{
    protected $fillable = [
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
        return $this->belongsTo(\App\ClassType::class);
    }
    
    public function getChargeClientAttribute($value)
    {
        return $value == 1 ? true : false;
    }

    public function getPayProfessionalAttribute($value)
    {
        return $value == 1 ? true : false;
    }

    public function setChargeClientAttribute($value)
    {
        $this->attributes['charge_client'] = $value == 'on' ? 1 : 0;
    }

    public function setPayProfessionalAttribute($value)
    {
        $this->attributes['pay_professional'] = $value == 'on' ? 1 : 0;
    }
}
