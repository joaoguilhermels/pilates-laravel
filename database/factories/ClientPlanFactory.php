<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientPlan;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientPlan>
 */
class ClientPlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'plan_id' => Plan::inRandomOrder()->first()?->id ?? 1,
            'start_at' => $this->faker->dateTimeBetween('-6 months', '+1 month')->format('Y-m-d'),
        ];
    }

    /**
     * Create a client plan that started recently (within 3 months).
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_at' => $this->faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
        ]);
    }

    /**
     * Create a client plan that started a while ago.
     */
    public function old(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_at' => $this->faker->dateTimeBetween('-12 months', '-3 months')->format('Y-m-d'),
        ]);
    }

    /**
     * Create a client plan for a specific client.
     */
    public function forClient(Client $client): static
    {
        return $this->state(fn (array $attributes) => [
            'client_id' => $client->id,
        ]);
    }

    /**
     * Create a client plan for a specific plan.
     */
    public function forPlan(Plan $plan): static
    {
        return $this->state(fn (array $attributes) => [
            'plan_id' => $plan->id,
        ]);
    }
}
