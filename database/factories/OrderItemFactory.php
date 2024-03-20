<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_title' => fake()->title(),
            'quantity' => fake()->numberBetween(1, 10),
            'price' => fake()->numberBetween(10, 100),
            'order_id' => Order::inRandomOrder()->first()->id
        ];
    }
}
