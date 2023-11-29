<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Seeders only run if in local development
        if (config('app.env') == 'local') {
            Product::factory(1000)->create();
            Customer::factory(1000)->create();
            Order::factory(1000)->create();
        }
    }
}
