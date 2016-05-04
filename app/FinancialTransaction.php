<?php

namespace App;

use App\Professional;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
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

    protected $datas = ['confirmed_date'];
    
    /**
     * Get all of the owning imageable models.
     */
    public function financiable()
    {
        return $this->morphTo();
    }
    
    public function paymentMethod() {
        return $this->belongsTo('App\PaymentMethod');
    }
    
    public function bankAccount() {
        return $this->belongsTo('App\BankAccount');        
    }
}