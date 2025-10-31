<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketTimelineFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'actor_id' => User::factory(),
            'action' => $this->faker->randomElement([
                'Ticket Created',
                'Status Updated',
                'Assigned to Staff',
                'Reopened',
                'Closed'
            ]),
            'description' => $this->faker->optional()->sentence(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}