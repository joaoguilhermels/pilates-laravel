<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class FeatureService
{
    /**
     * Check if user can access a specific feature
     */
    public static function canAccess(User $user, string $feature): bool
    {
        $plan = $user->saasPlans;
        
        if (!$plan) {
            return false;
        }

        $features = config("features.{$plan->slug}");
        
        return $features[$feature] ?? false;
    }

    /**
     * Get limit for a specific resource
     */
    public static function getLimit(User $user, string $limit): ?int
    {
        $plan = $user->saasPlans;
        
        if (!$plan) {
            return 0;
        }

        $features = config("features.{$plan->slug}");
        
        return $features[$limit] ?? null;
    }

    /**
     * Check if user has reached a specific limit
     */
    public static function hasReachedLimit(User $user, string $resource): bool
    {
        $limit = self::getLimit($user, "max_{$resource}");
        
        // If limit is null, it means unlimited
        if ($limit === null) {
            return false;
        }

        $count = self::getResourceCount($user, $resource);
        
        return $count >= $limit;
    }

    /**
     * Get current count for a resource
     */
    public static function getResourceCount(User $user, string $resource): int
    {
        // Cache the count for 5 minutes to improve performance
        $cacheKey = "user_{$user->id}_count_{$resource}";
        
        return Cache::remember($cacheKey, 300, function () use ($user, $resource) {
            switch ($resource) {
                case 'clients':
                    // For now, use global count - in a multi-tenant app, this would be filtered by user/organization
                    return \App\Models\Client::count();
                case 'users':
                    // For studio owners, count all users in their organization
                    if (method_exists($user, 'hasRole') && $user->hasRole('studio_owner')) {
                        return User::where('studio_name', $user->studio_name)->count();
                    }
                    return 1; // Professional only counts themselves
                case 'locations':
                    // No locations model exists yet, return 0
                    return 0;
                case 'rooms':
                    // Use global count - in a multi-tenant app, this would be filtered by user/organization
                    return \App\Models\Room::count();
                case 'plans':
                    // Use global count - in a multi-tenant app, this would be filtered by user/organization
                    return \App\Models\Plan::count();
                case 'schedules_today':
                    // Use global count for today's schedules
                    return \App\Models\Schedule::whereDate('created_at', today())->count();
                default:
                    return 0;
            }
        });
    }

    /**
     * Get remaining count for a resource
     */
    public static function getRemainingCount(User $user, string $resource): ?int
    {
        $limit = self::getLimit($user, "max_{$resource}");
        
        if ($limit === null) {
            return null; // Unlimited
        }

        $current = self::getResourceCount($user, $resource);
        
        return max(0, $limit - $current);
    }

    /**
     * Get usage percentage for a resource
     */
    public static function getUsagePercentage(User $user, string $resource): ?float
    {
        $limit = self::getLimit($user, "max_{$resource}");
        
        if ($limit === null) {
            return null; // Unlimited
        }

        $current = self::getResourceCount($user, $resource);
        
        return $limit > 0 ? min(100, ($current / $limit) * 100) : 0;
    }

    /**
     * Check if user can create more of a resource
     */
    public static function canCreate(User $user, string $resource): bool
    {
        return !self::hasReachedLimit($user, $resource);
    }

    /**
     * Get upgrade message for a feature
     */
    public static function getUpgradeMessage(User $user, string $feature): string
    {
        $plan = $user->saasPlans;
        
        if (!$plan) {
            return 'Você precisa de um plano para acessar esta funcionalidade.';
        }

        $messages = config("features.upgrade_messages.{$plan->slug}");
        
        return $messages[$feature] ?? $messages['default'] ?? 'Esta funcionalidade requer um upgrade de plano.';
    }

    /**
     * Get all features for a user's plan
     */
    public static function getUserFeatures(User $user): array
    {
        $plan = $user->saasPlans;
        
        if (!$plan) {
            return [];
        }

        return config("features.{$plan->slug}") ?? [];
    }

    /**
     * Get features by category for a user
     */
    public static function getFeaturesByCategory(User $user): array
    {
        $userFeatures = self::getUserFeatures($user);
        $categories = config('features.categories');
        $result = [];

        foreach ($categories as $categoryKey => $category) {
            $result[$categoryKey] = [
                'name' => $category['name'],
                'features' => []
            ];

            foreach ($category['features'] as $feature) {
                $result[$categoryKey]['features'][$feature] = $userFeatures[$feature] ?? false;
            }
        }

        return $result;
    }

    /**
     * Clear cache for user's resource counts
     */
    public static function clearUserCache(User $user): void
    {
        $resources = ['clients', 'users', 'locations', 'rooms', 'plans', 'schedules_today'];
        
        foreach ($resources as $resource) {
            $cacheKey = "user_{$user->id}_count_{$resource}";
            Cache::forget($cacheKey);
        }
    }

    /**
     * Check if user is on trial
     */
    public static function isOnTrial(User $user): bool
    {
        return $user->isOnTrial();
    }

    /**
     * Check if user has active subscription
     */
    public static function hasActiveSubscription(User $user): bool
    {
        return $user->hasActiveSubscription();
    }

    /**
     * Get plan comparison data
     */
    public static function getPlanComparison(): array
    {
        $plans = ['profissional', 'estudio'];
        $comparison = [];

        foreach ($plans as $plan) {
            $features = config("features.{$plan}");
            $comparison[$plan] = $features;
        }

        return $comparison;
    }
}
