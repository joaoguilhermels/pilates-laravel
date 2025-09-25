<?php

namespace App\Services;

use App\Models\UserJourneyEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserJourneyTracker
{
    protected string $sessionId;
    protected ?User $user;
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->sessionId = $request->session()->getId() ?? Str::uuid()->toString();
        $this->user = Auth::user();
    }

    /**
     * Track a user journey event
     */
    public function track(
        string $eventType,
        string $eventName,
        array $properties = [],
        ?string $personaType = null
    ): UserJourneyEvent {
        // Auto-detect persona type if not provided
        if (!$personaType && $this->user) {
            $personaType = $this->detectPersonaType($this->user);
        }

        return UserJourneyEvent::create([
            'user_id' => $this->user?->id,
            'session_id' => $this->sessionId,
            'event_type' => $eventType,
            'event_name' => $eventName,
            'persona_type' => $personaType,
            'source' => $this->request->get('utm_source'),
            'medium' => $this->request->get('utm_medium'),
            'campaign' => $this->request->get('utm_campaign'),
            'properties' => $properties,
            'page_url' => $this->request->fullUrl(),
            'user_agent' => $this->request->userAgent(),
            'ip_address' => $this->request->ip(),
            'event_timestamp' => now(),
        ]);
    }

    /**
     * Track page view
     */
    public function trackPageView(string $pageName = null): UserJourneyEvent
    {
        $properties = [];
        if ($pageName) {
            $properties['page_name'] = $pageName;
        }

        // Determine stage based on page
        $stage = $this->determineStageFromUrl($this->request->path());

        return $this->track($stage, UserJourneyEvent::EVENT_PAGE_VIEW, $properties);
    }

    /**
     * Track feature usage
     */
    public function trackFeatureUsage(string $featureName, array $additionalProperties = []): UserJourneyEvent
    {
        $properties = array_merge([
            'feature_name' => $featureName,
        ], $additionalProperties);

        return $this->track(UserJourneyEvent::STAGE_ADOPTION, UserJourneyEvent::EVENT_FEATURE_USED, $properties);
    }

    /**
     * Detect persona type based on user characteristics
     */
    protected function detectPersonaType(User $user): string
    {
        // Check user's SaaS plan to determine persona
        if ($user->saasPlans) {
            return match($user->saasPlans->slug) {
                'profissional' => UserJourneyEvent::PERSONA_MARINA,
                'estudio' => UserJourneyEvent::PERSONA_CARLOS,
                default => UserJourneyEvent::PERSONA_MARINA,
            };
        }

        // Default to Marina (Independent Professional)
        return UserJourneyEvent::PERSONA_MARINA;
    }

    /**
     * Determine journey stage based on URL path
     */
    protected function determineStageFromUrl(string $path): string
    {
        return match(true) {
            str_contains($path, 'register') || str_contains($path, 'pricing') => UserJourneyEvent::STAGE_CONSIDERATION,
            str_contains($path, 'login') || str_contains($path, 'onboarding') => UserJourneyEvent::STAGE_TRIAL,
            str_contains($path, 'billing') || str_contains($path, 'subscription') => UserJourneyEvent::STAGE_ADOPTION,
            str_contains($path, 'referral') || str_contains($path, 'testimonial') => UserJourneyEvent::STAGE_ADVOCACY,
            default => UserJourneyEvent::STAGE_AWARENESS,
        };
    }

    /**
     * Static method to create tracker instance
     */
    public static function make(Request $request = null): self
    {
        return new self($request ?? request());
    }
}
