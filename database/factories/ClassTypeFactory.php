<?php

namespace Database\Factories;

use App\Models\ClassType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassType>
 */
class ClassTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClassType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Pilates Mat', 'Pilates Reformer', 'Pilates Cadillac', 'Pilates Chair']),
            'trial' => $this->faker->boolean(30),
            'trial_class_price' => $this->faker->randomFloat(2, 20, 60),
            'max_number_of_clients' => $this->faker->numberBetween(1, 12),
            'duration' => $this->faker->numberBetween(45, 90),
            'extra_class' => $this->faker->boolean(20),
            'extra_class_price' => $this->faker->randomFloat(2, 30, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
