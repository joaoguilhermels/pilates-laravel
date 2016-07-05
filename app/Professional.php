<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    // Permitted mass assingment fields
    protected $fillable = [
      'name',
      'phone',
      'email',
    ];

    public function financialTransactions() {
        return $this->morphMany('App\FinancialTransaction', 'financiable');
    }

    /**
     * The class types given by the professional
     */
    public function classTypes()
    {
        return $this->belongsToMany('App\ClassType')->withPivot('value', 'value_type')->withTimestamps();
    }

    public function scheudles()
    {
        return $this->hasMany('App\Schedules')->withTimestamps();
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

    public function scopeGivingTrialClasses($query)
    {
        return $query->join('class_type_professional', 'professionals.id', '=', 'class_type_professional.professional_id')
          ->join('class_types', 'class_types.id', '=', 'class_type_professional.class_type_id')
          ->where('class_types.free_trial', '=', 'true');
    }
}
