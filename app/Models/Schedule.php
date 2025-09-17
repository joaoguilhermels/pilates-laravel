<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Client;
use App\Models\ClassType;
use App\Models\Professional;
use App\Models\ClassTypeStatus;
use App\Models\ClientPlanDetail;
use App\Models\FinancialTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model //implements \MaddHatter\LaravelFullcalendar\IdentifiableEvent
{
    use HasFactory, SoftDeletes;
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
      'observation',
    ];

    protected $with = ['clientPlanDetail.clientPlan.plan', 'professional', 'client', 'room', 'classType', 'classTypeStatus'];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function scheduable()
    {
        return $this->morphTo();
    }

    public function classType()
    {
        return $this->belongsTo(ClassType::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function classTypeStatus()
    {
        return $this->belongsTo(ClassTypeStatus::class);
    }

    public function clientPlanDetail()
    {
        return $this->belongsTo(ClientPlanDetail::class, 'scheduable_id');
    }

    public function financialTransactions()
    {
        return $this->morphMany(FinancialTransaction::class, 'financiable');
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
     * Get the event's id number.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the event's title.
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
        return (bool) $this->all_day;
    }

    /**
     * Get the start time.
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the end time.
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Optional FullCalendar.io settings for this event.
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
