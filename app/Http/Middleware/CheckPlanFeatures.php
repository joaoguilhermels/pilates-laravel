<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\FeatureService;

class CheckPlanFeatures
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $feature = null, string $resource = null): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user has active subscription or is on trial
        if (!FeatureService::hasActiveSubscription($user) && !FeatureService::isOnTrial($user)) {
            return redirect()->route('upgrade')
                ->with('error', 'Sua assinatura expirou. Faça upgrade para continuar usando o PilatesFlow.');
        }

        // Check specific feature access
        if ($feature && !FeatureService::canAccess($user, $feature)) {
            $message = FeatureService::getUpgradeMessage($user, $feature);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => $message,
                    'feature' => $feature,
                    'upgrade_required' => true
                ], 403);
            }

            return redirect()->route('upgrade')
                ->with('error', $message)
                ->with('feature', $feature);
        }

        // Check resource limits
        if ($resource && FeatureService::hasReachedLimit($user, $resource)) {
            $limit = FeatureService::getLimit($user, "max_{$resource}");
            $message = "Você atingiu o limite de {$limit} {$resource} do seu plano. Faça upgrade para adicionar mais.";
            
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => $message,
                    'resource' => $resource,
                    'limit' => $limit,
                    'upgrade_required' => true
                ], 403);
            }

            return redirect()->back()
                ->with('error', $message)
                ->with('resource', $resource);
        }

        return $next($request);
    }
}
