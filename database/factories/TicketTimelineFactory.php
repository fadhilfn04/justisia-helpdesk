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
                'draft',
                'in_progress',
                'open',
                'assignee',
                'need_revision',
                'agent_rejected',
                'closed',
            ]),
            'description' => $this->faker->optional()->sentence(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}