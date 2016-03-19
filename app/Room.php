<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // Permitted mass assingment fields
    protected $fillable = [
      'name',
    ];

    /**
     * The roles that belong to the user.
     */
    public function classTypes()
    {
        return $this->belongsToMany('App\ClassType')->withTimestamps();
    }

    public function getClassTypeListAttribute()
    {
        return $this->classTypes->pluck('id')->all();
    }

    public function getNameWithClassesAttribute()
    {
        $classTypes = $this->classTypes->all();
        $classTypesList = '';

        foreach($classTypes as $classType) {
            $classTypesList .= $classTypesList == '' ? $classType->name : ', ' . $classType->name;
        }

        return $this->name . ' (' . $classTypesList . ')';
    }
}
