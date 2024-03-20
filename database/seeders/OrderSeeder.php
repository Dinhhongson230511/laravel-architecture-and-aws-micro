<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Order;
use \App\Models\OrderItem;


class OrderSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Order::factory(30)->create()
        ->each(function(Order $order) {
            OrderItem::factory(random_int(1, 5))->create([
                'order_id' => $order->id
            ]);
        });
    }
}
