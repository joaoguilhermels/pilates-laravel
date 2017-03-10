<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // Permitted mass assingment fields
    protected $fillable = [
      'name',
      'phone',
      'email',
      'observation'
    ];

    public function clientPlans()
    {
        return $this->hasMany(\App\ClientPlan::class);
    }

    public function schedules()
    {
        return $this->hasMany(\App\Schedule::class);
    }

    /*public function scopePendingRepositions($query)
    {
        return $query->join('schedules', 'schedules.client_id', '=', 'clients.id', 'left outer')
                ->join('class_type_statuses', 'schedules.class_type_status_id', '=', 'class_type_statuses.id', 'left outer')
                ->where('class_type_statuses.name', '=', 'Desmarcou')
                ->where('schedules.parent_id', '=', 0)
                ->select('schedules.*');
    }*/

    public function scopeFilter($query, $params)
    {
        if (isset($params['name']) && trim($params['name']) !== '') {
            $query->where('name', 'LIKE', trim($params['name'] . '%'));
        }

        if (isset($params['email']) && trim($params['email']) !== '') {
            $query->where('email', '=', trim($params['email']));
        }

        if (isset($params['phone']) && trim($params['phone']) !== '') {
            $query->where('phone', '=', trim($params['phone']));
        }

        return $query;
    }
}
