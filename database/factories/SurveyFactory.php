<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\survey>
 */
class SurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = [1, 0];
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->sentence(2),
            'status' => $status[array_rand($status, 1)]
        ];
    }
}
