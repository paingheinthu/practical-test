<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = [1, 0];
        $type = ['text', 'datetime', 'combo'];
        return [
            'title' => $this->faker->jobTitle(),
            'type' => $type[array_rand($type, 1)],
            'is_required' => $status[array_rand($status, 1)]
        ];
    }
}
