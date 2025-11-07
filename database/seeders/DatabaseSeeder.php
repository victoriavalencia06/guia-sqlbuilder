<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use Database\Factories\OrderFactory;
use Database\Factories\UserFactory;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {        

        // al menos 5 usuarios 
        $users = User::factory()->count(5)->create();

        // al menos 5 pedidos distribuidos entre los usuarios
        foreach ($users as $user) {
            // 2 por usuario => tendras 10 pedidos en total
            Order::factory()->count(2)->create([
                'user_id' => $user->id,
            ]);

            // aseguramos uno con user_id = 2 y otro con user_id = 5 por lo menos para los ejercicios

            Order::factory()->create([
                'user_id' => 2,
                'product' => "Power Bank",
                'quantity' => 3,
                'total' => 75.00,
            ]);

            Order::factory()->create([
                'user_id' => 5,
                'product' => "Smartphone",
                'quantity' => 1,
                'total' => 299.99,
            ]);

        }
    }
}
