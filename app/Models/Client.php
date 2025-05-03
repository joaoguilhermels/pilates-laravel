<?php

namespace App\Models;

use App\Models\Schedule;
use App\Models\ClientPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Client extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'name',
      'phone',
      'email',
      'observation',
    ];
    
    /**
     * Get the client plans for the client.
     */
    public function clientPlans(): HasMany
    {
        return $this->hasMany(ClientPlan::class);
    }

    /**
     * Get the schedules for the client.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /*public function scopePendingRepositions($query)
    {
        return $query->join('schedules', 'schedules.client_id', '=', 'clients.id', 'left outer')
                ->join('class_type_statuses', 'schedules.class_type_status_id', '=', 'class_type_statuses.id', 'left outer')
                ->where('class_type_statuses.name', '=', 'Desmarcou')
                ->where('schedules.parent_id', '=', 0)
                ->select('schedules.*');
    }*/

    /**
     * Scope a query to filter clients.
     */
    public function scopeFilter(Builder $query, array $params): Builder
    {
        if (isset($params['name']) && trim($params['name']) !== '') {
            $query->where('name', 'LIKE', trim($params['name'].'%'));
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
