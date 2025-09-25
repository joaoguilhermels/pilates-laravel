<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserJourneyEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'event_type',
        'event_name',
        'persona_type',
        'source',
        'medium',
        'campaign',
        'properties',
        'page_url',
        'user_agent',
        'ip_address',
        'event_timestamp',
    ];

    protected $casts = [
        'properties' => 'array',
        'event_timestamp' => 'datetime',
    ];

    // Journey stage constants
    public const STAGE_AWARENESS = 'awareness';
    public const STAGE_CONSIDERATION = 'consideration';
    public const STAGE_TRIAL = 'trial';
    public const STAGE_ADOPTION = 'adoption';
    public const STAGE_ADVOCACY = 'advocacy';

    // Persona type constants
    public const PERSONA_MARINA = 'marina'; // Independent Professional
    public const PERSONA_CARLOS = 'carlos'; // Studio Owner
    public const PERSONA_ANA = 'ana'; // Studio Employee
    public const PERSONA_LUCIA = 'lucia'; // Client

    // Common event names
    public const EVENT_PAGE_VIEW = 'page_view';
    public const EVENT_SIGNUP = 'signup';
    public const EVENT_LOGIN = 'login';
    public const EVENT_TRIAL_START = 'trial_start';
    public const EVENT_ONBOARDING_COMPLETE = 'onboarding_complete';
    public const EVENT_FIRST_CLIENT_ADDED = 'first_client_added';
    public const EVENT_FIRST_SCHEDULE_CREATED = 'first_schedule_created';
    public const EVENT_FIRST_PAYMENT_RECORDED = 'first_payment_recorded';
    public const EVENT_SUBSCRIPTION_CREATED = 'subscription_created';
    public const EVENT_FEATURE_USED = 'feature_used';
    public const EVENT_REFERRAL_SENT = 'referral_sent';

    /**
     * Get the user that owns the journey event
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for filtering by journey stage
     */
    public function scopeStage($query, string $stage)
    {
        return $query->where('event_type', $stage);
    }

    /**
     * Scope for filtering by persona type
     */
    public function scopePersona($query, string $persona)
    {
        return $query->where('persona_type', $persona);
    }

    /**
     * Scope for filtering by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('event_timestamp', [$startDate, $endDate]);
    }

    /**
     * Get events for a specific user session
     */
    public function scopeSession($query, string $sessionId)
    {
        return $query->where('session_id', $sessionId)->orderBy('event_timestamp');
    }

    /**
     * Get conversion funnel data
     */
    public static function getConversionFunnel(string $persona = null, $startDate = null, $endDate = null)
    {
        $query = static::query();
        
        if ($persona) {
            $query->persona($persona);
        }
        
        if ($startDate && $endDate) {
            $query->dateRange($startDate, $endDate);
        }

        return $query->selectRaw('
            event_type,
            COUNT(DISTINCT session_id) as unique_sessions,
            COUNT(DISTINCT user_id) as unique_users,
            COUNT(*) as total_events
        ')
        ->groupBy('event_type')
        ->orderByRaw("FIELD(event_type, 'awareness', 'consideration', 'trial', 'adoption', 'advocacy')")
        ->get();
    }

    /**
     * Get feature adoption metrics
     */
    public static function getFeatureAdoption(string $persona = null, $days = 30)
    {
        $query = static::query()
            ->where('event_name', static::EVENT_FEATURE_USED)
            ->where('event_timestamp', '>=', now()->subDays($days));
            
        if ($persona) {
            $query->persona($persona);
        }

        return $query->selectRaw('
            JSON_UNQUOTE(JSON_EXTRACT(properties, "$.feature_name")) as feature_name,
            COUNT(DISTINCT user_id) as unique_users,
            COUNT(*) as usage_count
        ')
        ->groupBy('feature_name')
        ->orderBy('unique_users', 'desc')
        ->get();
    }

    /**
     * Get time to value metrics
     */
    public static function getTimeToValue(string $valueEvent, string $persona = null)
    {
        $query = static::query()
            ->where('event_name', $valueEvent);
            
        if ($persona) {
            $query->persona($persona);
        }

        return $query->selectRaw('
            user_id,
            MIN(event_timestamp) as first_value_time,
            TIMESTAMPDIFF(HOUR, 
                (SELECT MIN(event_timestamp) FROM user_journey_events uje2 
                 WHERE uje2.user_id = user_journey_events.user_id 
                 AND uje2.event_name = "signup"), 
                MIN(event_timestamp)
            ) as hours_to_value
        ')
        ->groupBy('user_id')
        ->having('hours_to_value', '>', 0)
        ->get();
    }
}
