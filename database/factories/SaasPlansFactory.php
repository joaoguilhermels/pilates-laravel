<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SaasPlans>
 */
class SaasPlansFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(),
            'monthly_price' => $this->faker->randomFloat(2, 50, 500),
            'yearly_price' => $this->faker->randomFloat(2, 500, 5000),
            'max_clients' => $this->faker->numberBetween(10, 1000),
            'max_professionals' => $this->faker->numberBetween(1, 50),
            'max_rooms' => $this->faker->numberBetween(1, 20),
            'features' => ['Feature 1', 'Feature 2', 'Feature 3'],
            'is_popular' => false,
            'is_active' => true,
            'trial_days' => 14,
        ];
    }

    /**
     * Indicate that the plan is popular.
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_popular' => true,
        ]);
    }

    /**
     * Indicate that the plan is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
