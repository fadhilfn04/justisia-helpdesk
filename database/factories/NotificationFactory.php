<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['info', 'warning', 'success', 'error']),
            'title' => $this->faker->sentence(4),
            'message' => $this->faker->paragraph(),
            'is_read' => $this->faker->boolean(30),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}