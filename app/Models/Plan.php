<?php

namespace App\Models;

use App\Models\ClassType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;
    // Permitted mass assingment fields
    protected $fillable = [
        'name',
        'class_type_id',
        'times',
        'times_type',
        'duration',
        'duration_type',
        'price',
        'price_type',
    ];

    /**
     * The roles that belong to the user.
     */
    public function classType()
    {
        return $this->belongsTo(ClassType::class);
    }

    /**
     * Discounts associated with this Plan.
     */
    public function plans()
    {
        return $this->morphToMany(self::class, 'discountable');
    }

    public function getNameWithClassAttribute()
    {
        return $this->classType->name.' - '.$this->name.' - '.$this->times.' per '.$this->times_type;
    }
}
