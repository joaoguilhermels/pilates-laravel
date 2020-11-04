<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
      'name',
      'bank',
      'agency',
      'account',
      'balance',
    ];
}
