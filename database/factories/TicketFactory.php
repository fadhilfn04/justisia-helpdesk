<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        $status = ['open', 'in_progress', 'resolved', 'closed'];
        $priority = ['rendah', 'sedang', 'tinggi'];

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'category_id' => TicketCategory::inRandomOrder()->first()?->id ?? TicketCategory::factory(),
            'assigned_to' => User::inRandomOrder()->first()?->id ?? null,
            'title' => $this->faker->sentence(rand(3, 6)), // contoh: "Masalah login akun pengguna"
            'description' => $this->faker->paragraph(3, true),
            'status' => $this->faker->randomElement($status),
            'priority' => $this->faker->randomElement($priority),
            'created_at' => now(),
        ];
    }
}