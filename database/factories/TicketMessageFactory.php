<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ticket;
use App\Models\User;

class TicketMessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::inRandomOrder()->first()->id ?? 1,
            'sender_id' => User::inRandomOrder()->first()->id ?? 1,
            'message' => $this->faker->sentence(),
            'attachment' => null,
        ];
    }
}