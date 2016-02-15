<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // Permitted mass assingment fields
    protected $fillable = [
      'name',
      'phone',
      'email'
    ];
}
