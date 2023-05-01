<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Client;
use App\Models\ClassType;
use App\Models\ClientPlanDetail;
use App\Models\FinancialTransaction;
use Illuminate\Database\Eloquent\Model;

class ClientPlan extends Model
{
    protected $fillable = [
      'plan_id',
      'start_at',
    ];

    protected $with = ['clientPlanDetails', 'financialTransactions'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function classType()
    {
        return $this->belongsTo(ClassType::class);
    }

    public function clientPlanDetails()
    {
        return $this->hasMany(ClientPlanDetail::class);
    }

    public function financialTransactions()
    {
        return $this->morphMany(FinancialTransaction::class, 'financiable');
    }

    /*public function discounts()
    {
        return $this->morphMany('App\Discount', 'discountable');
    }*/
}
