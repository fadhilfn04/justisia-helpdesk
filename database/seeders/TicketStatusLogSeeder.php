<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketStatusLog;

class TicketStatusLogSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['open', 'in_progress', 'resolved', 'closed'];
        $tickets = Ticket::all();
        $users = User::all();

        foreach ($tickets as $ticket) {
            $historyCount = rand(2, 4);
            $previousStatus = null;

            for ($i = 0; $i < $historyCount; $i++) {
                $newStatus = $statuses[$i] ?? 'closed';

                TicketStatusLog::create([
                    'ticket_id' => $ticket->id,
                    'sender_id' => $users->random()->id,
                    'changed_by' => $users->random()->id,
                    'old_status' => $previousStatus,
                    'new_status' => $newStatus,
                    'created_at' => now()->subDays(rand(0, 7)),
                ]);

                $previousStatus = $newStatus;
            }
        }
    }
}