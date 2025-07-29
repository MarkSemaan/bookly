<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       $this->call([
            UserSeeder::class,
            BookSeeder::class,
            CategorySeeder::class,
            ReviewSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            CartItemSeeder::class,
            PaymentMethodSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
