<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'paddle_id' => rand(1000, 9000),
            'price' => rand(5, 100),
            'interval' => $this->faker->randomElement(['month', 'year']),
            'trial_period_days' => 0,
            'sort_order' => 0,
        ];
    }
}
