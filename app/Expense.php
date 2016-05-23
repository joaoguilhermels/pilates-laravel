<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
      'name',
      'date',
      'price'
    ];

    /**
     * Get all of the staff member's photos.
     */
    public function financialTransactions()
    {
        return $this->morphMany('App\FinancialTransaction', 'financiable');
    }
}
