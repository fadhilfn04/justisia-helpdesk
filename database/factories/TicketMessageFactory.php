<?php

namespace Database\Factories;

use App\Models\TicketMessage;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketMessageFactory extends Factory
{
    protected $model = TicketMessage::class;

    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::inRandomOrder()->first()?->id ?? Ticket::factory(),
            'sender_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'message' => $this->faker->randomElement([
                'Halo, saya mengalami kendala pada sistem login.',
                'Mohon bantuannya, aplikasi sering error saat upload file.',
                'Terima kasih atas respon cepatnya.',
                'Masalah sudah saya coba perbaiki tapi masih sama.',
                'Tolong dicek ya, ini cukup mendesak.'
            ]),
            'attachment' => null,
            'created_at' => now(),
        ];
    }
}