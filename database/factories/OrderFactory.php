<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    
    protected $model = Order::class;

    public function definition(): array{
        $quantity = $this->faker->numberBetween(1, 10);
        $price = $this->faker->randomFloat(2, 10, 150);
        return [
            'user_id' => User::factory(),
            'product' => $this->faker->randomElement(['Laptop', 'Smartphone', 'Tablet', 'Headphones', 'Smartwatch']),
            'quantity' => $quantity,
            'total' => $quantity * $price,
        ];
    }
}
