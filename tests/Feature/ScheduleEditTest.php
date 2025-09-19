<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Models\Schedule;
use App\Models\ClassType;
use App\Models\Professional;
use App\Models\Room;
use App\Models\ClassTypeStatus;
use App\Models\ClientPlanDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScheduleEditTest extends TestCase
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
    public function schedule_edit_page_loads_successfully_without_client_plan()
    {
        // Create necessary related models
        $client = Client::factory()->create();
        $professional = Professional::factory()->create();
        $room = Room::factory()->create();
        $classType = ClassType::factory()->create();
        $classTypeStatus = ClassTypeStatus::factory()->create([
            'class_type_id' => $classType->id
        ]);

        // Create a ClientPlanDetail to use as the scheduable
        $clientPlanDetail = ClientPlanDetail::factory()->create();

        // Create a schedule with a valid scheduable (ClientPlanDetail)
        $schedule = Schedule::factory()->create([
            'client_id' => $client->id,
            'professional_id' => $professional->id,
            'room_id' => $room->id,
            'class_type_id' => $classType->id,
            'class_type_status_id' => $classTypeStatus->id,
            'scheduable_id' => $clientPlanDetail->id,
            'scheduable_type' => ClientPlanDetail::class,
        ]);

        // Test that the edit page loads without error
        $response = $this->get(route('schedules.edit', $schedule));

        $response->assertStatus(200);
        $response->assertViewIs('schedules.edit');
        $response->assertViewHas('schedule');
        $response->assertViewHas('plan', ''); // Should be empty string when no plan
        $response->assertViewHas('rooms');
        $response->assertViewHas('professionals');
        $response->assertViewHas('classTypeStatuses');
    }

    /** @test */
    public function schedule_edit_page_handles_missing_class_type_relationships()
    {
        // Create a minimal schedule with a different scheduable type (not ClientPlanDetail)
        $client = Client::factory()->create();
        $classType = ClassType::factory()->create();
        
        // Use the client as the scheduable (different polymorphic type)
        $schedule = Schedule::factory()->create([
            'client_id' => $client->id,
            'class_type_id' => $classType->id,
            'scheduable_id' => $client->id,
            'scheduable_type' => Client::class, // Different type, not ClientPlanDetail
        ]);

        // Test that the edit page loads even when scheduable is not a ClientPlanDetail
        $response = $this->get(route('schedules.edit', $schedule));

        $response->assertStatus(200);
        $response->assertViewIs('schedules.edit');
        $response->assertViewHas('plan', ''); // Should be empty string when scheduable is not ClientPlanDetail
    }
}
