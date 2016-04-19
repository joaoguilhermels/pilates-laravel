<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinacialTransaction extends Model
{
    protected $fillable = [
      'entity_id',
      'entity_type',
      'type',
      'payment_method_id',
      'bank_account_id',
      'date',
      'value',
      'payment_number',
      'total_number_of_payments',
      'status',
      'confirmed_value',
      'confirmed_date',
      'observation'
    ];

    /**
     * Get all of the owning imageable models.
     */
    public function financiable()
    {
        return $this->morphTo();
    }
}