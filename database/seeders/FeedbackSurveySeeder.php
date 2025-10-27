<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\FeedbackSurvey;
use App\Models\User;

class FeedbackSurveySeeder extends Seeder
{
    public function run(): void
    {
        $tickets = Ticket::whereIn('status', ['resolved', 'closed'])->get();

        foreach ($tickets as $ticket) {
            FeedbackSurvey::create([
                'ticket_id' => $ticket->id,
                'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
                'rating' => rand(3, 5),
                'comment' => fake('id_ID')->sentence(rand(8, 15)),
                'created_at' => now(),
            ]);
        }
    }
}