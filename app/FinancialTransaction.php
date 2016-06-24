<?php

namespace App;

use App\Professional;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    protected $fillable = [
      'financiable_id',
      'financiable_type',
      'name',
      'type',
      'total_number_of_payments',
      'observation'
    ];

    /**
     * Get all of the owning imageable models.
     */
    public function financiable()
    {
        return $this->morphTo();
    }

    public function financialTransactionDetails() {
        return $this->hasMany('App\FinancialTransactionDetails');
    }
}
