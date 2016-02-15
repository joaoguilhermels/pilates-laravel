<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassType extends Model
{
    //
    protected $fillable = [
      'name',
      'max_number_of_clients',
      'duration'
    ];

    /**
     * The roles that belong to the user.
     */
    public function professionals()
    {
        return $this->belongsToMany('App\Professional')->withTimestamps();
    }
}
