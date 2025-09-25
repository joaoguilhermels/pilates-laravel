<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\FeatureService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeatureServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_resource_count_for_clients(): void
    {
        $user = User::factory()->create();
        
        // This should not throw an exception
        $count = FeatureService::getResourceCount($user, 'clients');
        
        $this->assertIsInt($count);
        $this->assertGreaterThanOrEqual(0, $count);
    }

    public function test_get_resource_count_for_rooms(): void
    {
        $user = User::factory()->create();
        
        // This should not throw an exception
        $count = FeatureService::getResourceCount($user, 'rooms');
        
        $this->assertIsInt($count);
        $this->assertGreaterThanOrEqual(0, $count);
    }

    public function test_get_resource_count_for_plans(): void
    {
        $user = User::factory()->create();
        
        // This should not throw an exception
        $count = FeatureService::getResourceCount($user, 'plans');
        
        $this->assertIsInt($count);
        $this->assertGreaterThanOrEqual(0, $count);
    }
}
