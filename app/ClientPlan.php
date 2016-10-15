<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPlan extends Model
{
    protected $fillable = [
      'plan_id',
      'start_at'
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    public function classType()
    {
        return $this->belongsTo('App\ClassType');
    }

    public function clientPlanDetails()
    {
        return $this->hasMany('App\ClientPlanDetail');
    }

    public function financialTransactions()
    {
        return $this->morphMany('App\FinancialTransaction', 'financiable');
    }

    public function discounts()
    {
        return $this->morphMany('App\Discount', 'discountable');
    }
}
