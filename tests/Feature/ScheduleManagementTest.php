<?php

namespace Tests\Feature;

use App\Models\Schedule;
use App\Models\Client;
use App\Models\ClassType;
use App\Models\Professional;
use App\Models\Room;
use App\Models\ClassTypeStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
    }

    public function test_can_view_schedules_index()
    {
        $this->actingAs($this->user);
        $schedules = Schedule::factory()->count(3)->create();

        $response = $this->get('/schedules');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_can_create_new_schedule()
    {
        $this->actingAs($this->user);
        $client = Client::factory()->create();
        $classType = ClassType::factory()->create();
        $professional = Professional::factory()->create();
        $room = Room::factory()->create();
        $status = ClassTypeStatus::factory()->create();

        $scheduleData = [
            'client_id' => $client->id,
            'class_type_id' => $classType->id,
            'professional_id' => $professional->id,
            'room_id' => $room->id,
            'class_type_status_id' => $status->id,
            'price' => 75.00,
            'start_at' => now()->addDay()->format('Y-m-d H:i:s'),
            'end_at' => now()->addDay()->addHour()->format('Y-m-d H:i:s'),
            'trial' => false
        ];

        $response = $this->post('/schedules', $scheduleData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('schedules', [
            'client_id' => $client->id,
            'price' => 75.00
        ]);
    }

    public function test_can_view_single_schedule()
    {
        $this->actingAs($this->user);
        $schedule = Schedule::factory()->create();

        $response = $this->get("/schedules/{$schedule->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $schedule->id]);
    }

    public function test_can_update_schedule()
    {
        $this->actingAs($this->user);
        $schedule = Schedule::factory()->create(['price' => 50.00]);
        $updatedData = [
            'client_id' => $schedule->client_id,
            'class_type_id' => $schedule->class_type_id,
            'professional_id' => $schedule->professional_id,
            'room_id' => $schedule->room_id,
            'class_type_status_id' => $schedule->class_type_status_id,
            'price' => 100.00,
            'start_at' => $schedule->start_at->format('Y-m-d H:i:s'),
            'end_at' => $schedule->end_at->format('Y-m-d H:i:s'),
            'trial' => $schedule->trial
        ];

        $response = $this->put("/schedules/{$schedule->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('schedules', [
            'id' => $schedule->id,
            'price' => 100.00
        ]);
    }

    public function test_can_delete_schedule()
    {
        $this->actingAs($this->user);
        $schedule = Schedule::factory()->create();

        $response = $this->delete("/schedules/{$schedule->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
    }

    public function test_schedule_validation_requires_client()
    {
        $this->actingAs($this->user);
        $scheduleData = [
            'class_type_id' => ClassType::factory()->create()->id,
            'professional_id' => Professional::factory()->create()->id,
            'price' => 75.00,
            'start_at' => now()->addDay()->format('Y-m-d H:i:s'),
            'end_at' => now()->addDay()->addHour()->format('Y-m-d H:i:s')
        ];

        $response = $this->post('/schedules', $scheduleData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('client_id');
    }

    public function test_schedule_validation_requires_valid_dates()
    {
        $this->actingAs($this->user);
        $scheduleData = [
            'client_id' => Client::factory()->create()->id,
            'class_type_id' => ClassType::factory()->create()->id,
            'professional_id' => Professional::factory()->create()->id,
            'price' => 75.00,
            'start_at' => 'invalid-date',
            'end_at' => 'invalid-date'
        ];

        $response = $this->post('/schedules', $scheduleData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['start_at', 'end_at']);
    }
}
