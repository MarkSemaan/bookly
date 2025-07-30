<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'publisher' => fake()->company(),
            'published_year' => fake()->year(),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 5, 100),
            'stock' => fake()->numberBetween(0, 50),
            'image' => fake()->imageUrl(),
            'sold' => fake()->numberBetween(0, 1000),
            'is_available' => fake()->boolean(),
            'rating' => fake()->numberBetween(1, 5),
        ];
    }
}
