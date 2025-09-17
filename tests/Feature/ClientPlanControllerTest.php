<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientPlan;
use App\Models\Plan;
use App\Models\ClassType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientPlanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /** @test */
    public function it_can_show_edit_form_for_client_plan()
    {
        // Arrange
        $client = Client::factory()->create();
        $classType = ClassType::factory()->create();
        $plan = Plan::factory()->create(['class_type_id' => $classType->id]);
        $clientPlan = ClientPlan::factory()->create([
            'client_id' => $client->id,
            'plan_id' => $plan->id,
        ]);

        // Act
        $response = $this->get(route('client-plans.edit', $clientPlan));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('clientPlans.edit');
        $response->assertViewHas('client', $client);
        $response->assertViewHas('clientPlan', $clientPlan);
        $response->assertViewHas('rooms');
        $response->assertViewHas('classTypePlans');
        $response->assertViewHas('professionals');
        $response->assertViewHas('discounts');
    }

    /** @test */
    public function it_can_update_client_plan()
    {
        // Arrange
        $client = Client::factory()->create();
        $classType = ClassType::factory()->create();
        $plan = Plan::factory()->create(['class_type_id' => $classType->id]);
        $professional = \App\Models\Professional::factory()->create();
        $room = \App\Models\Room::factory()->create();
        
        // Set up professional-class type relationship
        $professional->classTypes()->attach($classType->id, [
            'value' => 50.00,
            'value_type' => 'value_per_client'
        ]);
        
        // Create a class type status
        \App\Models\ClassTypeStatus::factory()->create([
            'class_type_id' => $classType->id,
            'name' => 'OK'
        ]);
        
        $clientPlan = ClientPlan::factory()->create([
            'client_id' => $client->id,
            'plan_id' => $plan->id,
        ]);

        $updateData = [
            'start_at' => '2025-01-01',
            'plan_id' => $plan->id,
            'daysOfWeek' => [
                [
                    'day_of_week' => 1, // Monday
                    'hour' => 10,
                    'professional_id' => $professional->id,
                    'room_id' => $room->id,
                ]
            ]
        ];

        // Act
        $response = $this->put(route('client-plans.update', $clientPlan), $updateData);

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('client_plans', [
            'id' => $clientPlan->id,
            'start_at' => '2025-01-01',
        ]);
    }
}
