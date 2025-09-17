<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientPlan;
use App\Models\Plan;
use App\Models\ClassType;
use App\Models\ClassTypeStatus;
use App\Models\Professional;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientPlanEditPageTest extends TestCase
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
    public function edit_plan_page_loads_without_undefined_client_error()
    {
        // Arrange - Create all necessary data
        $client = Client::factory()->create(['name' => 'Test Client']);
        $classType = ClassType::factory()->create(['name' => 'Pilates Mat']);
        $plan = Plan::factory()->create([
            'class_type_id' => $classType->id,
            'name' => 'Once a Week'
        ]);
        
        $clientPlan = ClientPlan::factory()->create([
            'client_id' => $client->id,
            'plan_id' => $plan->id,
            'start_at' => '2025-01-01'
        ]);

        // Act - Visit the edit page
        $response = $this->get("/client-plans/{$clientPlan->id}/edit");

        // Assert - Page loads successfully and contains expected data
        $response->assertStatus(200);
        $response->assertSee('Test Client'); // Client name should be visible
        $response->assertSee('Pilates Mat'); // Class type should be visible
        $response->assertSee('Once a Week'); // Plan name should be visible
        $response->assertViewHas('client', $client);
        $response->assertViewHas('clientPlan', $clientPlan);
    }

    /** @test */
    public function edit_plan_form_can_be_submitted_successfully()
    {
        // Arrange
        $client = Client::factory()->create();
        $classType = ClassType::factory()->create();
        $plan = Plan::factory()->create(['class_type_id' => $classType->id]);
        $professional = Professional::factory()->create();
        $room = Room::factory()->create();
        
        // Set up professional-class type relationship
        $professional->classTypes()->attach($classType->id, [
            'value' => 50.00,
            'value_type' => 'value_per_client'
        ]);
        
        // Create class type status
        ClassTypeStatus::factory()->create([
            'class_type_id' => $classType->id,
            'name' => 'OK'
        ]);
        
        $clientPlan = ClientPlan::factory()->create([
            'client_id' => $client->id,
            'plan_id' => $plan->id,
        ]);

        $updateData = [
            'start_at' => '2025-02-01',
            'plan_id' => $plan->id,
            'daysOfWeek' => [
                [
                    'day_of_week' => 2, // Tuesday
                    'hour' => 14,
                    'professional_id' => $professional->id,
                    'room_id' => $room->id,
                ]
            ]
        ];

        // Act - Submit the form
        $response = $this->put("/client-plans/{$clientPlan->id}", $updateData);

        // Assert - Form submission is successful
        $response->assertRedirect();
        $response->assertSessionHas('message');
        
        // Verify the data was updated
        $this->assertDatabaseHas('client_plans', [
            'id' => $clientPlan->id,
            'start_at' => '2025-02-01',
        ]);
    }
}
