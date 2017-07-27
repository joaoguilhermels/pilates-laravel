<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPlan extends Model
{
    protected $fillable = [
      'plan_id',
      'start_at'
    ];

    protected $with = ['clientPlanDetails', 'financialTransactions'];

    public function client()
    {
        return $this->belongsTo(\App\Client::class);
    }

    public function plan()
    {
        return $this->belongsTo(\App\Plan::class);
    }

    public function classType()
    {
        return $this->belongsTo(\App\ClassType::class);
    }

    public function clientPlanDetails()
    {
        return $this->hasMany(\App\ClientPlanDetail::class);
    }

    public function financialTransactions()
    {
        return $this->morphMany(\App\FinancialTransaction::class, 'financiable');
    }

    /*public function discounts()
    {
        return $this->morphMany('App\Discount', 'discountable');
    }*/
}
