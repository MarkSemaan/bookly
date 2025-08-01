<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 10),
            'book_id' => fake()->numberBetween(1, 20),
            'comment' => fake()->paragraph(),
            'rating' => fake()->numberBetween(1, 5),
        ];
    }
}
