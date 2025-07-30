<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => fake()->numberBetween(1, 10),
            'payment_method_id' => fake()->numberBetween(1, 3),
            'amount' => fake()->randomFloat(2, 10, 300),
            'status' => fake()->randomElement(['paid', 'failed']),
        ];
    }
}
