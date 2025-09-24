<?php

namespace App\Traits;

use App\Services\FeatureService;

trait HasPlanFeatures
{
    /**
     * Check if user can access a specific feature
     */
    public function canAccess(string $feature): bool
    {
        return FeatureService::canAccess($this, $feature);
    }

    /**
     * Get limit for a specific resource
     */
    public function getLimit(string $limit): ?int
    {
        return FeatureService::getLimit($this, $limit);
    }

    /**
     * Check if user has reached a specific limit
     */
    public function hasReachedLimit(string $resource): bool
    {
        return FeatureService::hasReachedLimit($this, $resource);
    }

    /**
     * Get current count for a resource
     */
    public function getResourceCount(string $resource): int
    {
        return FeatureService::getResourceCount($this, $resource);
    }

    /**
     * Get remaining count for a resource
     */
    public function getRemainingCount(string $resource): ?int
    {
        return FeatureService::getRemainingCount($this, $resource);
    }

    /**
     * Get usage percentage for a resource
     */
    public function getUsagePercentage(string $resource): ?float
    {
        return FeatureService::getUsagePercentage($this, $resource);
    }

    /**
     * Check if user can create more of a resource
     */
    public function canCreate(string $resource): bool
    {
        return FeatureService::canCreate($this, $resource);
    }

    /**
     * Get upgrade message for a feature
     */
    public function getUpgradeMessage(string $feature): string
    {
        return FeatureService::getUpgradeMessage($this, $feature);
    }

    /**
     * Get all features for user's plan
     */
    public function getFeatures(): array
    {
        return FeatureService::getUserFeatures($this);
    }

    /**
     * Get features by category
     */
    public function getFeaturesByCategory(): array
    {
        return FeatureService::getFeaturesByCategory($this);
    }

    /**
     * Clear cache for user's resource counts
     */
    public function clearFeatureCache(): void
    {
        FeatureService::clearUserCache($this);
    }

    /**
     * Check if user has a specific plan
     */
    public function hasPlan(string $planSlug): bool
    {
        return $this->saasPlans && $this->saasPlans->slug === $planSlug;
    }

    /**
     * Check if user is professional
     */
    public function isProfessional(): bool
    {
        return $this->hasPlan('profissional');
    }

    /**
     * Check if user is studio owner
     */
    public function isStudioOwner(): bool
    {
        return $this->hasPlan('estudio');
    }

    /**
     * Get plan display name
     */
    public function getPlanName(): string
    {
        return $this->saasPlans?->name ?? 'Sem Plano';
    }

    /**
     * Get plan features count
     */
    public function getPlanFeaturesCount(): int
    {
        $features = $this->getFeatures();
        return collect($features)->filter(function ($value) {
            return $value === true;
        })->count();
    }

    /**
     * Check if feature is available in user's plan
     */
    public function hasFeature(string $feature): bool
    {
        return $this->canAccess($feature);
    }

    /**
     * Get resource usage summary
     */
    public function getResourceUsageSummary(): array
    {
        $resources = ['clients', 'users', 'rooms', 'plans'];
        $summary = [];

        foreach ($resources as $resource) {
            $limit = $this->getLimit("max_{$resource}");
            $current = $this->getResourceCount($resource);
            $percentage = $this->getUsagePercentage($resource);

            $summary[$resource] = [
                'current' => $current,
                'limit' => $limit,
                'remaining' => $limit ? max(0, $limit - $current) : null,
                'percentage' => $percentage,
                'unlimited' => $limit === null,
                'at_limit' => $limit && $current >= $limit,
                'near_limit' => $limit && $percentage && $percentage >= 80,
            ];
        }

        return $summary;
    }

    /**
     * Check if user needs to upgrade
     */
    public function needsUpgrade(): bool
    {
        if (!$this->hasActiveSubscription() && !$this->isOnTrial()) {
            return true;
        }

        // Check if any resource is at limit
        $usage = $this->getResourceUsageSummary();
        foreach ($usage as $resource) {
            if ($resource['at_limit']) {
                return true;
            }
        }

        return false;
    }
}
