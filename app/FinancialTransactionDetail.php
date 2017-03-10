<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialTransactionDetail extends Model
{
    protected $fillable = [
      'financial_transaction_id',
      'payment_method_id',
      'bank_account_id',
      'date',
      'value',
      'type',
      'payment_number',
      'observation'
    ];

    public function financialTransaction()
    {
        return $this->belongsTo(\App\FinancialTransaction::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(\App\PaymentMethod::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(\App\BankAccount::class);
    }
}
