<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanFeature>
 */
class PlanFeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'plan_id' => Plan::factory()->create()->id,
            'name' => $this->faker->words(3),
            'code' => $this->faker->word,
            'value' => $this->faker->randomElement(['10','20','30','50','Y','N','UNLIMITED']),
        ];
    }
}
