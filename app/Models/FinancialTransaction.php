<?php

namespace App\Models;

use App\Professional;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use App\Models\FinancialTransactionDetail;

class FinancialTransaction extends Model
{
    protected $fillable = [
      'financiable_id',
      'financiable_type',
      'name',
      'total_number_of_payments',
      'observation',
    ];

    protected $with = ['FinancialTransactionDetails'];

    /**
     * Get all of the owning financiable models.
     */
    public function financiable()
    {
        return $this->morphTo();
    }

    public function financialTransactionDetails()
    {
        return $this->hasMany(FinancialTransactionDetail::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
