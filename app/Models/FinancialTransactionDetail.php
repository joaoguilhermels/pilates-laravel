<?php

namespace App\Models;

use App\Models\BankAccount;
use App\Models\PaymentMethod;
use App\Models\FinancialTransaction;
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
      'observation',
    ];

    public function financialTransaction()
    {
        return $this->belongsTo(FinancialTransaction::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
