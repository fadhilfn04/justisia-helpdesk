<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class CheckTicketSLA extends Command
{
    protected $signature = 'tickets:check-sla';
    protected $description = 'Menandai tiket yang melewati batas SLA';

    public function handle()
    {
        $expiredTickets = Ticket::where('status', '!=', 'closed')
            ->whereNotNull('sla_due_at')
            ->where('sla_due_at', '<', now())
            ->get();

        foreach ($expiredTickets as $ticket) {
            $ticket->status = 'overdue';
            $ticket->save();

            NotificationService::send(
                $ticket->assigned_to,
                'Tiket Melewati SLA',
                "Tiket #{$ticket->id} telah melewati batas waktu SLA."
            );
        }

        $this->info("SLA check selesai. {$expiredTickets->count()} tiket overdue.");
    }
}
