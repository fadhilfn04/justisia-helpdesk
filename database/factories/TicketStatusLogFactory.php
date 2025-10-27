<?php

namespace Database\Factories;

use App\Models\TicketStatusLog;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketStatusLogFactory extends Factory
{
    protected $model = TicketStatusLog::class;

    public function definition(): array
    {
        $statuses = ['open', 'in_progress', 'resolved', 'closed'];
        $old = $this->faker->randomElement($statuses);
        $new = $this->faker->randomElement(array_diff($statuses, [$old]));

        return [
            'ticket_id' => Ticket::inRandomOrder()->first()?->id ?? Ticket::factory(),
            'changed_by' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'old_status' => $old,
            'new_status' => $new,
            'note' => $this->faker->randomElement([
                'Status diubah karena tiket sedang dikerjakan.',
                'Permasalahan sudah ditindaklanjuti.',
                'Tiket ditutup setelah mendapatkan konfirmasi dari pengguna.',
                'Masih menunggu respon dari pengguna.',
            ]),
            'created_at' => now(),
        ];
    }
}