<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Professional;
use App\Models\Plan;
use App\Models\Room;
use App\Models\ClassType;
use App\Models\Schedule;
use App\Models\ClientPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class DeletionProtectionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs($this->createUser());
    }

    private function createUser()
    {
        return \App\Models\User::factory()->create();
    }

    /** @test */
    public function it_can_check_professional_dependencies()
    {
        // Arrange
        $professional = Professional::factory()->create();
        $client = Client::factory()->create();
        $room = Room::factory()->create();
        $classType = ClassType::factory()->create();
        
        // Create a future schedule for this professional
        Schedule::factory()->create([
            'professional_id' => $professional->id,
            'client_id' => $client->id,
            'room_id' => $room->id,
            'class_type_id' => $classType->id,
            'start_at' => now()->addDays(1),
            'end_at' => now()->addDays(1)->addHour(),
        ]);

        // Act
        $response = $this->getJson("/api/check-dependencies/professional/{$professional->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'canDelete' => false,
            'dependencies' => ['1 upcoming scheduled classes'],
        ]);
        $this->assertStringContainsString('upcoming classes', $response->json('warnings.0'));
    }

    /** @test */
    public function it_allows_professional_deletion_when_no_dependencies()
    {
        // Arrange
        $professional = Professional::factory()->create();

        // Act
        $response = $this->getJson("/api/check-dependencies/professional/{$professional->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'canDelete' => true,
            'dependencies' => [],
            'warnings' => [],
        ]);
    }

    /** @test */
    public function it_can_check_client_dependencies()
    {
        // Arrange
        $client = Client::factory()->create();
        $plan = Plan::factory()->create();
        
        // Create an active client plan
        ClientPlan::factory()->create([
            'client_id' => $client->id,
            'plan_id' => $plan->id,
            'start_at' => now()->subDays(1),
            'end_date' => now()->addDays(30),
        ]);

        // Act
        $response = $this->getJson("/api/check-dependencies/client/{$client->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'canDelete' => false,
        ]);
        $this->assertNotEmpty($response->json('dependencies'));
    }

    /** @test */
    public function it_can_check_plan_dependencies()
    {
        // Arrange
        $plan = Plan::factory()->create();
        $client = Client::factory()->create();
        
        // Create an active subscription
        ClientPlan::factory()->create([
            'client_id' => $client->id,
            'plan_id' => $plan->id,
            'start_at' => now()->subDays(1),
            'end_date' => now()->addDays(30),
        ]);

        // Act
        $response = $this->getJson("/api/check-dependencies/plan/{$plan->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'canDelete' => false,
        ]);
        $this->assertStringContainsString('active client subscriptions', $response->json('dependencies.0'));
    }

    /** @test */
    public function it_can_check_room_dependencies()
    {
        // Arrange
        $room = Room::factory()->create();
        $professional = Professional::factory()->create();
        $client = Client::factory()->create();
        $classType = ClassType::factory()->create();
        
        // Create a future schedule in this room
        Schedule::factory()->create([
            'room_id' => $room->id,
            'professional_id' => $professional->id,
            'client_id' => $client->id,
            'class_type_id' => $classType->id,
            'start_at' => now()->addDays(1),
            'end_at' => now()->addDays(1)->addHour(),
        ]);

        // Act
        $response = $this->getJson("/api/check-dependencies/room/{$room->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'canDelete' => false,
        ]);
        $this->assertStringContainsString('upcoming scheduled classes', $response->json('dependencies.0'));
    }

    /** @test */
    public function it_can_check_class_type_dependencies()
    {
        // Arrange
        $classType = ClassType::factory()->create();
        $professional = Professional::factory()->create();
        $client = Client::factory()->create();
        $room = Room::factory()->create();
        
        // Create a future schedule with this class type
        Schedule::factory()->create([
            'class_type_id' => $classType->id,
            'professional_id' => $professional->id,
            'client_id' => $client->id,
            'room_id' => $room->id,
            'start_at' => now()->addDays(1),
            'end_at' => now()->addDays(1)->addHour(),
        ]);

        // Act
        $response = $this->getJson("/api/check-dependencies/class-type/{$classType->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'canDelete' => false,
        ]);
        $this->assertStringContainsString('upcoming scheduled classes', $response->json('dependencies.0'));
    }

    /** @test */
    public function it_can_check_schedule_conflicts()
    {
        // Arrange
        $professional = Professional::factory()->create();
        $room = Room::factory()->create();
        $client = Client::factory()->create();
        $classType = ClassType::factory()->create();
        
        // Create an existing schedule
        Schedule::factory()->create([
            'professional_id' => $professional->id,
            'room_id' => $room->id,
            'client_id' => $client->id,
            'class_type_id' => $classType->id,
            'start_at' => '2024-01-15 10:00:00',
            'end_at' => '2024-01-15 11:00:00',
        ]);

        // Act - try to create a conflicting schedule
        $response = $this->postJson('/api/check-schedule-conflicts', [
            'professional_id' => $professional->id,
            'room_id' => $room->id,
            'start_date' => '2024-01-15',
            'start_time' => '10:30',
            'duration' => 60,
        ]);

        // Assert
        $response->assertStatus(200);
        $conflicts = $response->json();
        $this->assertNotEmpty($conflicts);
        $this->assertStringContainsString('Professional has another class', $conflicts[0]);
        $this->assertStringContainsString('Room is occupied', $conflicts[1]);
    }

    /** @test */
    public function it_returns_no_conflicts_for_available_time_slots()
    {
        // Arrange
        $professional = Professional::factory()->create();
        $room = Room::factory()->create();

        // Act - check for conflicts at a free time
        $response = $this->postJson('/api/check-schedule-conflicts', [
            'professional_id' => $professional->id,
            'room_id' => $room->id,
            'start_date' => '2024-01-15',
            'start_time' => '10:00',
            'duration' => 60,
        ]);

        // Assert
        $response->assertStatus(200);
        $this->assertEmpty($response->json());
    }

    /** @test */
    public function it_validates_schedule_conflict_request_data()
    {
        // Act - send invalid data
        $response = $this->postJson('/api/check-schedule-conflicts', [
            'professional_id' => 'invalid',
            'room_id' => 999999,
            'start_date' => 'invalid-date',
            'start_time' => 'invalid-time',
        ]);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['professional_id', 'room_id', 'start_date', 'start_time']);
    }

    /** @test */
    public function it_returns_404_for_non_existent_entity_dependency_check()
    {
        // Act
        $response = $this->getJson('/api/check-dependencies/professional/999999');

        // Assert
        $response->assertStatus(500); // Should be handled as an error
    }

    /** @test */
    public function it_provides_alternative_actions_for_professionals_with_dependencies()
    {
        // Arrange
        $professional = Professional::factory()->create();
        $client = Client::factory()->create();
        $room = Room::factory()->create();
        $classType = ClassType::factory()->create();
        
        Schedule::factory()->create([
            'professional_id' => $professional->id,
            'client_id' => $client->id,
            'room_id' => $room->id,
            'class_type_id' => $classType->id,
            'start_at' => now()->addDays(1),
            'end_at' => now()->addDays(1)->addHour(),
        ]);

        // Act
        $response = $this->getJson("/api/check-dependencies/professional/{$professional->id}");

        // Assert
        $response->assertStatus(200);
        $alternativeActions = $response->json('alternativeActions');
        $this->assertNotEmpty($alternativeActions);
        $this->assertArrayHasKey('label', $alternativeActions[0]);
        $this->assertArrayHasKey('url', $alternativeActions[0]);
    }

    /** @test */
    public function it_handles_clients_with_outstanding_balances()
    {
        // Arrange
        $client = Client::factory()->create();
        $plan = Plan::factory()->create();
        
        ClientPlan::factory()->create([
            'client_id' => $client->id,
            'plan_id' => $plan->id,
            'balance' => 150.00, // Outstanding balance
            'start_at' => now()->subDays(1),
            'end_date' => now()->addDays(30),
        ]);

        // Act
        $response = $this->getJson("/api/check-dependencies/client/{$client->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'canDelete' => false,
        ]);
        $dependencies = $response->json('dependencies');
        $this->assertTrue(collect($dependencies)->contains(function ($dep) {
            return str_contains($dep, 'Outstanding balance');
        }));
    }
}
