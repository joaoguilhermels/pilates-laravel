<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Client;
use App\Models\ClassType;
use App\Models\Professional;
use App\Models\Room;
use App\Models\ClassTypeStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startAt = $this->faker->dateTimeBetween('now', '+1 month');
        $endAt = (clone $startAt)->modify('+1 hour');

        return [
            'parent_id' => 0,
            'client_id' => Client::factory(),
            'class_type_id' => ClassType::factory(),
            'professional_id' => Professional::factory(),
            'room_id' => Room::factory(),
            'class_type_status_id' => ClassTypeStatus::factory(),
            'trial' => $this->faker->boolean(20), // 20% chance of being a trial
            'price' => $this->faker->randomFloat(2, 30, 150),
            'start_at' => $startAt,
            'end_at' => $endAt,
            'observation' => $this->faker->optional()->paragraph(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
