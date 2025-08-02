<?php

namespace Database\Factories;

use App\Models\CartItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       static $usedPairs = [];

        do {
            $userId = fake()->numberBetween(1, 10);
            $bookId = fake()->numberBetween(1, 20);
            $key = "$userId-$bookId";
        } while (in_array($key, $usedPairs));

        $usedPairs[] = $key;

        return [
            'user_id' => $userId,
            'book_id' => $bookId,
            'quantity' => fake()->numberBetween(1, 5),
        ];
    }
}
