<?php

namespace Tests\Unit\Models;

use App\Models\Schedule;
use App\Models\Client;
use App\Models\ClassType;
use App\Models\Professional;
use App\Models\Room;
use App\Models\ClassTypeStatus;
use App\Models\ClientPlanDetail;
use App\Models\FinancialTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_schedule_can_be_created_with_valid_data()
    {
        $scheduleData = [
            'parent_id' => 0,
            'client_id' => Client::factory()->create()->id,
            'class_type_id' => ClassType::factory()->create()->id,
            'professional_id' => Professional::factory()->create()->id,
            'room_id' => Room::factory()->create()->id,
            'class_type_status_id' => ClassTypeStatus::factory()->create()->id,
            'trial' => false,
            'price' => 50.00,
            'start_at' => now(),
            'end_at' => now()->addHour(),
            'observation' => 'Test schedule'
        ];

        $schedule = Schedule::create($scheduleData);

        $this->assertInstanceOf(Schedule::class, $schedule);
        $this->assertEquals($scheduleData['client_id'], $schedule->client_id);
        $this->assertEquals($scheduleData['price'], $schedule->price);
    }

    public function test_schedule_belongs_to_client()
    {
        $schedule = Schedule::factory()->create();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $schedule->client());
        $this->assertInstanceOf(Client::class, $schedule->client);
    }

    public function test_schedule_belongs_to_class_type()
    {
        $schedule = Schedule::factory()->create();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $schedule->classType());
        $this->assertInstanceOf(ClassType::class, $schedule->classType);
    }

    public function test_schedule_belongs_to_professional()
    {
        $schedule = Schedule::factory()->create();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $schedule->professional());
        $this->assertInstanceOf(Professional::class, $schedule->professional);
    }

    public function test_schedule_belongs_to_room()
    {
        $schedule = Schedule::factory()->create();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $schedule->room());
        $this->assertInstanceOf(Room::class, $schedule->room);
    }

    public function test_schedule_belongs_to_class_type_status()
    {
        $schedule = Schedule::factory()->create();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $schedule->classTypeStatus());
        $this->assertInstanceOf(ClassTypeStatus::class, $schedule->classTypeStatus);
    }

    public function test_schedule_has_many_financial_transactions()
    {
        $schedule = Schedule::factory()->create();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphMany::class, $schedule->financialTransactions());
    }

    public function test_schedule_dates_are_cast_to_carbon()
    {
        $schedule = Schedule::factory()->create([
            'start_at' => '2024-01-01 10:00:00',
            'end_at' => '2024-01-01 11:00:00'
        ]);

        $this->assertInstanceOf(\Carbon\Carbon::class, $schedule->start_at);
        $this->assertInstanceOf(\Carbon\Carbon::class, $schedule->end_at);
    }

    public function test_schedule_eager_loads_relationships()
    {
        $schedule = Schedule::factory()->create();
        
        // Test that the relationships are eager loaded
        $loadedSchedule = Schedule::first();
        
        $this->assertTrue($loadedSchedule->relationLoaded('professional'));
        $this->assertTrue($loadedSchedule->relationLoaded('client'));
        $this->assertTrue($loadedSchedule->relationLoaded('room'));
        $this->assertTrue($loadedSchedule->relationLoaded('classType'));
        $this->assertTrue($loadedSchedule->relationLoaded('classTypeStatus'));
    }
}
