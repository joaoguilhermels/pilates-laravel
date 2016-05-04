<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model implements \MaddHatter\LaravelFullcalendar\IdentifiableEvent
{
    // Permitted mass assingment fields
    protected $fillable = [
      'client_id',
      'client_plan_detail_id',
      'class_type_id',
      'professional_id',
      'room_id',
      'class_type_status_id',
      'start_at',
      'end_at'
    ];
    
    protected $dates = ['start_at', 'end_at', 'created_at', 'updated_at'];
    
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
    
    public function classTypeStatus()
    {
        return $this->belongsTo('App\ClassTypeStatus');
    }

    public function status()
    {
        return $this->hasOne('App\Plan');
    }
    
    public function clientPlanDetail()
    {
        return $this->belongsTo('App\ClientPlanDetail');
    }

    /**
     * Get the event's id number
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay()
    {
        return (bool)$this->all_day;
    }

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }
    
    /**
     * Optional FullCalendar.io settings for this event
     *
     * @return array
     */
    public function getEventOptions()
    {
        return [
            'color' => $this->background_color,
            //etc
        ];
    }

}
