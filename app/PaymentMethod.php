<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
      'name',
      'enabled',
    ];

    public function getEnabledLabelAttribute($value)
    {
        return $value == 1 ? 'Yes' : 'No';
    }
}
