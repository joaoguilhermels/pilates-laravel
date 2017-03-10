<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model implements \MaddHatter\LaravelFullcalendar\IdentifiableEvent
{
    protected $fillable = [
      'parent_id',
      'client_id',
      'class_type_id',
      'professional_id',
      'room_id',
      'class_type_status_id',
      'trial',
      'price',
      'start_at',
      'end_at',
      'observation'
    ];

    protected $with = ['clientPlanDetail.clientPlan.plan', 'professional', 'client', 'room', 'classType', 'classTypeStatus'];

    protected $dates = ['start_at', 'end_at', 'created_at', 'updated_at'];

    public function scheduable()
    {
        return $this->morphTo();
    }

    public function classType()
    {
        return $this->belongsTo(\App\ClassType::class);
    }

    public function client()
    {
        return $this->belongsTo(\App\Client::class);
    }

    public function professional()
    {
        return $this->belongsTo(\App\Professional::class);
    }

    public function room()
    {
        return $this->belongsTo(\App\Room::class);
    }

    public function classTypeStatus()
    {
        return $this->belongsTo(\App\ClassTypeStatus::class);
    }

    public function clientPlanDetail()
    {
        return $this->belongsTo(\App\ClientPlanDetail::class, 'scheduable_id');
    }

    public function financialTransactions()
    {
        return $this->morphMany(\App\FinancialTransaction::class, 'financiable');
    }

    /**
     * Return only unscheduled classes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnscheduled($query, $month, $year)
    {
        return $query->join('class_type_statuses', 'class_type_statuses.class_type_id', 'schedules.class_type_id')
                ->where('class_type_statuses.name', 'Desmarcou')
                ->whereMonth('start_at', $month)
                ->whereYear('start_at', $year)
                ->toSql();
    }

    /**
     * Get the event's id number
     *
     * @return int
     */
    public function getId()
    {
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
