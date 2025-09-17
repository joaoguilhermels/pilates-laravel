<?php

namespace Database\Factories;

use App\Models\ClassType;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $planTypes = [
            [
                'name' => 'Once a Week',
                'times' => 1,
                'times_type' => 'week',
                'duration' => 1,
                'duration_type' => 'month',
                'price' => 140.00,
                'price_type' => 'month',
            ],
            [
                'name' => 'Twice a Week',
                'times' => 2,
                'times_type' => 'week',
                'duration' => 1,
                'duration_type' => 'month',
                'price' => 260.00,
                'price_type' => 'month',
            ],
            [
                'name' => '8 Classes Package',
                'times' => 8,
                'times_type' => 'class',
                'duration' => 2,
                'duration_type' => 'month',
                'price' => 280.00,
                'price_type' => 'package',
            ],
        ];

        $selectedPlan = $this->faker->randomElement($planTypes);

        return array_merge($selectedPlan, [
            'class_type_id' => ClassType::factory(),
        ]);
    }

    /**
     * Create a monthly plan.
     */
    public function monthly(): static
    {
        return $this->state(fn (array $attributes) => [
            'duration' => 1,
            'duration_type' => 'month',
            'price_type' => 'month',
        ]);
    }

    /**
     * Create a package plan.
     */
    public function package(): static
    {
        return $this->state(fn (array $attributes) => [
            'times_type' => 'class',
            'duration_type' => 'month',
            'price_type' => 'package',
        ]);
    }

    /**
     * Create a plan for a specific class type.
     */
    public function forClassType(ClassType $classType): static
    {
        return $this->state(fn (array $attributes) => [
            'class_type_id' => $classType->id,
        ]);
    }
}
