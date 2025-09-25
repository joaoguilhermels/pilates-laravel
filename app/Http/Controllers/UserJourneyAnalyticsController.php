<?php

namespace App\Http\Controllers;

use App\Models\UserJourneyEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserJourneyAnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Only allow system admins and studio owners to view analytics
        $this->middleware('role:system_admin,studio_owner');
    }

    /**
     * Display user journey analytics dashboard
     */
    public function index(Request $request)
    {
        $dateRange = $this->getDateRange($request);
        $persona = $request->get('persona');

        $data = [
            'conversionFunnel' => $this->getConversionFunnel($persona, $dateRange),
            'featureAdoption' => $this->getFeatureAdoption($persona),
            'timeToValue' => $this->getTimeToValue($persona),
            'userGrowth' => $this->getUserGrowth($dateRange),
            'personaDistribution' => $this->getPersonaDistribution($dateRange),
            'topSources' => $this->getTopSources($dateRange),
            'recentEvents' => $this->getRecentEvents(),
        ];

        return view('analytics.user-journey', compact('data', 'dateRange', 'persona'));
    }

    /**
     * Get conversion funnel data
     */
    private function getConversionFunnel($persona = null, $dateRange = null)
    {
        return UserJourneyEvent::getConversionFunnel($persona, $dateRange['start'], $dateRange['end']);
    }

    /**
     * Get feature adoption metrics
     */
    private function getFeatureAdoption($persona = null, $days = 30)
    {
        return UserJourneyEvent::getFeatureAdoption($persona, $days);
    }

    /**
     * Get time to value metrics
     */
    private function getTimeToValue($persona = null)
    {
        $events = [
            'first_client_added' => UserJourneyEvent::EVENT_FIRST_CLIENT_ADDED,
            'first_schedule_created' => UserJourneyEvent::EVENT_FIRST_SCHEDULE_CREATED,
            'onboarding_complete' => UserJourneyEvent::EVENT_ONBOARDING_COMPLETE,
        ];

        $results = [];
        foreach ($events as $label => $event) {
            $data = UserJourneyEvent::getTimeToValue($event, $persona);
            $results[$label] = [
                'average_hours' => $data->avg('hours_to_value'),
                'median_hours' => $data->median('hours_to_value'),
                'count' => $data->count(),
            ];
        }

        return $results;
    }

    /**
     * Get user growth over time
     */
    private function getUserGrowth($dateRange)
    {
        return UserJourneyEvent::where('event_name', UserJourneyEvent::EVENT_SIGNUP)
            ->whereBetween('event_timestamp', [$dateRange['start'], $dateRange['end']])
            ->selectRaw('DATE(event_timestamp) as date, COUNT(*) as signups')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get persona distribution
     */
    private function getPersonaDistribution($dateRange)
    {
        return UserJourneyEvent::whereBetween('event_timestamp', [$dateRange['start'], $dateRange['end']])
            ->whereNotNull('persona_type')
            ->selectRaw('persona_type, COUNT(DISTINCT user_id) as unique_users')
            ->groupBy('persona_type')
            ->get();
    }

    /**
     * Get top traffic sources
     */
    private function getTopSources($dateRange)
    {
        return UserJourneyEvent::whereBetween('event_timestamp', [$dateRange['start'], $dateRange['end']])
            ->whereNotNull('source')
            ->selectRaw('source, medium, COUNT(DISTINCT session_id) as sessions')
            ->groupBy('source', 'medium')
            ->orderBy('sessions', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get recent events for activity feed
     */
    private function getRecentEvents($limit = 50)
    {
        return UserJourneyEvent::with('user')
            ->orderBy('event_timestamp', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get date range from request or default to last 30 days
     */
    private function getDateRange(Request $request)
    {
        $start = $request->get('start_date') 
            ? Carbon::parse($request->get('start_date'))
            : Carbon::now()->subDays(30);
            
        $end = $request->get('end_date')
            ? Carbon::parse($request->get('end_date'))
            : Carbon::now();

        return [
            'start' => $start,
            'end' => $end,
        ];
    }

    /**
     * API endpoint for real-time analytics
     */
    public function api(Request $request)
    {
        $type = $request->get('type');
        $persona = $request->get('persona');
        $dateRange = $this->getDateRange($request);

        $data = match($type) {
            'funnel' => $this->getConversionFunnel($persona, $dateRange),
            'features' => $this->getFeatureAdoption($persona),
            'growth' => $this->getUserGrowth($dateRange),
            'personas' => $this->getPersonaDistribution($dateRange),
            'sources' => $this->getTopSources($dateRange),
            default => ['error' => 'Invalid type'],
        };

        return response()->json($data);
    }

    /**
     * Export analytics data
     */
    public function export(Request $request)
    {
        $dateRange = $this->getDateRange($request);
        $persona = $request->get('persona');

        $data = [
            'conversion_funnel' => $this->getConversionFunnel($persona, $dateRange),
            'feature_adoption' => $this->getFeatureAdoption($persona),
            'time_to_value' => $this->getTimeToValue($persona),
            'user_growth' => $this->getUserGrowth($dateRange),
            'persona_distribution' => $this->getPersonaDistribution($dateRange),
            'top_sources' => $this->getTopSources($dateRange),
        ];

        $filename = 'user_journey_analytics_' . now()->format('Y-m-d_H-i-s') . '.json';

        return response()->json($data)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
