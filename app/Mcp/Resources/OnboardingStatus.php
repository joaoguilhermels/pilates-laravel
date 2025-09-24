<?php

namespace App\Mcp\Resources;

use Laravel\Mcp\Server\Resource;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

class OnboardingStatus extends Resource
{
    protected string $description = 'Provides current onboarding status for the authenticated user, including completion progress, next steps, and wizard state.';

    /**
     * Return the resource contents.
     */
    public function read(): string
    {
        if (!Auth::check()) {
            return json_encode([
                'error' => 'User not authenticated',
                'needsOnboarding' => true,
                'isNewUser' => true,
                'message' => 'Please authenticate to check onboarding status'
            ]);
        }

        $homeController = new HomeController();
        $onboardingStatus = $homeController->checkOnboardingStatus();

        return json_encode([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'onboarding_status' => $onboardingStatus,
            'timestamp' => now()->toISOString(),
            'recommendations' => $this->getRecommendations($onboardingStatus)
        ]);
    }

    private function getRecommendations(array $status): array
    {
        $recommendations = [];

        if ($status['needsOnboarding']) {
            if ($status['isNewUser']) {
                $recommendations[] = 'Complete the welcome wizard to get started quickly';
                $recommendations[] = 'Add your first professional to begin scheduling classes';
            }

            if (count($status['nextSteps']) > 0) {
                $recommendations[] = 'Focus on: ' . $status['nextSteps'][0]['title'];
                $recommendations[] = 'Completing setup will unlock all platform features';
            }
        } else {
            $recommendations[] = 'Onboarding complete! Your studio is ready for daily operations';
            $recommendations[] = 'Consider exploring advanced features like reporting and analytics';
        }

        return $recommendations;
    }
}
