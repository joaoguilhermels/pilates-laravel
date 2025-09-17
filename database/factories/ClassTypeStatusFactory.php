<?php

namespace Database\Factories;

use App\Models\ClassType;
use App\Models\ClassTypeStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassTypeStatus>
 */
class ClassTypeStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClassTypeStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_type_id' => ClassType::factory(),
            'name' => $this->faker->randomElement(['Agendado', 'Realizado', 'Desmarcou', 'Faltou']),
            'charge_client' => $this->faker->boolean(70),
            'pay_professional' => $this->faker->boolean(80),
            'color' => $this->faker->hexColor(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
