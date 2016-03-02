<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    // Permitted mass assingment fields
    protected $fillable = [
      'client_id',
      'plan_id',
      'class_type_id',
      'professional_id',
      'room_id',
      'class_type_status_id',
      'start_at',
      'end_at'
    ];
    
    //protected $dates = ['start_at', 'end_at'];
    
    /**
     * The roles that belong to the user.
     */
    public function classType()
    {
        return $this->belongsTo('App\ClassType');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function professional()
    {
        return $this->belongsTo('App\Professional');
    }
    
    public function room()
    {
        return $this->belongsTo('App\Room');
    }
    
    public function classTypestatus()
    {
        return $this->belongsTo('App\ClassTypeStatus');
    }

    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    public function status()
    {
        return $this->hasOne('App\Plan');
    }
}
