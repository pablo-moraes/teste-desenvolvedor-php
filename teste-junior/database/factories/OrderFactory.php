<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customerId = Customer::query()->select('uuid')->inRandomOrder()->first() ?? Customer::factory()->create()->uuid;
        $productId = Product::query()->select('uuid')->inRandomOrder()->first() ?? Product::factory()->create()->uuid;
        return [
            'customer_id' => $customerId,
            'product_id' => $productId,
            'quantity' => $this->faker->numberBetween(1, 999)
        ];
    }
}
