<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketMessage;

class TicketMessageSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = Ticket::all();
        $users = User::all();

        foreach ($tickets as $ticket) {
            $count = rand(2, 5);
            for ($i = 0; $i < $count; $i++) {
                TicketMessage::create([
                    'ticket_id' => $ticket->id,
                    'sender_id' => $users->random()->id,
                    'message' => fake('id_ID')->sentence(rand(5, 10)),
                    'created_at' => now()->subDays(rand(0, 5)),
                ]);
            }
        }
    }
}