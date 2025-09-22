<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnboardingMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Check if user is in onboarding mode
        if ($request->session()->get('onboarding_active', false)) {
            // List of routes that should redirect back to dashboard during onboarding
            $onboardingRoutes = [
                'professionals.store',
                'rooms.store', 
                'classTypes.store',
                'clients.store',
                'schedules.store',
                'plans.store'
            ];

            $currentRoute = $request->route()->getName();

            // If this is a store action during onboarding, redirect to dashboard with success message
            if (in_array($currentRoute, $onboardingRoutes) && $response->isRedirect()) {
                // Get the model name from route
                $modelName = $this->getModelNameFromRoute($currentRoute);
                
                // Set success message
                $request->session()->flash('onboarding_success', "Great! You've successfully added a {$modelName}. Let's continue with the next step.");
                
                // Redirect to dashboard instead of the default redirect
                return redirect()->route('home')->with('onboarding_continue', true);
            }
        }

        return $response;
    }

    /**
     * Extract model name from route name
     */
    private function getModelNameFromRoute(string $routeName): string
    {
        $routeParts = explode('.', $routeName);
        $modelName = $routeParts[0] ?? 'item';
        
        // Convert to singular, user-friendly names
        $friendlyNames = [
            'professionals' => 'instructor',
            'rooms' => 'room',
            'classTypes' => 'class type',
            'clients' => 'client',
            'schedules' => 'class',
            'plans' => 'plan'
        ];

        return $friendlyNames[$modelName] ?? $modelName;
    }
}
